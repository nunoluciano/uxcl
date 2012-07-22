<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/class/rate_download.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

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

if( ! empty( $_POST['delvote']) ){
	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/" , 3 , $xoopsGTicket->getErrors() );
	}

	$cid = isset( $_POST['cid'] ) ? intval( $_POST['cid'] ) : 0 ;
	$lid = isset( $_POST['lid'] ) ? intval( $_POST['lid'] ) : 0 ;
	$errors = array();
	foreach( $_POST['delvote'] as $id => $value ) {
		if( empty( $value ) ) continue ;
		$ratingid = intval( $id ) ;
		$sql = "DELETE FROM ".$db->prefix( $mydirname."_votedata" )." WHERE ratingid='".$ratingid."'";
		$result = $db->query( $sql );
		if( ! $result ) $errors[] = $ratingid ;
		$rate_download = new rate_download( $mydirname ) ;
		$rate_download->UpdateRating( $lid ) ;
	}
	d3download_delete_cache_of_categories( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=modfile&amp;cid=$cid&amp;lid=$lid" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE ,  implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_DELETED ) ;
	exit();
} else {
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=modfile&amp;cid=$cid&amp;lid=$lid" , 2 , _MD_D3DOWNLOADS_NONDELETED ) ;
	exit();
}

?>