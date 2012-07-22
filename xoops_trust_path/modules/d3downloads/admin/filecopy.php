<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
include_once dirname( dirname(__FILE__) ).'/class/file_manager.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

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
if( ! empty( $_POST['copy'] ) ){
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$error = 0 ;
	$file_manager = new file_manager( $mydirname ) ;
	$cid = isset( $_POST['cid'] ) ? intval( $_POST['cid'] ) : 0 ;
	$lid = isset( $_POST['lid'] ) ? intval( $_POST['lid'] ) : 0 ;
	$taget_mid = isset( $_POST['copy_mid'] ) ? intval( $_POST['copy_mid'] ) : 0 ;
	$taget_category = isset( $_POST['copy_category_id'][$taget_mid] ) ? intval( $_POST['copy_category_id'][$taget_mid] ) : 0 ;
	if( empty( $taget_mid ) || empty( $taget_category ) ) $error = true ;
	else $to_dirname = $file_manager->copy_execution( $taget_mid, $taget_category, $lid ) ;

	if( empty( $error ) ) d3download_delete_cache_of_categories( $to_dirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=modfile&amp;cid=$cid&amp;lid=$lid" , 2 , $error ? _MD_D3DOWNLOADS_NO_COPY : _MD_D3DOWNLOADS_COPYED ) ;
	exit();
}

?>