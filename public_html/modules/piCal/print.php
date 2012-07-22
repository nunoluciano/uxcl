<?php
// piCal xoops用印刷ページ
// print.php
// カレンダーの印刷用画面表示
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)

require( '../../mainfile.php' ) ;
require_once( XOOPS_ROOT_PATH.'/class/template.php' ) ;

// for "Duplicatable"
$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

$conn = $xoopsDB->conn ;

// setting physical & virtual paths
$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
$mod_url = XOOPS_URL."/modules/$mydirname" ;

// クラス定義の読み込み
if( ! class_exists( 'piCal_xoops' ) ) {
	require_once( "$mod_path/class/piCal.php" ) ;
	require_once( "$mod_path/class/piCal_xoops.php" ) ;
}

// creating an instance of piCal 
$cal = new piCal_xoops( "" , $xoopsConfig['language'] , true ) ;

// setting properties of piCal
$cal->conn = $conn ;
include( "$mod_path/include/read_configs.php" ) ;
$cal->base_url = $mod_url ;
$cal->base_path = $mod_path ;
$cal->images_url = "$mod_url/images/$skin_folder" ;
$cal->images_path = "$mod_path/images/$skin_folder" ;


// Include our module's language file
if( file_exists(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/language/'.$xoopsConfig['language'].'/main.php') ) {
	require_once(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/language/'.$xoopsConfig['language'].'/main.php');
	require_once(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/language/'.$xoopsConfig['language'].'/modinfo.php');
} else {
	require_once(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/language/english/main.php');
	require_once(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/language/english/modinfo.php');
}

$myts =& MyTextSanitizer::getInstance();

header( 'Content-Type:text/html; charset=' . _CHARSET ) ;
$tpl = new XoopsTpl();
$tpl->xoops_setTemplateDir(XOOPS_ROOT_PATH.'/themes');
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(0);

$tpl->assign('for_print', true);

$tpl->assign('charset', _CHARSET);
$tpl->assign('sitename', $xoopsConfig['sitename']);
$tpl->assign('site_url', XOOPS_URL);

$tpl->assign('lang_comesfrom', sprintf(_MB_PICAL_COMESFROM, $xoopsConfig['sitename']));


// ページ表示関連の処理分け
//+2012/1/09 11:04:05 ,uid=unkown ,ip=207.46.204.242 ,host=msnbot-207-46-204-242.search.msn.com ,mid=94(piCal)
// Notice [PHP]: Undefined index: smode in file modules/piCal/print.php line 68

$smode = isset($_GET['smode']) ? $myts->stripSlashesGPC($_GET['smode']) : '';
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
if( ! empty( $event_id ) ) {
	$tpl->assign('contents', $cal->get_schedule_view_html( true ) ) ;
} else switch( $smode ) {
	case 'Yearly' :
		$tpl->assign('for_event_list', false ) ;
		$tpl->assign('contents', $cal->get_yearly( '' , '' , true ) ) ;
		break ;
	case 'Weekly' :
		$tpl->assign('for_event_list', false ) ;
		$tpl->assign('contents', $cal->get_weekly( '' , '' , true ) ) ;
		break ;
	case 'Daily' :
		$tpl->assign('for_event_list', false ) ;
		$tpl->assign('contents', $cal->get_daily( '' , '' , true ) ) ;
		break ;
	case 'List' :
		$tpl->assign('for_event_list', true ) ;
		$cal->assign_event_list( $tpl ) ;
		break ;
	case 'Monthly' :
	default :
		$tpl->assign('for_event_list', false ) ;
		$tpl->assign('contents', $cal->get_monthly( '' , '' , true ) ) ;
		break ;
}

$tpl->display("db:pical{$mydirnumber}_print.html");
?>