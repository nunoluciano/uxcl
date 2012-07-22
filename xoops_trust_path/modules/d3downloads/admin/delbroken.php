<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;

$broken_report = new broken_report( $mydirname ) ;

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

if( ! empty( $_POST['delbroken_post']) ){
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/" , 3 , $xoopsGTicket->getErrors() );
	}

	$cid = isset( $_POST['cid'] ) ? intval( $_POST['cid'] ) : 0 ;
	$lid = isset( $_POST['lid'] ) ? intval( $_POST['lid'] ) : 0 ;

	$error = 0 ;
	if( ! empty( $lid ) ) {
		$error = $broken_report->Delete_Report_by_select_lid( $lid ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=modfile&amp;cid=$cid&amp;lid=$lid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_BROKENDELETED ) ;
		exit();
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=modfile&amp;cid=$cid&amp;lid=$lid" , 2 , _MD_D3DOWNLOADS_NONDELETED ) ;
		exit();
	}
} else {
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=modfile&amp;cid=$cid&amp;lid=$lid" , 2 , _MD_D3DOWNLOADS_NONDELETED ) ;
	exit();
}

?>