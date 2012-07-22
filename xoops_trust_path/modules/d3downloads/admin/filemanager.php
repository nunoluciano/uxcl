<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
include_once dirname( dirname(__FILE__) ).'/class/file_manager.php' ;
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

$error = $iserror = 0 ;
$download = $category4assin = $submitter_select = $moveselect = $copy_select = $message = $errors = array() ;
$error_message = '' ;

$file_manager = new file_manager( $mydirname ) ;

// GET CATEGORY LIST
$category4assin = d3download_categories_selbox( $mydirname, '', 0, 1, 1, 'ALL' ) ;

if( ! empty( $_POST['category_select'] ) ) $category_select = intval( $_POST['category_select'] );
elseif( ! empty( $_GET['cid'] ) ) $category_select = intval( $_GET['cid'] );
else $category_select = 0 ;

$invisible = isset( $_GET['invisible'] ) ? intval( $_GET['invisible'] ) : 0 ;

// GET SUBMITTER LIST
$submitter_select = $file_manager->submitter_select_box( '', 1 ) ;

$mypost = ( isset( $_POST['sel_submitter'] ) || isset( $_GET['mypost'] ) ) ? 1 : 0 ;
if( ! empty( $_POST['submitter'] ) ) $submitter = intval( $_POST['submitter'] ) ;
elseif( ! empty( $_GET['submitter'] ) ) $submitter = intval( $_GET['submitter'] ) ;
else $submitter = 0 ;

$select_intree = d3download_select_intree() ;
$intree = ( ! empty( $_POST['intree'] ) || ! empty( $_GET['intree'] ) ) ? 1 : 0 ;

$select_perpage = d3download_select_perpage( $mydirname ) ;
$list_order = d3download_select_order() ;
$select_order = d3download_selected_order( $mydirname ) ;

$current_start = isset($_GET['start']) ? intval( $_GET['start'] ) : 0 ;
$perpage4assign = d3download_items_perpage();

if( empty( $mypost ) ) $total_num = $file_manager->Total_Num( '', $category_select, 1, $invisible, $intree ) ;
else  $total_num = $file_manager->Total_Mypost( '', $submitter, $category_select, 1, $intree ) ;

$invisible_num = $file_manager->Invisible_Num( $category_select, $intree ) ;

if( ! empty( $mypost ) ) $postname = $file_manager->get_postname( $submitter ) ;

if( ! empty( $category_select ) && empty( $mypost ) ){
	$total_info =  ( empty( $invisible ) ) ? _MD_D3DOWNLOADS_CATEGORY_FIlE_NUM : _MD_D3DOWNLOADS_CATEGORY_INVISIBLE_NUM ;
} elseif( empty( $mypost ) ){
	$total_info =  ( empty( $invisible ) ) ? _MD_D3DOWNLOADS_TOTAL_FIlE_NUM : _MD_D3DOWNLOADS_TOTAL_INVISIBLE_NUM ;
}

if( empty( $mypost ) ) $total_num4assign = sprintf( $total_info , $total_num )  ;
else $total_num4assign = sprintf( _MD_D3DOWNLOADS_MYPOST_NUM , $postname , $total_num ) ;

$order = d3download_convertorderbyout( $select_order ) ;
$pagenavarg = "page=filemanager&amp;perpage=".$select_perpage."&amp;orderby=".$order ;
if( ! empty( $category_select ) ) $pagenavarg .= "&amp;cid=".$category_select ;
if( ! empty( $invisible ) ) $pagenavarg .= "&amp;invisible=".$invisible ;
if( ! empty( $mypost ) ) $pagenavarg .= "&amp;mypost=".$mypost."&amp;submitter=".$submitter ;
if( ! empty( $intree ) ) $pagenavarg .= "&amp;intree=".$intree ;
require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;
$pagenav = new XoopsPageNav( $total_num, $select_perpage, $current_start , 'start' , $pagenavarg ) ;
$pagenav4assign = $pagenav->renderNav( 5 ) ;

// GET DOWNLOAD LIST
$download = $file_manager->get_files( $category_select, $select_perpage, $current_start, $select_order, $invisible, $submitter, $mypost, $intree ) ;

$category_tree = ( $category_select != 0 ) ? d3download_category_tree( $mydirname, $category_select, 'index.php?page=filemanager' ) : '' ;

// DOWNLOAD DATA UPDATE
if( ! empty( $_POST['filemanager_update'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$errors = d3download_file_manager_data_update( $mydirname ) ;
	d3download_delete_cache_of_categories( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager&amp;cid=$category_select" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_REGSTERED ) ;
	exit();
}

// DELETE
if( ! empty( $_POST['delete'] ) ) {
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
			$lid = intval( $id ) ;
			// u“Še‚ðƒ†[ƒU[‚Ì“Še”‚É”½‰fv‚ª—LŒø‚Èê‡A“Še”‚É”½‰f
			d3download_delete_lid( $mydirname ,$lid );
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager&amp;cid=$category_select" , 2 , _MD_D3DOWNLOADS_DELETED ) ;
		exit() ;
	}
}

// MOVE
$moveselect = d3download_categories_selbox( $mydirname, '', 0, 0, 1, '----' , 0, $category_select ) ;

if( ! empty( $_POST['move'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$cid = intval( @$_POST['move_select'] ) ;
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_FILSE ;
	if( empty( $cid ) ) $message[] = _MD_D3DOWNLOADS_NO_MOVEED ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		$errors = d3download_file_manager_move_action( $mydirname, $cid ) ;
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager&amp;cid=$cid" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_MOVEED ) ;
		exit();
	}
}

// COPY
$copy_select = $file_manager->get_copy_target_modules() ;

if( ! empty( $_POST['copy'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$taget_mid = intval( @$_POST['copy_mid'] ) ;
	$taget_category = intval( @$_POST['copy_category_id'][$taget_mid] ) ;
	if( empty( $_POST['action_selects'] ) ) $message[] = _MD_D3DOWNLOADS_ERROR_SEL_FILSE ;
	if( empty( $taget_mid ) || empty( $taget_category ) ) $message[] = _MD_D3DOWNLOADS_NO_COPY ;
	if( ! empty( $message ) ){
		$iserror = 1 ;
		$error_message = implode( '<br />' , $message ) ;
	}
	if( empty( $iserror ) ) {
		foreach( $_POST['action_selects'] as $id => $value ) {
			if( empty( $value ) ) continue ;
			$lid = intval( $id ) ;
			$to_dirname = $file_manager->copy_execution( $taget_mid, $taget_category, $lid ) ;
		}
		d3download_delete_cache_of_categories( $to_dirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=filemanager&amp;cid=$category_select" , 2 , _MD_D3DOWNLOADS_COPYED ) ;
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
	'page' => 'filemanager' ,
	'download' => $download ,
	'categoryselect' => $category4assin ,
	'submitter_select' => $submitter_select ,
	'select_cid' => $category_select ,
	'select_intree' => $select_intree ,
	'intree' => $intree ,
	'mypost' => $mypost ,
	'submitter' => $submitter ,
	'moveselect' => $moveselect ,
	'perpage' => $perpage4assign ,
	'select_perpage' => $select_perpage ,
	'total_num' => $total_num4assign ,
	'invisible' => $invisible ,
	'invisible_num' => $invisible_num['num'] ,
	'invisible_link' => $invisible_num['link'] ,
	'list_order' => $list_order ,
	'select_order' => $select_order ,
	'pagenav' => $pagenav4assign ,
	'category_tree' =>$category_tree ,
	'copy_select' =>$copy_select ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_filemanager.html' ) ;
xoops_cp_footer();

?>