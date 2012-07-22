<?php

require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;
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

// TRANSACTION STAGE

if( ! empty( $_POST['update'] ) ) {
	set_time_limit( 0 ) ;

	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header( XOOPS_URL.'/',3,$xoopsGTicket->getErrors() );
	}
	$result = $db->query("SELECT lid FROM ".$db->prefix( $mydirname."_downloads" )."");
	while( list( $id ) = $db->fetchRow( $result ) ) {
		$lid = intval( $id );
		$irs = $db->query( "UPDATE ".$db->prefix( $mydirname."_downloads" )." SET smiley = '1', br = '1', xcode = '1' WHERE lid = '".$lid."'");
		if( ! $irs ) {
			echo _MD_D3DOWNLOADS_SQLONUPDATE ;
			echo $db->logger->dumpQueries() ;
			exit ;
		}
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import" , 3 , _MD_D3DOWNLOADS_UPDATEDONE ) ;
	exit ;
}
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_import.html' ) ;
xoops_cp_footer();

?>