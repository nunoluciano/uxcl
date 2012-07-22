<?php

global $xoopsUser ;

include XOOPS_ROOT_PATH.'/header.php';

include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$user_access = new user_access( $mydirname ) ;

$cid = $mypost = $submitter= $can_post4cid = $post_cid = $intree = 0 ;
$download4assign = $category4assin = $category4post = $submitter_select = array() ;
$cat_arg = "" ;

// 閲覧・投稿可能なカテゴリ取得の準備
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
$whr_cat4read = "d.".$whr_cat ;
$whr_cat4post = "cid IN (".implode(",", $user_access->can_post() ).")" ;

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

// DELETE NULLBYTE
$_GET = d3download_delete_nullbyte( $_GET ) ;
$orderby = d3download_selected_order( $mydirname ) ;
$xoopsTpl->assign('lang_cursortedby', sprintf( _MD_D3DOWNLOADS_CURSORTBY, d3download_convertorderbytrans( $orderby ) ) ) ;

$bc[0] = d3download_breadcrumbs( $mydirname ) ;

$mydownload = new MyDownload( $mydirname ) ;

// CID を取得した場合の処理
if ( isset( $_GET['cid'] ) ) {
	$cid = intval( $_GET['cid'] ) ;
	if ( ! empty( $_GET['intree'] ) ) $intree = 1 ;

	$xoopsOption['template_main'] = $mydirname.'_main_viewcat.html' ;
	$xoopsTpl->assign( 'category_id', $cid ) ;

	$select_intree = d3download_select_intree();
	$xoopsTpl->assign( 'select_intree' , $select_intree ) ; 
	$xoopsTpl->assign( 'intree', $intree );

	// カテゴリ毎の登録件数を取得
	$total = $mydownload->Total_Num( $whr_cat, $cid, 0, 0, $intree ) ;
	$total_num = sprintf( _MD_D3DOWNLOADS_CATEGORY_NUM , $total )  ;

	// カテゴリーの説明を取得
	$cat_description = d3download_cat_description( $mydirname, $cid ) ;
	$xoopsTpl->assign( 'cat_description', $cat_description ) ;

	// 管理者用に閲覧権限設定状況をアサイン
	if( $module_admin ){
		$canread_info = $user_access->canread_info( $cid ) ;
		$group_trs = d3download_group_useraccess_info( $mydirname, $cid ) ;
		$user_trs = d3download_myuser_useraccess_info( $mydirname, $cid ) ;
		$useraccess_edit = d3download_useraccess_edit_info( $mydirname, $cid ) ;
		$xoopsTpl->assign( 'canread_info', $canread_info ) ;
		$xoopsTpl->assign( 'group_trs', $group_trs ) ;
		$xoopsTpl->assign( 'user_trs', $user_trs ) ;
		$xoopsTpl->assign( 'useraccess_edit', $useraccess_edit ) ;
	}

	// ページタイトルをアサイン
	include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
	$mycategory = new MyCategory( $mydirname, 'Show', $cid, $whr_cat ) ;
	$pagetitle4assign = $mycategory->return_title() ;

	// 閲覧できないカテゴリはリダイレクト
	$canread = $user_access->user_access_for_cat( $cid, $whr_cat ) ;
	if( empty( $canread ) ) {
		redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/',3, _MD_D3DOWNLOADS_NOREADPERM ) ;
		exit() ;
	}

	// 投稿可能なカテゴリのみ投稿フォームへのリンクを表示
	$can_post4cid = $user_access->user_access_for_cat( $cid, $whr_cat4post ) ;

	// パンくず部分の処理
	$breadcrumbs = array_merge( $bc ,d3download_breadcrumbs_tree( $mydirname, $cid, $whr_cat ) ) ;

} elseif ( isset( $_GET['submitter'] ) ) {
	// uid を取得した場合の処理
	$submitter = intval( $_GET['submitter'] ) ;

	$xoopsOption['template_main'] = $mydirname.'_main_viewcat.html' ;

	$mypost = true ;
	$xoopsTpl->assign( 'mypost', $mypost ) ;
	$xoopsTpl->assign( 'submitter', $submitter ) ;

	// 投稿者毎の登録件数を取得
	$total = $mydownload->Total_Mypost( $whr_cat, $submitter ) ;
	$postname = $mydownload->get_postname( $submitter ) ;
	$total_num = sprintf( _MD_D3DOWNLOADS_MYPOST_NUM , $postname , $total ) ;

	//登録件数を取得できない場合はリダイレクト
	if( empty( $total ) ) {
		redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/',3, _MD_D3DOWNLOADS_NOMATCH ) ;
		exit() ;
	}

	// ページタイトルをアサイン
	$pagetitle4assign = sprintf( _MD_D3DOWNLOADS_MYPOST_TITLE , $postname ) ;

	$submitter_select = $mydownload->submitter_select_box( $whr_cat ) ;
	$xoopsTpl->assign( 'submitter_select' , $submitter_select  ) ;

	// パンくず部分の処理
	$bc[] = array( 'name' => $pagetitle4assign ) ;

} else {
	// CID がない場合の処理
	$xoopsOption['template_main'] = $mydirname.'_main_viewcontent.html' ;

	// ページタイトルをアサイン
	$pagetitle4assign = $xoopsModule->getVar('name') ;

	// 全体登録件数を取得
	$total = $mydownload->Total_Num( $whr_cat ) ;
	$total_num = sprintf( _MD_D3DOWNLOADS_TOTAL_NUM , $total ) ;

	if( $module_admin ){
		include_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;
		$broken_download = new broken_download( $mydirname ) ;
		// 破損報告件数をアサイン
		$broken_num = $broken_download->Broken_Num() ;
		$xoopsTpl->assign( 'broken_num' , $broken_num['num']  ) ;
		$xoopsTpl->assign( 'broken_link' , $broken_num['link']  ) ;
		// アップロードファイル破損チェック
		if( ! empty( $_POST['brokencheck'] ) ) {
			$broken_report = new broken_report( $mydirname ) ;
			$broken_report->broken_check() ;
		}
		// 承認待ち件数をアサイン
		include_once dirname( dirname(__FILE__) ).'/class/unapproval_download.php' ;
		$unapproval_download = new unapproval_download( $mydirname ) ;
		$unapproval_num = $unapproval_download->Unapproval_Num() ;
		$xoopsTpl->assign( 'unapproval_num' , $unapproval_num['num']  ) ;
		$xoopsTpl->assign( 'unapproval_link' , $unapproval_num['link']  ) ;
	}
}

