<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;
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

$iserror = 0 ;
$broken = $message = $errors = array() ;
$error_message = '' ;

// GET BROKEN LIST
$broken_download = new broken_download( $mydirname ) ;
$broken_sum = $broken_download->Total_Num();
$total_num4assign = ! empty( $broken_sum ) ? intval( $broken_sum ) : 0 ;
$total_broken4assign = sprintf( _MD_D3DOWNLOADS_BROKENNUM , $total_num4assign ) ;
$broken = $broken_download->get_broken_data();

$broken_report = new broken_report( $mydirname ) ;

// BROKEN DATA UPDATE
if( ! empty( $_POST['brokenmanager_update'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors()) ;
	}
	if( empty( $_POST['brokendel'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_REPORT ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['brokendel'] as $id => $value ) {
			$lid = intval( $id ) ;
			$result = $broken_report->Delete_Report_by_select_lid( $lid );
			if( ! empty( $result ) ) $errors[] = $lid ;
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=brokenmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_BROKENDELETED ) ;
		exit() ;
	}
}

// DELETE
if( ! empty( $_POST['delete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors()) ;
	}
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_FILSE ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			if( empty( $value ) ) continue ;
			$lid = intval( $id ) ;
			d3download_delete_lid( $mydirname ,$lid ) ;
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=brokenmanager" , 2 , _MD_D3DOWNLOADS_DELETED ) ;
		exit() ;
	}
}

// SET INVISIBLE
if( ! empty( $_POST['invisible'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors()) ;
	}
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_FILSE ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		$db =& Database::getInstance() ;
		foreach( $_POST['action_selects'] as $id => $value ) {
			if( empty( $value ) ) continue ;
			$lid = intval( $id ) ;
			$broken_report->Delete_Report_by_select_lid( $lid ) ;
			$sql="UPDATE ".$db->prefix( $mydirname."_downloads" )." SET visible='0' WHERE lid='".$lid."'";
			$result = $db->query( $sql );
			if( ! $result ) $errors[] = $lid ;
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=brokenmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_INVISIBLE_DONE ) ;
		exit() ;
	}
}

// BROKENCHECK
if( ! empty( $_POST['brokencheck'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors()) ;
	}
				
	$limit  = intval( $_POST['limit'] ) ;
	$offset = intval( $_POST['offset'] ) ;
	$broken_report->broken_check( $limit, $offset ) ;
}

// NOLINK FILE
$filecount = $broken_report->File_Count() ;
$nolinkfile = $filecount['nolink'] ;
$totalfile = $filecount['total'] ;

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mod_url'        => XOOPS_URL.'/modules/'.$mydirname ,
	'page'           => 'brokenmanager' ,
	'broken'         => $broken ,
	'total_num'      => $total_broken4assign ,
	'nolinkfile'     => $nolinkfile ,
	'totalfile'      => $totalfile ,
	'limit'          => $broken_report->Total_Num() ,
	'iserror'        => $iserror ,
	'error_message'  => $error_message ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_brokenmanager.html' ) ;
xoops_cp_footer();

?>