<?php

include XOOPS_ROOT_PATH.'/header.php';
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$xoopsOption['template_main'] = $mydirname.'_main_ratedownload.html' ;

$user_access = new user_access( $mydirname ) ;
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
$whr_cat4read = "d.".$whr_cat ;

$cid = empty( $_GET['cid'] ) ? 0 : intval( $_GET['cid'] ) ;
$bc[0] = d3download_breadcrumbs( $mydirname ) ;
$breadcrumbs = array_merge( $bc ,d3download_breadcrumbs_tree( $mydirname, $cid, $whr_cat, '', 1 ) ) ;
$lid = empty( $_GET['lid'] ) ? 0 : intval( $_GET['lid'] ) ;
$download4assign = d3download_get_title( $mydirname, $lid, $whr_cat4read );
$title4assign = $download4assign['title'] ;
$breadcrumbs[] = array( 'name' => $title4assign ) ;

if( ! empty( $_POST['rate_submit'] ) ) {
	require_once dirname( dirname(__FILE__) ).'/class/rate_download.php' ;
	$rate_download = new rate_download( $mydirname, 'Rate' ) ;
	$rate_download->Ratefile_Execution( $cid, $lid );
}

// store the referer
if( empty( $_SESSION["{$mydirname}_uri4return"] ) && ! empty( $_SERVER['HTTP_REFERER'] ) ) {
	$_SESSION["{$mydirname}_uri4return"] = $_SERVER['HTTP_REFERER'] ;
}

$xoops_module_header = d3download_dbmoduleheader( $mydirname, array( 'jquery.js' , 'd3downloads.js' ) );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));

$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'ratefile' ,
	'down' => $download4assign ,
	'lang_voteonce' => _MD_D3DOWNLOADS_VOTEONCE ,
	'lang_ratingscale' => _MD_D3DOWNLOADS_RATINGSCALE ,
	'lang_beobjective' => _MD_D3DOWNLOADS_BEOBJECTIVE ,
	'lang_donotvote' => _MD_D3DOWNLOADS_DONOTVOTE ,
	'lang_rateit' =>  _MD_D3DOWNLOADS_RATEIT ,
	'lang_cancel' => _CANCEL ,
	'xoops_pagetitle' => $title4assign ,
	'xoops_breadcrumbs' => $breadcrumbs ,
	'mod_config' => $xoopsModuleConfig ,
) ) ;

include XOOPS_ROOT_PATH.'/footer.php';

?>