// ページナビなどをアサイン
if( ! empty( $cid ) || ! empty( $mypost ) ){
	$perpage4assign = d3download_items_perpage() ;
	$select_perpage = d3download_select_perpage( $mydirname ) ;
	$current_start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0 ;
	require_once dirname( dirname(__FILE__) ).'/class/my_pagenav.php' ;
	$orderby4pagenav = d3download_convertorderbyout( $orderby ) ;
	$pagenavarg = ( empty( $submitter  ) ) ? "&amp;cid=".$cid."&amp;intree=".$intree : "&amp;submitter=".$submitter ;
	$pagenavarg .= "&amp;orderby=".$orderby4pagenav."&amp;perpage=".$select_perpage;
	$pagenav = new My_PageNav( $total, $select_perpage, $current_start , 'start' , $pagenavarg ) ;
	$pagenav4assign = $pagenav->renderNav( 5 ) ;
	$orderbyarg = ( empty( $submitter ) ) ? "index.php?cid=".$cid."&amp;intree=".$intree : "index.php?submitter=".$submitter ;
	$orderbyarg .= "&amp;perpage=".$select_perpage ;
	$xoopsTpl->assign( 'perpage' , $perpage4assign ) ; 
	$xoopsTpl->assign( 'select_perpage' , $select_perpage ) ; 
	$xoopsTpl->assign( 'pagenav' , $pagenav4assign ) ; 
	$xoopsTpl->assign( 'argument' , $orderbyarg ) ; 
	$xoopsTpl->assign( 'orderby' , $orderby4pagenav ) ; 
}

