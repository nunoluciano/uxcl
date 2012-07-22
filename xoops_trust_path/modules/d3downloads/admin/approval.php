<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/unapproval_download.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
require_once dirname( dirname(__FILE__) ).'/include/transact_functions.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

global $xoopsUser , $xoopsModuleConfig ;

// THIS PAGE CAN BE CALLED ONLY FROM D3DOWNLOADS
if( $xoopsModule->getVar('dirname') != $mydirname ) die( 'this page can be called only from '.$mydirname ) ;

// PERMISSION ERROR
$module_handler =& xoops_gethandler( 'module' ) ;
$module =& $module_handler->getByDirname( $mydirname ) ;
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
$mid = $module->getVar('mid') ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $mid , $xoopsUser->getGroups() ) ) {
	die( 'Only administrator can use this feature.' ) ;
}

$ispreview = $iserror = 0 ;
$downdata = $category =$select_platform = $select_license = $img_ar = array();
$preview_title = $preview_body = $error_message =  '' ;

if( is_object( $xoopsUser ) ) {
	$xoops_isuser = true ;
	$xoops_userid = $xoopsUser->getVar('uid') ;
	$xoops_uname = $xoopsUser->getVar('uname') ;
	$xoops_isadmin = $xoopsUserIsAdmin ;
} else {
	$xoops_isuser = false ;
	$xoops_userid = 0 ;
	$xoops_uname = '' ;
	$xoops_isadmin = false ;
}

$unapproval = new unapproval_download( $mydirname ) ;

// GET REQUESTID FROM $_GET
$requestid = isset( $_GET['requestid'] ) ? intval( $_GET['requestid'] ) : "";

// CATEGORY LIST
$category = d3download_categories_selbox( $mydirname, '', 0, 0, 1 ) ;

// GET PLATFORM LIST
$select_platform = $unapproval->Select_Platform() ;

// GET LICENSE LIST
$select_license = $unapproval->Select_License() ;

$formtitle = _MD_D3DOWNLOADS_SUBMIT_APPROVAL ;

// GET UNAPROVALDATA
$mod_url = XOOPS_URL.'/modules/'.$mydirname ;
$downdata = $unapproval->get_unapprovaldata( $requestid, $category );

// 存在しない aprovalid の場合リダイレクト
if( empty( $downdata ) ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , _MD_D3DOWNLOADS_NOMATCH ) ;
	exit();
}
$cid4assign = $downdata['cid'];
$aprovalid = $downdata['aprovalid'];
$postname = $downdata['postname'];
if( empty( $ispreview ) && empty( $iserror ) ) $download4assign = $downdata['downdata'] ;

// SCREEN SHOTS DATA
$shots_help = '';
$canuseshots =  $unapproval->can_useshots() ;
$usealbum = $unapproval->can_albumselect() ;
if( ! empty( $canuseshots ) ){
	$shots_dir = d3download_shots_dir( $mydirname, $cid4assign );
	$img_ar = $unapproval->shots_img_ar( $cid4assign, $shots_dir ) ;
	if( empty( $usealbum ) ){
		$shots_help = sprintf( _MD_D3DOWNLOADS_SUBMIT_LOGOURL_DESC , $shots_dir );
	}
}

// GET DOWNLOADDATA
$mydownload = new MyDownload( $mydirname );
$nowdata = $mydownload->get_downdata_for_singleview( 0, $aprovalid, 0, 1, 1 );

// TRANSACTION PART
if( isset( $_POST['makedownload_post'] ) || isset( $_POST['makedownload_preview'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$params_array = array( 'category' , 'usealbum' , 'downdata' ) ;
	foreach( $params_array as $key ) { $params[$key] = $$key ; }
	$submit_result = d3download_submit_execution( $mydirname, 'approval', $params ) ;
	$download4assign = $submit_result['download4assign'] ;
	$iserror = $submit_result['iserror'] ;
	$error_message = $submit_result['error_message'] ;
	if( isset( $_POST['makedownload_preview'] ) ){
		 $ispreview = true ;
		 $preview_title = $submit_result['preview_title'] ;
		 $preview_body = $submit_result['preview_body'] ;
	}
}

// DELETE SQL
if( isset( $_POST['makedownloadform_delete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$error = 0 ;
	$id = isset( $_POST['requestid'] ) ? intval( @$_POST['requestid'] ) : '' ;
	$error = $unapproval->Delete_Unapproval( $id );
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => $mod_url ,
	'page' => 'approval' ,
	'unapproval' => $download4assign ,
	'down' => $nowdata ,
	'canuseshots' => $canuseshots ,
	'select_platform' => $select_platform ,
	'select_license' => $select_license ,
	'downimg' => $img_ar ,
	'preview_title' => $preview_title ,
	'preview_body' => $preview_body ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'shots_help' => $shots_help ,
	'formtitle' => $formtitle ,
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'xoops_isadmin' => $xoops_isadmin ,
	'xoops_config' => $xoopsConfig ,
	'mod_config' => $xoopsModuleConfig ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_approval.html' ) ;
xoops_cp_footer();

?>