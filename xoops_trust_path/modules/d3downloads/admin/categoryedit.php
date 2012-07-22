<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
require_once dirname( dirname(__FILE__) ).'/include/transact_functions.php' ;

$db =& Database::getInstance() ;

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

$error = $iserror = $can_selectshotsdir = 0 ;
$categorydata = $error_message = $tags = array() ;
$error_message = '' ;

$cid = isset( $_GET['cid'] ) ? intval( $_GET['cid'] ) : 0 ;
$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;

// 存在しない CID の場合リダイレクト
if( $cid != 0 && ! $mycategory->return_cid() ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , _MD_D3DOWNLOADS_NOREADPERM ) ;
	exit();
}

// GET CATEGORY DATA
$category_edit = new MyCategory( $mydirname,'Edit' ) ;
if( empty( $iserror ) ) $categorydata = $category_edit->MyCategory_for_Edit( $cid ) ;
$pid = $categorydata['pid'] ;
$useshots = d3download_can_useshots( $mydirname ) ;
$usealbum = d3download_can_albumselect( $mydirname ) ;

if( ! empty( $useshots ) && empty( $usealbum ) ) $can_selectshotsdir = 1 ;
$shots_dir = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/images/shots/' ;
$shotsdirhelp = sprintf( _MD_D3DOWNLOADS_CATEGORYSHOTSDIRHELP , $shots_dir ) ;

$mydownload = new MyDownload( $mydirname ) ;
$my_shots_dir = d3download_shots_dir( $mydirname, $cid ) ;
$select_imgurl = $mydownload->shots_img_ar( $cid, $my_shots_dir ) ;

// GET CATEGORY TITLE
$title = $mycategory->return_title() ;
$formtitle = ( $title ) ? sprintf( _MD_D3DOWNLOADS_CATEGORYEDITTITLE , $title ) : _MD_D3DOWNLOADS_NEWCATEGORYEDITTITLE ; 
if( $cid == 0 ) $title_useraccess = ( $title ) ? sprintf( _MD_D3DOWNLOADS_H2USERACCESS , $title ) : _MD_D3DOWNLOADS_NEWCID_USERACCESS ;
elseif( $pid == 0 ) $title_useraccess = ( $title ) ? sprintf( _MD_D3DOWNLOADS_H2USERACCESS , $title ) : _MD_D3DOWNLOADS_NEWCID_USERACCESS ;
else $title_useraccess = ( $title ) ? sprintf( _MD_D3DOWNLOADS_H2USERACCESS_INFO , $title ) : _MD_D3DOWNLOADS_NEWCID_USERACCESS_INFO ;

// MAIN CATEGORY LIST
$maincategory = $category_edit->categories_selbox( '', 0, 0, 1, '------', 0, $cid ) ;

// GROUP FORM
$user_access = new user_access( $mydirname ) ;
$group_trs = $user_access->get_group_form( $cid, $pid ) ;

// USER FORM
$user_trs = $user_access->get_user_form( $cid, $pid ) ;

// NEW USER FORM
$newuser_trs = $user_access->get_newuser_form( $cid ) ;

$useraccess_edit_info = ( empty( $cid ) ) ? '' : d3download_useraccess_edit_info( $mydirname, $cid, $pid ) ;

