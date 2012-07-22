<?php

global $xoopsModuleConfig;

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/history_download.php' ;

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

// GET ID FROM $_GET
if( ! empty( $_GET['id'] ) ) $id = intval( $_GET['id'] ) ;
elseif( ! empty( $_POST['id'] ) ) $id = intval( $_POST['id'] ) ;

$mod_url = XOOPS_URL.'/modules/'.$mydirname ;

// GET HISTORY DATA
$history = new history_download( $mydirname ) ;
$historydata = array() ;
$historydata = $history->get_history_data( $id );

// 存在しない LID の場合リダイレクト
if( empty( $historydata ) ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , _MD_D3DOWNLOADS_NOMATCH ) ;
	exit();
}

$lid = $historydata['lid'];
$history4assign = $historydata['historydata'];

// GET HISTORY lIST
$historylist = array() ;
$historylist = $history->get_history_list( $lid, $id );

// GET DOWNLOADDATA
include_once dirname(dirname(__FILE__)).'/class/mydownload.php' ;
$mydownload = new MyDownload( $mydirname, $lid );
$download4assign = $mydownload->get_downdata_for_singleview( 0, $lid, 0, 0, 1 );
$invisibleinfo = $mydownload->Invisible_Info();

// HISTORY RESTORE
if( ! empty( $_POST['restore'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}
	require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
	$errors = '';
	$id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0 ;
	$lid = isset( $_POST['lid'] ) ? intval( $_POST['lid'] ) : 0 ;
	$cid = isset( $_POST['cid'] ) ? intval( $_POST['cid'] ) : 0 ;

	$new_id = $history->history_Insert_DB( $lid ) ;
	$result = $history->history_Restore( $id, $lid );
	if( ! $result ) $errors = $id ;
	$history->history_Delete( $lid ) ;
	d3download_delete_cache_of_categories( $mydirname ) ;
	if( empty( $errors ) && empty( $invisibleinfo ) ){
		redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=singlefile&amp;cid='.$cid.'&amp;lid='.$lid , 2 , _MD_D3DOWNLOADS_RESTOREDONE ) ;
	} elseif( empty( $errors ) && ! empty( $invisibleinfo ) ){
		redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=history&amp;id='.$new_id , 2 , _MD_D3DOWNLOADS_RESTOREDONE ) ;
	} else {
		redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=history&amp;id='.$new_id , 2 , sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $errors ) ) ;
	}
	exit();
}

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => $mod_url ,
	'page' => 'history' ,
	'history' => $history4assign ,
	'historylist' => $historylist ,
	'down' => $download4assign ,
	'invisibleinfo' => $invisibleinfo ,
	'mod_config' => $xoopsModuleConfig ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_history.html' ) ;
xoops_cp_footer();

?>