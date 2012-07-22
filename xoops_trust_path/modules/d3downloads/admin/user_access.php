<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
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

$error = $iserror = 0 ;
$category4assin = $copyselect = $message = array() ;
$error_message = '' ;

// GET CATEGORY LIST
$category4assin = d3download_categories_selbox( $mydirname, '', 0, 1, 1 ) ;

$user_access = new user_access( $mydirname ) ;
if( ! empty( $_POST['category_select'] ) ) $cid = intval( $_POST['category_select'] );
elseif( ! empty( $_GET['cid'] ) ) $cid = intval( $_GET['cid'] );
else $cid = $user_access->get_top_weightid( 1 ) ;

// GET CATEGORY TITLE
$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
$title = $mycategory->return_title() ;
$formtitle = ( $title ) ? sprintf( _MD_D3DOWNLOADS_H2USERACCESS , $title ) : _MD_D3DOWNLOADS_NEWCID_USERACCESS ;

$parentid = $mycategory->return_pid() ;
$maincid = ( $parentid != 0 ) ? $mycategory->get_my_maincid( $cid ) : 0 ;
$category_tree = ( $parentid != 0 ) ? d3download_category_tree( $mydirname, $cid, 'index.php?page=user_access' ) : '' ;
$copyselect = d3download_categories_selbox( $mydirname, '', 0, 0, 1, '----' , 1, $cid ) ;
$categorycount = count( $copyselect ) ;

// GROUP FORM
$group_trs = ( $categorycount > 1 ) ? $user_access->get_group_form( $cid, $parentid, 0, 1 ) : $user_access->get_group_form( $cid, $parentid ) ;

// USER FORM
$user_trs = ( $categorycount > 1 ) ? $user_access->get_user_form( $cid, $parentid, 0, 1  ) : $user_access->get_user_form( $cid, $parentid ) ;

// NEW USER FORM
if(  $categorycount > 1 && $parentid == 0 ) $newuser_trs = $user_access->get_newuser_form( $cid, 1 ) ;
elseif( $parentid == 0 ) $newuser_trs =  $user_access->get_newuser_form( $cid ) ;
else $newuser_trs =  '' ;

// TRANSACTION PART
if( isset( $_POST['group_update'] ) ){
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	// GROUP UPDATE
	$error = $user_access->group_update( $cid ) ;
	d3download_delete_cache_of_categories( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=user_access&amp;cid=$cid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_REGSTERED ) ;
	exit();
}

if( isset( $_POST['user_update'] ) ){
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	// USER UPDATE
	$error = $user_access->user_update( $cid ) ;
	d3download_delete_cache_of_categories( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=user_access&amp;cid=$cid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_REGSTERED ) ;
	exit();
}

// GROUP COPY
if( ! empty( $_POST['group_copy'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$selectid = intval( @$_POST['copy_select_group'] ) ;
	$error = $user_access->group_update( $cid ) ;
	if( empty( $_POST['copy_select_group'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_CATEGORY ;
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_GROUP ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
		$group_trs = $user_access->get_group_form( $cid, $parentid, 0, 1 ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			if( empty( $value ) ) continue ;
			$groupid = intval( $id ) ;
			$error = $user_access->current_select_user_access_copy( $cid, $selectid, 'group', $groupid ) ;
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=user_access&amp;cid=$selectid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_COPYDONE ) ;
		exit();
	}
}

if( ! empty( $_POST['all_group_copy'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$error = $user_access->group_update( $cid ) ;
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_GROUP ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
		$group_trs = $user_access->get_group_form( $cid, $parentid, 0, 1 ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			if( empty( $value ) ) continue ;
			$groupid = intval( $id ) ;
			$error = $user_access->all_user_access_copy( $cid, 'group', $groupid ) ;
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=user_access&amp;cid=$cid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_COPYDONE ) ;
		exit();
	}
}

// USER COPY
if( ! empty( $_POST['user_copy'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$selectid = intval( @$_POST['copy_select_user'] ) ;
	$error = $user_access->user_update( $cid ) ;
	if( empty( $_POST['copy_select_user'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_CATEGORY ;
	if( ( is_array( @$_POST['can_read_user'] ) && empty( $_POST['action_selects_u']  ) ) && ( is_array( @$_POST['new_uids'] ) && empty( $_POST['new_action_selects_u']  ) ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_USER ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
		$user_trs = $user_access->get_user_form( $cid, $parentid, 0, 1  ) ;
		$newuser_trs = $user_access->get_newuser_form( $cid, 1 ) ;
	}
	if( empty( $iserror ) ) {
		$error = $user_access->select_myuser_access_copy_execution( $cid, $selectid, 'selectcat' ) ;
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=user_access&amp;cid=$selectid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_COPYDONE ) ;
		exit();
	}
}

if( ! empty( $_POST['all_user_copy'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$error = $user_access->user_update( $cid ) ;
	if( ( is_array( @$_POST['can_read_user'] ) && empty( $_POST['action_selects_u']  ) ) && ( is_array( @$_POST['new_uids'] ) && empty( $_POST['new_action_selects_u']  ) ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_USER ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
		$user_trs = $user_access->get_user_form( $cid, $parentid, 0, 1  ) ;
		$newuser_trs = $user_access->get_newuser_form( $cid, 1 ) ;
	}
	if( empty( $iserror ) ) {
		$error = $user_access->select_myuser_access_copy_execution( $cid, 0, 'allcat' ) ;
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=user_access&amp;cid=$cid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_COPYDONE ) ;
		exit();
	}
}

// DISPLAY STAGE

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'user_access' ,
	'formtitle' => $formtitle ,
	'categoryselect' => $category4assin ,
	'select_cid' => $cid ,
	'parentid' => $parentid ,
	'maincid' => $maincid ,
	'category_tree' =>$category_tree ,
	'group_trs' => $group_trs ,
	'user_trs' => $user_trs ,
	'newuser_trs' => $newuser_trs ,
	'copy_select' => $copyselect ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_user_access.html' ) ;
xoops_cp_footer();

?>