// TRANSACTION PART
if( isset( $_POST['categoryform_post'] ) || isset( $_POST['category_update'] ) || isset( $_POST['group_update'] ) || isset( $_POST['user_update'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$requests_int = $category_edit->requests_int_categories() ;
	$edit_id = $requests_int['cid'] ;
	$pid = $requests_int['pid'] ;
	$cat_weight = $requests_int['cat_weight'] ;
	$requests_text = $category_edit->requests_text_categories() ;
	$title = $requests_text['title'] ;
	$imgurl = $requests_text['imgurl'] ;
	$description = $requests_text['description'] ;
	$shotsdir = $requests_text['shotsdir'] ;
	$old_pid = empty( $_POST['old_pid'] ) ? 0 : intval( $_POST['old_pid'] ) ;

	$validate_result = $category_edit->Validate() ;
	if( ! empty( $validate_result ) ){
		$iserror = $validate_result['error'];
		$error_message = implode( '<br />' , $validate_result['message'] ) ;
	}

	// for after iserror edit
	$categorydata = array(
		'cid' => $edit_id ,
		'pid' => $pid ,
		'title' => $requests_text['title4edit'] ,
		'imgurl' => $requests_text['imgurl4edit'] ,
		'description' => $requests_text['description4edit'] ,
		'shotsdir' => $requests_text['shotsdir4edit'] ,
		'cat_weight' =>  $requests_int['cat_weight'] ,
		'submit_message' => $requests_text['submit_message4edit'] ,
		'old_pid' =>  $old_pid ,
	) ;

	if( empty( $iserror ) ){
		if ( ! empty( $edit_id ) && ( $pid != $old_pid ) ) $category_edit->pid_select_check( $edit_id, $pid, $old_pid, 1 ) ;

		include_once dirname( dirname(__FILE__) ).'/class/db_download.php' ;
		$post_cat = new db_download( $db->prefix( $mydirname."_cat" ) , "cid", $edit_id ) ;

		// SET4SQL
		$set4sql_int = $requests_int['set4sql'] ;
		$set4sql_text = $requests_text['set4sql'] ;
		$set4sql = $set4sql_int . $set4sql_text ;

		// MAKE LINK SQL
		if( empty( $edit_id ) ) {
			$new_cid = $post_cat->db_insert( $set4sql );
			if( empty( $new_cid ) ){
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID ) ;
				exit();
			}
			// Define tags for notification message
			$tags = array(
				'CAT_TITLE' => $title ,
				'CAT_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?cid=' . $new_cid ,
			) ;
			d3download_main_trigger_event( $mydirname , 'global' , 0 , 'newcategory' , $tags, 0 ) ;
		} elseif ( ! empty( $edit_id ) ) {
			// DOES THE LINK ALREADY EXIST? -- UPDATE SQL
			$sql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_cat" )." WHERE cid='".$edit_id."'";
			list( $count ) = $db->fetchRow( $db->query( $sql) );
			if( $count > 0 ){
				$result = $post_cat->db_update( $set4sql, $edit_id );
				if( ! $result ) $error = $edit_id ;
			}
		}
		if( empty( $edit_id ) ) $edit_id = $new_cid ;
		if( $old_pid != 0  && $pid == 0 ){
			// SET DEFAULT USER ACCESS
			$my_maincid= $category_edit->get_my_maincid( $old_pid ) ;
			$error = $category_edit->my_user_access_copy( $my_maincid, $edit_id, 1 ) ;
		} elseif( $old_pid == 0 ){
			// GROUP UPDATE
			$error = $user_access->group_update( $edit_id, $pid ) ;
			// USER UPDATE
			$error = $user_access->user_update( $edit_id, $pid ) ;
		} else {
			$category_edit->date_save_cat_table( $edit_id ) ;
		}
		$category_edit->serialize_insertdb() ;
		$category_edit->category_tree_check() ;
		$user_access->my_user_access_check() ;
		d3download_delete_cache_of_categories( $mydirname ) ;
		if( ! empty( $_POST['categoryform_post'] ) ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_REGSTERED ) ;
		} else {
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categoryedit&amp;cid=$edit_id" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_REGSTERED ) ;
		}
		exit();
	}
}

// DELETE SQL
if( isset( $_POST['categoryform_delete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	$cid = isset( $_POST['cid'] ) ? intval( @$_POST['cid'] ) : "" ;
	d3download_delcat( $mydirname , $cid ) ;
	$category_edit->serialize_insertdb() ;
	$category_edit->category_tree_check() ;
	$user_access->my_user_access_check() ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categorymanager" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_DELETED ) ;
	exit();
}

// DISPLAY STAGE

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'categoryedit' ,
	'formtitle' => $formtitle ,
	'categorydata' => $categorydata ,
	'maincategory' => $maincategory ,
	'title_useraccess' => $title_useraccess ,
	'group_trs' => $group_trs ,
	'user_trs' => $user_trs ,
	'newuser_trs' => $newuser_trs ,
	'useraccess_edit_info' => $useraccess_edit_info ,
	'can_selectshotsdir' => $can_selectshotsdir ,
	'shotsdirhelp' => $shotsdirhelp ,
	'select_imgurl' => $select_imgurl ,
	'iserror' => $iserror ,
	'error_message' => $error_message ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_category_edit.html' ) ;
xoops_cp_footer();

?>