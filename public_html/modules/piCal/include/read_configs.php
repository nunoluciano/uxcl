<?php
	// ������ɤ߽Ф��ȸ��¤�����˴ؤ��붦��include�ե�����
	// mbstring�Υ��ߥ�졼�ȴؿ��⤳�����������
	// ���餫���ᡢpiCal���֥������Ȥ� $cal �Ȥ��ƺ������Ƥ���

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
			// 'pical_' ����Ϥޤ��Τ� piCal���֥������ȤΥץ�ѥƥ�
			$property = substr( $key , 6 ) ;
			if( isset( $cal->$property ) ) $cal->$property = $val ;
		} else {
			// 'pical_' ����Ϥޤ�ʤ���Τ� xoops¦��������ѿ��Ȥ��Ƽ�����
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

	// xoops ����桼������μ��� (�����Ȥʤ�user_id=0)
	if( is_object( $xoopsUser ) ) {
		// ��Ͽ�桼���ʤ�Timezone,uid�������
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

			// �����Ԥθ��¡ʴ����Ԥ��ѹ������鼫ưŪ�˾�ǧ�Ȥ����
			$insertable = true ;
			$editable = true ;
			$deletable = true ;
			$admission_insert_sql = ',admission=1' ;
			$admission_update_sql = ',admission=1' ;
			$whr_sql_append = '' ;

			// �����ԤΥ��ƥ��ꥢ���������¡������ƥ����
			$sql = "SELECT cid,pid,cat_title,cat_desc,ismenuitem,cat_depth FROM $cal->cat_table ORDER BY weight" ;
			$rs = mysql_query( $sql ) ;
			$cal->categories = array() ;
			while( $cat = mysql_fetch_object( $rs ) ) {
				$cal->categories[ intval( $cat->cid ) ] = $cat ;
			}

			// �����Ԥ������롼�פ������ǽ
			$cal->groups =& $system_groups ;

		} else {

			// ���̥桼���ϼ�ʬ�ν�°���륰�롼�פΤ�
			$my_group_ids = $member_handler->getGroupsByUser( $user_id ) ;
			$cal->groups = array() ;
			$ids4sql = '(' ;
			foreach( $my_group_ids as $id ) {
				$cal->groups[ $id ] = $system_groups[ $id ] ;
				$ids4sql .= "$id," ;
			}
			$ids4sql .= "0)" ;

			// ���̥桼���Υ��ƥ��ꥢ����������
			$sql = "SELECT distinct cid,pid,cat_title,cat_desc,ismenuitem,cat_depth FROM $cal->cat_table LEFT JOIN ".$xoopsDB->prefix('group_permission')." ON cid=gperm_itemid WHERE gperm_name='pical_cat' AND gperm_modid='$mid' AND enabled AND gperm_groupid IN $ids4sql ORDER BY weight" ;
			$rs = mysql_query( $sql ) ;
			$cal->categories = array() ;
			while( $cat = mysql_fetch_object( $rs ) ) {
				$cal->categories[ intval( $cat->cid ) ] = $cat ;
			}

			// ���̥桼���Υ����Х븢��
			if( $users_authority & 256 ) {

				// groupperm �ǡ��ġ��Υ��롼�פ��Ȥ�����
				$gperm_handler =& xoops_gethandler( 'groupperm' ) ;

				// ��Ͽ����
				$insertable = $gperm_handler->checkRight( 'pical_global' , 1 , $my_group_ids , $mid ) ;
				if( $insertable && $gperm_handler->checkRight( 'pical_global' , 2 , $my_group_ids , $mid ) ) $admission_insert_sql = ',admission=1' ;
				else $admission_insert_sql = ',admission=0' ;

				// �Խ�����
				$editable = $gperm_handler->checkRight( 'pical_global' , 4 , $my_group_ids , $mid ) ;
				if( $editable && $gperm_handler->checkRight( 'pical_global' , 8 , $my_group_ids , $mid ) ) $admission_update_sql = ',admission=1' ;
				else $admission_update_sql = ',admission=0' ;

				// ������¡ʺ����ǧ�λ��Ȥ��ޤ��ʤΤǡ�̵������Τߡ�
				$deletable = $gperm_handler->checkRight( 'pical_global' , 32 , $my_group_ids , $mid ) ;

				// �Ȥꤢ������¾�ͤΥ쥳���ɤϤ����餻�ʤ�
				$whr_sql_append = "AND uid=$user_id " ;

			} else if( $users_authority & 1 ) {
				// ��Ͽ�Ĥʤ��Խ���ġʤ�����user_id�����פ���ɬ�פ������
				$insertable = true ;
				$editable = true ;
				$whr_sql_append = "AND uid=$user_id " ;
				if( $users_authority & 2 ) {
					// ��ǧ������ʤ������Խ�������⾵ǧ����
					$deletable = true ;
					$admission_insert_sql = ',admission=1' ;
					$admission_update_sql = '' ;
				} else {
					// ��ǧ��ɬ�פʾ��ϡ��������Խ������龵ǧɬ��
					// ����ˤĤ��Ƥϡ������ǧ�λ��Ȥߤ���ޤ�̵����Ե���
					$deletable = false ;
					$admission_insert_sql = ',admission=0' ;
					$admission_update_sql = ',admission=0' ;
				}
			} else {
				// ��Ͽ�ԲĤʤ餹�٤��Ե���
				$insertable = $editable = $deletable = false ;
				$admission_insert_sql = $admission_update_sql = '' ;
				$whr_sql_append = 'AND 0' ;
			}
		}
	} else {
		// �����Ȥʤ�default_TZ��桼����Timezone�ȸ��ʤ�
		$cal->user_TZ = $xoopsConfig['default_TZ'] ;
		if( $cal->user_TZ != $cal->server_TZ && $cal->use_server_TZ ) {
			$tzoffset = ( $cal->user_TZ - $cal->server_TZ ) * 3600 ;
			$cal->set_date( date( 'Y-n-j' , time() + $tzoffset ) ) ;
		}

		// �����ȤΥ��ƥ��ꥢ����������
		$sql = "SELECT distinct cid,pid,cat_title,cat_desc,ismenuitem,cat_depth FROM $cal->cat_table LEFT JOIN ".$xoopsDB->prefix('group_permission')." ON cid=gperm_itemid WHERE gperm_name='pical_cat' AND gperm_modid='$mid' AND enabled AND gperm_groupid='".XOOPS_GROUP_ANONYMOUS."' ORDER BY weight" ;
		$rs = mysql_query( $sql ) ;
		$cal->categories = array() ;
		while( $cat = mysql_fetch_object( $rs ) ) {
			$cal->categories[ intval( $cat->cid ) ] = $cat ;
		}

		// �����ȤΥ����Х븢��
		$user_id = 0 ;
		$isadmin = false ;
		$insertable = ( $guests_authority & 1 ) ? true : false ;
		$editable = false ;		// �����ȤϾ���Խ����¤ʤ�
		$deletable = false ;	// �����ȤϾ�˺�����¤ʤ�
		$admission_insert_sql = ',admission='.(($guests_authority&2)?'1':'0');
		$admission_update_sql = '' ;
		// �����Ȥ����������롼�������Բ�
		$cal->groups = array() ;
	}

	// �Ƽ︢�¤�piCal���֥������Ȥؤ���Ͽ
	$cal->insertable = $insertable ;
	$cal->editable = $editable ;
	$cal->deletable = $deletable ;
	$cal->user_id = $user_id ;
	$cal->isadmin = $isadmin ;

	// ��������ɹ�ľ��
	if( ! empty( $cal->locale ) ) $cal->read_locale() ;

	// mbstring�Τʤ�PHP���Ф��륨�ߥ�졼��
	// mb_strcut�Υ��ߥ�졼��
	if( ! function_exists( 'mb_strcut' ) ) {
		function mb_strcut( $str , $start , $len ) {
			// 2�Х��ȴĶ��ʤ饫�åȤ��ʤ�
			// 1�Х��ȴĶ��ʤ���ľ��substr
			if( XOOPS_USE_MULTIBYTES ) return $str ;
			else return substr( $str , $start , $len ) ;
		}
	}
	// mb_convert_encoding�Υ��ߥ�졼�ȡʲ��⤷�ʤ���
	if( ! function_exists( 'mb_convert_encoding' ) ) {
		function mb_convert_encoding( $str , $from , $to = "auto" ) {
			return $str ;
		}
	}

?>