if( ! empty( $select_perpage ) ) $cat_arg .= "&amp;perpage=".$select_perpage ;
if( ! empty( $orderby4pagenav ) ) $cat_arg .= "&amp;orderby=".$orderby4pagenav ;
if( ! empty( $intree ) ) $cat_arg .= "&amp;intree=".$intree ;
$xoopsTpl->assign( 'cat_arg' , $cat_arg ) ; 

// カテゴリと登録件数をアサイン
$xoopsTpl->assign( 'categories' , d3download_getsub_categories( $mydirname, $cid , $whr_cat ) ) ; 
$xoopsTpl->assign( 'download_total_num' , $total_num  ) ;

// 非公開件数をアサイン
$mod_url = XOOPS_URL.'/modules/'.$mydirname ;
if( $module_admin ){
	$invisible_num = $mydownload->Invisible_Num( $cid, $intree ) ;
	$xoopsTpl->assign( 'invisible_num' , $invisible_num['num']  ) ;
	$xoopsTpl->assign( 'invisible_link' , $invisible_num['link']  ) ;
}

// 閲覧可能なカテゴリのリストを SELECTボックス用に取得
$category4assin = d3download_makecache_for_selbox( $mydirname, $whr_cat, 0, 1 ) ;

// 閲覧可能な登録データを取得
if( empty( $cid ) && empty( $mypost ) ){
	$limit = $xoopsModuleConfig['newdownloads'] ;
	$download4assign = $mydownload->get_downdata_for_topview( $whr_cat4read, $limit ) ;
} else {
	$download4assign = $mydownload->get_downdata_for_catview( $cid, $whr_cat4read, $orderby, $select_perpage, $current_start, $submitter, $mypost, $intree ) ;
}

$lang_directcatsel = _MD_D3DOWNLOADS_SEL_CATEGORY;

// スクリーンショット画像を使用するかどうか
$canuseshots = ! empty( $xoopsModuleConfig['useshots'] ) ? 1 : 0 ;

// 投稿可能なカテゴリリストのみ取得
$category4post = d3download_categories_selbox( $mydirname, $whr_cat4post ) ;
if( ! empty( $_POST['file_post'] ) && ! empty( $_POST['category_select'] ) ) {
	$post_cid = intval( $_POST['category_select']) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=submit&amp;cid=$post_cid", 2, _MD_D3DOWNLOADS_REDIRECT_NEWSUBMIT ) ;
	exit ;
}

if( ! empty( $_POST['cat_edit'] ) && ! empty( $_POST['category_select'] ) ) {
	$edit_cid = intval( $_POST['category_select'] ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categoryedit&amp;cid=$edit_cid", 2, _MD_D3DOWNLOADS_REDIRECT_NEWSUBMIT ) ;
	exit ;
}

$xoops_module_header = d3download_dbmoduleheader( $mydirname ) ;
$xoopsTpl->assign( 'xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars('xoops_module_header' ) ) ;

// assign
$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => $mod_url ,
	'file' => $download4assign ,
	'category' => $category4assin ,
	'lang_directcatsel' => $lang_directcatsel ,
	'can_post' => $can_post4cid ,
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'module_admin' => $module_admin ,
	'xoops_config' => $xoopsConfig ,
	'mod_config' => $xoopsModuleConfig ,
	'canuseshots' => $canuseshots ,
	'category_for_post' => $category4post ,
	'post_cid' => $post_cid ,
	'xoops_pagetitle' => $pagetitle4assign ,
	'xoops_breadcrumbs' => empty( $breadcrumbs ) ? $bc : $breadcrumbs ,
) ) ;
// display
include XOOPS_ROOT_PATH.'/footer.php';

?>