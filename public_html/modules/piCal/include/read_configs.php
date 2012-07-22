<?php
	// 設定の読み出しと権限の設定に関する共通includeファイル
	// mbstringのエミュレート関数もここで定義する
	// あらかじめ、piCalオブジェクトを $cal として作成しておく

	if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

	// for "Duplicatable"
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
	$cal->table = $xoopsDB->prefix( "pical{$mydirnumber}_event" ) ;
	$cal->cat_table = $xoopsDB->prefix( "pical{$mydirnumber}_cat" ) ;
	$cal->plugin_table = $xoopsDB->prefix( "pical{$mydirnumber}_plugins" ) ;

	global $xoopsDB , $xoopsUser , $xoopsConfig ;

	// anti-XoopsErrorHandler
	// restore_error_handler() ;

	// piCal cannot work without Protector's BigUmbrella.
	$rs= $xoopsDB->query( "SELECT conf_value FROM ".$xoopsDB->prefix('config')." WHERE conf_name='enable_bigumbrella'" ) ;
	@list( $bigumbrella_enabled ) = $xoopsDB->fetchRow( $rs ) ;
	if( empty( $bigumbrella_enabled ) ) {
		die( 'piCal cannot work without Protector\'s BigUmbrella anti-XSS.' ) ;
	}

	// get my mid
	$rs = $xoopsDB->query( "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname LIKE '$mydirname'" ) ;
	list( $mid ) = $xoopsDB->fetchRow( $rs ) ;

	// read from xoops_config
	$rs= $xoopsDB->query( "SELECT conf_name,conf_value FROM ".$xoopsDB->prefix('config')." WHERE conf_modid=$mid" ) ;
	while( list( $key , $val ) = $xoopsDB->fetchRow( $rs ) ) {
		if( strncmp( $key , "pical_" , 6 ) == 0 ) {
			// 'pical_' から始まるものは piCalオブジェクトのプロパティ
			$property = substr( $key , 6 ) ;
			if( isset( $cal->$property ) ) $cal->$property = $val ;
		} else {
			// 'pical_' から始まらないものは xoops側の設定（変数として取得）
			$$key = $val ;
		}
	}

	// get server timezone
	switch( $timezone_using ) {
		case 'xoops' :
			$cal->server_TZ = $xoopsConfig['server_TZ'] ;
			break ;
		case 'summer' :
			$cal->server_TZ = date( 'Z' , 1120176000 ) / 3600 ;
			break ;
		case 'winter' :
		default :
			$cal->server_TZ = date( 'Z' , 1104537600 ) / 3600 ;
			break ;
	}

	// xoops からユーザ情報の取得 (ゲストならuser_id=0)
	if( is_object( $xoopsUser ) ) {
		// 登録ユーザならTimezone,uid等を取得
		$cal->user_TZ = $xoopsUser->timezone() ;
		if( $cal->user_TZ != $cal->server_TZ && $cal->use_server_TZ ) {
			$tzoffset = ( $cal->user_TZ - $cal->server_TZ ) * 3600 ;
			$cal->set_date( date( 'Y-n-j' , time() + $tzoffset ) ) ;
		}
		$user_id = $xoopsUser->uid() ;
		$isadmin = $xoopsUser->isadmin( $mid ) ;

		$member_handler =& xoops_gethandler('member');
		$system_groups = $member_handler->getGroupList() ;

		if( $isadmin ) {

			// 管理者の権限（管理者が変更したら自動的に承認とする）
			$insertable = true ;
			$editable = true ;
			$deletable = true ;
			$admission_insert_sql = ',admission=1' ;
			$admission_update_sql = ',admission=1' ;
			$whr_sql_append = '' ;

			// 管理者のカテゴリアクセス権限（全カテゴリ）
			$sql = "SELECT cid,pid,cat_title,cat_desc,ismenuitem,cat_depth FROM $cal->cat_table ORDER BY weight" ;
			$rs = mysql_query( $sql ) ;
			$cal->categories = array() ;
			while( $cat = mysql_fetch_object( $rs ) ) {
				$cal->categories[ intval( $cat->cid ) ] = $cat ;
			}

			// 管理者は全グループを管理可能
			$cal->groups =& $system_groups ;

		} else {

			// 一般ユーザは自分の所属するグループのみ
			$my_group_ids = $member_handler->getGroupsByUser( $user_id ) ;
			$cal->groups = array() ;
			$ids4sql = '(' ;
			foreach( $my_group_ids as $id ) {
				$cal->groups[ $id ] = $system_groups[ $id ] ;
				$ids4sql .= "$id," ;
			}
			$ids4sql .= "0)" ;

			// 一般ユーザのカテゴリアクセス権限
			$sql = "SELECT distinct cid,pid,cat_title,cat_desc,ismenuitem,cat_depth FROM $cal->cat_table LEFT JOIN ".$xoopsDB->prefix('group_permission')." ON cid=gperm_itemid WHERE gperm_name='pical_cat' AND gperm_modid='$mid' AND enabled AND gperm_groupid IN $ids4sql ORDER BY weight" ;
			$rs = mysql_query( $sql ) ;
			$cal->categories = array() ;
			while( $cat = mysql_fetch_object( $rs ) ) {
				$cal->categories[ intval( $cat->cid ) ] = $cat ;
			}

			// 一般ユーザのグローバル権限
			if( $users_authority & 256 ) {

				// groupperm で、個々のグループごとに設定
				$gperm_handler =& xoops_gethandler( 'groupperm' ) ;

				// 登録権限
				$insertable = $gperm_handler->checkRight( 'pical_global' , 1 , $my_group_ids , $mid ) ;
				if( $insertable && $gperm_handler->checkRight( 'pical_global' , 2 , $my_group_ids , $mid ) ) $admission_insert_sql = ',admission=1' ;
				else $admission_insert_sql = ',admission=0' ;

				// 編集権限
				$editable = $gperm_handler->checkRight( 'pical_global' , 4 , $my_group_ids , $mid ) ;
				if( $editable && $gperm_handler->checkRight( 'pical_global' , 8 , $my_group_ids , $mid ) ) $admission_update_sql = ',admission=1' ;
				else $admission_update_sql = ',admission=0' ;

				// 削除権限（削除承認の仕組がまだなので、無条件削除のみ）
				$deletable = $gperm_handler->checkRight( 'pical_global' , 32 , $my_group_ids , $mid ) ;

				// とりあえず、他人のレコードはいじらせない
				$whr_sql_append = "AND uid=$user_id " ;

			} else if( $users_authority & 1 ) {
				// 登録可なら編集も可（ただしuser_idが一致する必要がある）
				$insertable = true ;
				$editable = true ;
				$whr_sql_append = "AND uid=$user_id " ;
				if( $users_authority & 2 ) {
					// 承認がいらない場合は編集・削除も承認不要
					$deletable = true ;
					$admission_insert_sql = ',admission=1' ;
					$admission_update_sql = '' ;
				} else {
					// 承認が必要な場合は、新規・編集したら承認必要
					// 削除については、削除承認の仕組みを作るまで無条件不許可
					$deletable = false ;
					$admission_insert_sql = ',admission=0' ;
					$admission_update_sql = ',admission=0' ;
				}
			} else {
				// 登録不可ならすべて不許可
				$insertable = $editable = $deletable = false ;
				$admission_insert_sql = $admission_update_sql = '' ;
				$whr_sql_append = 'AND 0' ;
			}
		}
	} else {
		// ゲストならdefault_TZをユーザのTimezoneと見なす
		$cal->user_TZ = $xoopsConfig['default_TZ'] ;
		if( $cal->user_TZ != $cal->server_TZ && $cal->use_server_TZ ) {
			$tzoffset = ( $cal->user_TZ - $cal->server_TZ ) * 3600 ;
			$cal->set_date( date( 'Y-n-j' , time() + $tzoffset ) ) ;
		}

		// ゲストのカテゴリアクセス権限
		$sql = "SELECT distinct cid,pid,cat_title,cat_desc,ismenuitem,cat_depth FROM $cal->cat_table LEFT JOIN ".$xoopsDB->prefix('group_permission')." ON cid=gperm_itemid WHERE gperm_name='pical_cat' AND gperm_modid='$mid' AND enabled AND gperm_groupid='".XOOPS_GROUP_ANONYMOUS."' ORDER BY weight" ;
		$rs = mysql_query( $sql ) ;
		$cal->categories = array() ;
		while( $cat = mysql_fetch_object( $rs ) ) {
			$cal->categories[ intval( $cat->cid ) ] = $cat ;
		}

		// ゲストのグローバル権限
		$user_id = 0 ;
		$isadmin = false ;
		$insertable = ( $guests_authority & 1 ) ? true : false ;
		$editable = false ;		// ゲストは常に編集権限なし
		$deletable = false ;	// ゲストは常に削除権限なし
		$admission_insert_sql = ',admission='.(($guests_authority&2)?'1':'0');
		$admission_update_sql = '' ;
		// ゲストは当然、グループ選択不可
		$cal->groups = array() ;
	}

	// 各種権限のpiCalオブジェクトへの登録
	$cal->insertable = $insertable ;
	$cal->editable = $editable ;
	$cal->deletable = $deletable ;
	$cal->user_id = $user_id ;
	$cal->isadmin = $isadmin ;

	// ロケールの読込直し
	if( ! empty( $cal->locale ) ) $cal->read_locale() ;

	// mbstringのないPHPに対するエミュレート
	// mb_strcutのエミュレート
	if( ! function_exists( 'mb_strcut' ) ) {
		function mb_strcut( $str , $start , $len ) {
			// 2バイト環境ならカットしない
			// 1バイト環境なら素直にsubstr
			if( XOOPS_USE_MULTIBYTES ) return $str ;
			else return substr( $str , $start , $len ) ;
		}
	}
	// mb_convert_encodingのエミュレート（何もしない）
	if( ! function_exists( 'mb_convert_encoding' ) ) {
		function mb_convert_encoding( $str , $from , $to = "auto" ) {
			return $str ;
		}
	}

?>
