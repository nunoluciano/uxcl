<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
require_once dirname( dirname(__FILE__) ).'/include/transact_functions.php' ;

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
$category = $errors = $moveselect = $message = array() ;
$error_message = '' ;

$mycategory = new MyCategory( $mydirname, 'Show' ) ;
$user_access = new user_access( $mydirname ) ;

// ページナビの処理
$total = $mycategory->category_sum() ;
$select_perpage = d3download_select_perpage( $mydirname ) ;
$current_start = isset($_GET['start']) ? intval( $_GET['start'] ) : 0 ;
$perpage4assign = d3download_items_perpage();

require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;
$pagenav = new XoopsPageNav( $total, $select_perpage, $current_start, 'start', 'page=categorymanager&amp;perpage='.$select_perpage );
$pagenav4assign = $pagenav->renderNav( 10 ) ;

// GET CATEGORYLIST
$category = $mycategory->get_categorylist( $select_perpage, $current_start ) ;
$sitemap = $mycategory->sitemap( 'admin/index.php?page=categoryedit' ) ;

// TITLE & WEIGHT UPDATE
if( ! empty( $_POST['category_update'] ) && ! empty( $_POST['weights'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$errors = d3download_categorymanager_data_update( $mydirname ) ;
	$mycategory->serialize_insertdb() ;
	d3download_delete_cache_of_categories( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager&amp;perpage=$select_perpage" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_REGSTERED ) ;
	exit();
}

// DELETE
if( ! empty( $_POST['delete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_CATEGORY ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			$cid = intval( $id ) ;
			d3download_delcat( $mydirname , $cid  );
			$mycategory->serialize_insertdb() ;
			$mycategory->category_tree_check() ;
			$user_access->my_user_access_check() ;
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager&amp;perpage=$select_perpage" , 2 , _MD_D3DOWNLOADS_DELETED ) ;
		exit() ;
	}
}

// TOP MOVE
if( ! empty( $_POST['category_top_move'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_CATEGORY ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			$cid = intval( $id ) ;
			$result =  $mycategory->category_top_move( $cid ) ;
			if( ! empty( $result ) ) $errors[] = $cid ;
		}
		$mycategory->serialize_insertdb() ;
		$mycategory->category_tree_check() ;
		$user_access->my_user_access_check() ;
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager&amp;perpage=$select_perpage" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_MOVEED ) ;
		exit() ;
	}
}

// MOVE
$moveselect = d3download_categories_selbox( $mydirname, '', 0, 0, 1, '-----' ) ;
if( ! empty( $_POST['category_move'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$select_pid = intval( @$_POST['move_select'] ) ;
	if( empty( $_POST['action_selects'] ) ||  empty( $select_pid ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_CATEGORY ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			$cid = intval( $id ) ;
			if( $cid != $select_pid ){
				$result = $mycategory->category_move( $cid, $select_pid ) ;
				if( ! empty( $result ) ) $errors[] = $cid ;
			}
		}
		$mycategory->serialize_insertdb() ;
		$mycategory->category_tree_check() ;
		$user_access->my_user_access_check() ;
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager&amp;perpage=$select_perpage" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_MOVEED ) ;
		exit() ;
	}
}

// CATEGORY_CHECK
if( ! empty( $_POST['category_check'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$mycategory->serialize_insertdb() ;
	$mycategory->category_tree_check() ;
	$user_access->my_user_access_check() ;
	d3download_delete_cache_of_categories( $mydirname ) ;

	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager&amp;perpage=$select_perpage" , 2 , _MD_D3DOWNLOADS_CATEGORY_CHECK_DONE ) ;
	exit();
}

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'categorymanager' ,
	'category' => $category ,
	'sitemap' => $sitemap ,
	'moveselect' => $moveselect ,
	'perpage' => $perpage4assign ,
	'select_perpage' => $select_perpage ,
	'pagenav' => $pagenav4assign ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_category_list.html' ) ;
xoops_cp_footer();

?>