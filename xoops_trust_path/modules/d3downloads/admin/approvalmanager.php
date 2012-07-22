<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/unapproval_download.php' ;
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
$unapproval = $modfile = $message = $errors = array() ;
$error_message = '' ;

// UNAPROVAL LIST
$unapproval_execution = new unapproval_download( $mydirname ) ;
$unaproval_sum = sprintf( _MD_D3DOWNLOADS_UNAPROVALNUM , $unapproval_execution->Total_Num( 'NewFile' ) );
$unapproval = $unapproval_execution->get_unapproval_list( 'NewFile' ) ;

// UNAPROVAL DELETE
if( ! empty( $_POST['unapproval_delete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_FILSE ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			if( empty( $value ) ) continue ;
			$requestid = intval( $id ) ;
			$error = $unapproval_execution->Delete_Unapproval( $requestid );
			if( ! empty ( $error ) ) $errors[] = $requestid ;
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_DELETED ) ;
		exit() ;
	}
}

// UNAPROVAL MODFILE LIST
$modfile_sum = sprintf( _MD_D3DOWNLOADS_UNAPROVALNUM , $unapproval_execution->Total_Num( 'ModFile' ) );
$modfile = $unapproval_execution->get_unapproval_list( 'ModFile' ) ;

// UNAPROVAL MODFILE DELETE
if( ! empty( $_POST['modfile_delete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	if( empty( $_POST['modfile_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_FILSE ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['modfile_selects'] as $id => $value ) {
			if( empty( $value ) ) continue ;
			$requestid = intval( $id ) ;
			$error = $unapproval_execution->Delete_Unapproval( $requestid );
			if( ! empty ( $error ) ) $errors[] = $requestid ;
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_DELETED ) ;
		exit() ;
	}
}

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'approvalmanager' ,
	'unapproval' => $unapproval ,
	'modfile' => $modfile ,
	'unaproval_sum' => $unaproval_sum ,
	'modfile_sum' => $modfile_sum ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_approvalmanager.html' ) ;
xoops_cp_footer();

?>