<?php

global $xoopsUser ;

include XOOPS_ROOT_PATH.'/header.php';

include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$user_access = new user_access( $mydirname ) ;
$mydownload = new MyDownload( $mydirname ) ;

$total = $error = 0 ;
$mylink = $category4assin = array() ;

$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
$whr_cat4read = "d.".$whr_cat ;

if( is_object( $xoopsUser ) ) {
	$xoops_isuser = true ;
	$xoops_userid = $xoopsUser->getVar('uid') ;
	$xoops_uname = $xoopsUser->getVar('uname') ;
	$module_handler =& xoops_gethandler( 'module' ) ;
	$module =& $module_handler->getByDirname( $mydirname ) ;
	$mid = $module->getVar('mid') ;
	$module_admin = $xoopsUser->isAdmin( $mid ) ;
} else {
	$xoops_isuser = false ;
	$xoops_userid = 0 ;
	$xoops_uname = '' ;
	$module_admin = false ;
}

$_GET = d3download_delete_nullbyte( $_GET ) ;

$cid = empty( $_GET['cid'] ) ? 0 : intval( $_GET['cid'] ) ;
$intree = empty( $_GET['intree'] ) ? 0 : 1 ;

$xoopsTpl->assign( 'category_id', $cid ) ;
$xoopsTpl->assign( 'intree', $intree );

$orderby = d3download_selected_order( $mydirname ) ;
$xoopsTpl->assign('lang_cursortedby', sprintf( _MD_D3DOWNLOADS_CURSORTBY, d3download_convertorderbytrans( $orderby ) ) ) ;
$perpage4assign = d3download_items_perpage() ;
$select_perpage = d3download_select_perpage( $mydirname ) ;
$current_start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0 ;
$select_intree = d3download_select_intree() ;

$xoopsTpl->assign( 'perpage' , $perpage4assign ) ; 
$xoopsTpl->assign( 'select_perpage' , $select_perpage ) ; 
$xoopsTpl->assign( 'select_intree' , $select_intree ) ; 

if ( isset( $_POST['add_mylink'] ) ) {
	$lid = intval( $_POST['lid'] ) ;
	$error = $mydownload->add_mylink( $lid ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=mylink" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_ADD_MYLINK_DONE ) ;
	exit ;
} elseif ( isset($_POST['del_mylink'] ) ) {
	$lid = intval( $_POST['lid'] ) ;
	$error = $mydownload->del_mylink( $lid ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=mylink" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_DEL_MYLINK_DONE ) ;
	exit ;
} elseif ( isset($_POST['del_allmylink'] ) && $mydownload->is_mylink() ) {
	$error = $mydownload->all_delete_mylink() ;
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=mylink" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_DEL_MYLINK_DONE ) ;
	exit ;
}

$xoopsTpl->assign( 'categories' , d3download_getsub_categories( $mydirname, $cid , $whr_cat ) ) ; 
$category4assin = $mydownload->mylink_categories_selbox( $whr_cat ) ;
$lang_directcatsel = _MD_D3DOWNLOADS_SEL_CATEGORY ;
$canuseshots = ! empty( $xoopsModuleConfig['useshots'] ) ? 1 : 0 ;
$xoopsOption['template_main'] = $mydirname.'_main_viewcat.html' ;

$total = $mydownload->total_mylink( $cid, $whr_cat, $intree ) ;
$mylink = $mydownload->get_downdata_for_mylink( $cid, $whr_cat4read, $orderby, $select_perpage, $current_start, $intree ) ;

$total_view = empty( $cid ) ? _MD_D3DOWNLOADS_TOTAL_MYLINK : _MD_D3DOWNLOADS_CATEGORY_MYLINK  ;
$total_num = sprintf( $total_view , $total )  ;
$xoopsTpl->assign( 'download_total_num' , $total_num ) ;

require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;
$orderby4pagenav = d3download_convertorderbyout( $orderby ) ;
$pagenavarg = "page=mylink&amp;cid=".$cid."&amp;intree=".$intree."&amp;orderby=".$orderby4pagenav."&amp;perpage=".$select_perpage;
$pagenav = new XoopsPageNav( $total, $select_perpage, $current_start , 'start' , $pagenavarg ) ;
$pagenav4assign = $pagenav->renderNav( 5 ) ;
$orderbyarg = "index.php?page=mylink&amp;cid=".$cid."&amp;intree=".$intree."&amp;perpage=".$select_perpage ;

$xoopsTpl->assign( 'pagenav' , $pagenav4assign ) ; 
$xoopsTpl->assign( 'argument' , $orderbyarg ) ; 
$xoopsTpl->assign( 'orderby' , $orderby4pagenav ) ; 
$pagetitle = sprintf( _MD_D3DOWNLOADS_MYLINK_TITLE , $mydownload->get_postname( $xoops_userid ) ) ;

$bc[0] = d3download_breadcrumbs( $mydirname ) ;
$breadcrumbs_tree = d3download_breadcrumbs_tree( $mydirname, $cid, $whr_cat, "index.php?page=mylink" ) ;
$bc[] = ( empty( $breadcrumbs_tree ) ) ? array( 'name' => $pagetitle ) : array( 'url' => 'index.php?page=mylink' , 'name' => $pagetitle ) ;
$breadcrumbs = array_merge( $bc, $breadcrumbs_tree ) ;
$mod_url = XOOPS_URL.'/modules/'.$mydirname ;

$xoops_module_header = d3download_dbmoduleheader( $mydirname ) ;
$xoopsTpl->assign( 'xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars('xoops_module_header' ) ) ;

// assign
$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => $mod_url ,
	'file' => $mylink ,
	'mylink' => 1 ,
	'category' => $category4assin ,
	'lang_directcatsel' => $lang_directcatsel ,
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'module_admin' => $module_admin ,
	'xoops_config' => $xoopsConfig ,
	'mod_config' => $xoopsModuleConfig ,
	'canuseshots' => $canuseshots ,
	'xoops_pagetitle' => $pagetitle ,
	'xoops_breadcrumbs' => $breadcrumbs ,
) ) ;
// display
include XOOPS_ROOT_PATH.'/footer.php';

?>