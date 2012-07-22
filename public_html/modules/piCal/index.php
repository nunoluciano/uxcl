<?php

// piCal xoops用メインモジュール
// index.php
// カレンダーの表示・編集・更新処理
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)

	require( '../../mainfile.php' ) ;

	// for "Duplicatable"
	$mydirname = basename( dirname( __FILE__ ) ) ;
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;

	// 言語テスト用
	// $xoopsConfig[ 'language' ] = 'french' ;

	// MySQLへの接続
	// $conn = mysql_connect( XOOPS_DB_HOST , XOOPS_DB_USER , XOOPS_DB_PASS ) or die( "Could not connect." ) ;
	// mysql_select_db( XOOPS_DB_NAME , $conn ) ;
	$conn = $xoopsDB->conn ;

	// setting physical & virtual paths
	$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
	$mod_url = XOOPS_URL."/modules/$mydirname" ;
	$xoopsTpl->assign( "mod_url" , $mod_url ) ;
	
	// クラス定義の読み込み
	if( ! class_exists( 'piCal_xoops' ) ) {
		require_once( "$mod_path/class/piCal.php" ) ;
		require_once( "$mod_path/class/piCal_xoops.php" ) ;
	}

	// GET,POST変数の取得・前処理
	if( empty( $_GET['action'] ) && ! empty( $_GET['event_id'] ) ) $_GET['action'] = 'View' ;

	if( isset( $_GET[ 'action' ] ) ) $action = $_GET[ 'action' ] ;
	else $action = '' ;

	// creating an instance of piCal 
	$cal = new piCal_xoops( "" , $xoopsConfig['language'] , true ) ;

	// setting properties of piCal
	$cal->conn = $conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->base_url = $mod_url ;
	$cal->base_path = $mod_path ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;


	// データベース更新関係の処理（いずれも、Locationで飛ばす）
	if( isset( $_POST[ 'update' ] ) ) {
		// 更新
		if( ! $editable ) die( _MB_PICAL_ERR_NOPERMTOUPDATE ) ;
		// Ticket Check
		if ( ! $xoopsGTicket->check() ) {
			redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
		}
		$cal->update_schedule( "$admission_update_sql" , $whr_sql_append ) ;
	} else if( isset( $_POST[ 'insert' ] ) || isset( $_POST[ 'saveas' ] ) ) {
		// saveas または 新規登録
		if( ! $insertable ) die( _MB_PICAL_ERR_NOPERMTOINSERT ) ;
		$_POST[ 'event_id' ] = "" ;
		// Ticket Check
		if ( ! $xoopsGTicket->check() ) {
			redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
		}
		$cal->update_schedule( ",uid='$user_id' $admission_insert_sql" , '' , 'notify_new_event' ) ;
	} else if( ! empty( $_POST[ 'delete' ] ) ) {
		// 削除
		if( ! $deletable ) die( _MB_PICAL_ERR_NOPERMTODELETE ) ;
		// Ticket Check
		if ( ! $xoopsGTicket->check() ) {
			redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
		}
		$cal->delete_schedule( $whr_sql_append , 'global $xoopsModule; xoops_comment_delete($xoopsModule->mid(),$id);' ) ;
	} else if( ! empty( $_POST[ 'delete_one' ] ) ) {
		// 一件削除
		if( ! $deletable ) die( _MB_PICAL_ERR_NOPERMTODELETE ) ;
		// Ticket Check
		if ( ! $xoopsGTicket->check() ) {
			redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
		}
		$cal->delete_schedule_one( $whr_sql_append ) ;
	} else if( ! empty( $_GET[ 'output_ics' ] ) /* || ! empty( $_POST[ 'output_ics' ] ) */ ) {
		// output ics
		$cal->output_ics( ) ;
	}

	// smodeの処理
	if( ! empty( $_GET[ 'smode' ] ) ) $smode = $_GET[ 'smode' ] ;
	else $smode = $default_view ;

	// XOOPヘッダ出力前の処理
	if( $action == 'View' ) {
		$xoopsOption['template_main'] = "pical{$mydirnumber}_event_detail.html" ;
	} else {
		// View以外ではコメント禁止
		$xoopsModuleConfig['com_rule'] = 0 ;
		if( $smode == 'List' && $action != 'Edit' ) {
			$xoopsOption['template_main'] = "pical{$mydirnumber}_event_list.html" ;
		}
	}

	// XOOPSヘッダ出力
	include( XOOPS_ROOT_PATH.'/header.php' ) ;

	// embed style sheet の出力 (thx Ryuji)
	$xoopsTpl->assign( "xoops_module_header" , "<style><!-- \n" . $cal->get_embed_css() . "\n--></style>\n" . $xoopsTpl->get_template_vars( "xoops_module_header" ) ) ;

	// クローラーにリンクをへつらせない follow -> nofollow
	$meta_robots = str_replace( ',follow' , ',nofollow' , $xoopsTpl->get_template_vars( "xoops_meta_robots" ) ) ;
	$xoopsTpl->assign( "xoops_meta_robots" , $meta_robots ) ;
	
	// meta "description"
	$pical_meta_description = "" ; // naao

        // モジュールID  // added by naao
        $module_handler =& xoops_gethandler('module');
        $this_module =& $module_handler->getByDirname($mydirname);
        $mid = $this_module->getVar('mid');
 
        // モジュールconfig  // added by naao
        $config_handler =& xoops_gethandler("config");
        $mod_config = $config_handler->getConfigsByCat(0, $mid);
        $xoopsTpl->assign("moduleConfig", $mod_config);

	// 実行時間計測スタート
	// list( $usec , $sec ) = explode( " " , microtime() ) ;
	// $picalstarttime = $sec + $usec ;

	// ページ表示関連の処理分け
	if( $action == 'Edit' ) {
		if( is_dir( XOOPS_ROOT_PATH . '/common/jscalendar' ) ) {
			// jscalendar in common (recommend)
			$jscalurl = XOOPS_URL . '/common/jscalendar' ;
			$xoopsTpl->assign( 'xoops_module_header' , '
				<link rel="stylesheet" type="text/css" media="all" href="'.$jscalurl.'/calendar-system.css" title="system" />
				<script type="text/javascript" src="'.$jscalurl.'/calendar.js"></script>
				<script type="text/javascript" src="'.$jscalurl.'/lang/'.$cal->jscalendar_lang_file.'"></script>
				<script type="text/javascript" src="'.$jscalurl.'/calendar-setup.js"></script>
			' . $xoopsTpl->get_template_vars( "xoops_module_header" ) ) ;
			$cal->jscalendar = 'jscalendar' ;
		} else if( is_dir( XOOPS_ROOT_PATH . '/class/calendar' ) ) {
			// jscalendar in XOOPS 2.2 core
			$jscalurl = XOOPS_URL . '/class/calendar' ;
			$xoopsTpl->assign( 'xoops_module_header' , '
				<link rel="stylesheet" type="text/css" media="all" href="'.$jscalurl.'/CSS/calendar-blue.css" title="system" />
				<script type="text/javascript" src="'.$jscalurl.'/calendar.js"></script>
				<script type="text/javascript" src="'.$jscalurl.'/lang/'.$cal->jscalendar_lang_file.'"></script>
				<script type="text/javascript" src="'.$jscalurl.'/calendar-setup.js"></script>
			' . $xoopsTpl->get_template_vars( "xoops_module_header" ) ) ;
			$cal->jscalendar = 'jscalendar' ;
		} else {
			// older jscalendar in XOOPS 2.0.x core
			include XOOPS_ROOT_PATH.'/include/calendarjs.php' ;
			$cal->jscalendar = 'xoops' ;
		}
		echo $cal->get_schedule_edit_html( ) ;
	} else if( $action == 'View' ) {
		// echo $cal->get_schedule_view_html( ) ;
		$xoopsTpl->assign( 'detail_body' , $cal->get_schedule_view_html( ) ) ;
		$xoopsTpl->assign( 'xoops_pagetitle' , $cal->last_summary ) ;
		$xoopsTpl->assign( 'xoops_default_comment_title' , 'Re: ' . $cal->last_summary ) ;
		$xoopsTpl->assign( 'print_link' , "$mod_url/print.php?event_id=".intval($_GET['event_id'])."&action=View" ) ;
		$xoopsTpl->assign( 'com_itemid' , intval($_GET['event_id']) ) ; //added naao
		$xoopsTpl->assign( 'skinpath' , "$cal->images_url" ) ;
		$xoopsTpl->assign( 'lang_print' , _MB_PICAL_ALT_PRINTTHISEVENT ) ;

		// meta description // naao
		$pical_meta_description = $cal->event->start_datetime_str. "&nbsp;-&nbsp;" ;
		$pical_meta_description .= $cal->event->end_datetime_str. "&nbsp;:&nbsp;" ;
		$pical_meta_description .= htmlspecialchars(strip_tags($cal->event->description),ENT_QUOTES) ;
		$pical_meta_description = preg_replace('/(\r\n|\n\r|\n|\r|\t)/i','',mb_substr($pical_meta_description,0,250, _CHARSET));

		$xoopsTpl->assign( 'xoops_meta_description' , $pical_meta_description ) ;
		$HTTP_GET_VARS['event_id'] = $_GET['event_id'] = $cal->original_id ;
		include XOOPS_ROOT_PATH.'/include/comment_view.php' ;
		// patch for commentAny 
		$commentany = $xoopsTpl->get_template_vars( "commentany" ) ;
		if( ! empty( $commentany['com_itemid'] ) ) {
			$commentany['com_itemid'] = $cal->original_id ;
			$xoopsTpl->assign("commentany",$commentany);
			
		}
	} else if( isset( $_POST[ 'output_ics_confirm' ] ) && ! empty( $_POST[ 'ids' ] ) && is_array( $_POST[ 'ids' ] ) ) {
		echo $cal->output_ics_confirm( "$mod_url/" ) ;
	} else switch( $smode ) {
		case 'Yearly' :
			echo $cal->get_yearly( ) ;
			break ;
		case 'Weekly' :
			echo $cal->get_weekly( ) ;
			break ;
		case 'Daily' :
			echo $cal->get_daily( ) ;
			break ;
		case 'List' :
			$cal->assign_event_list( $xoopsTpl ) ;
			break ;
		case 'Monthly' :
		default :
			echo $cal->get_monthly( ) ;
			break ;
	}

	// For XCL 2.2 Call addMeta //naao
	if ($pical_meta_description) {
		if (defined('LEGACY_MODULE_VERSION') && version_compare(LEGACY_MODULE_VERSION, '2.2', '>=')) {
			$xclRoot =& XCube_Root::getSingleton();
			$headerScript = $xclRoot->mContext->getAttribute('headerScript');
			$headerScript->addMeta('description', $pical_meta_description);
		} elseif (isset($xoTheme) && is_object($xoTheme)) {	// for XOOPS 2.3 over
			$xoTheme->addMeta('meta', 'description', $pical_meta_description);
		}
	}

	// 実行時間表示
	// list( $usec , $sec ) = explode( " " , microtime() ) ;
	// echo "<p>" . ( $sec + $usec - $picalstarttime ) . "sec.</p>" ;

	// by Bluemoon inc.
	$header = $xoopsTpl->get_template_vars('xoops_module_header');
	$header .= '<link rel="stylesheet" type="text/css" media="all" href="style.css" />';
	$xoopsTpl->assign('xoops_module_header', $header);
	// XOOPSフッタ出力
	include( XOOPS_ROOT_PATH.'/footer.php' ) ;

?>
