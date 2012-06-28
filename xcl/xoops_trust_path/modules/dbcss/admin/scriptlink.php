<?php

require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;
$myts =& MyTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;

// PERMISSION ERROR
if( ! is_object( $xoopsUser )  &&  ! $xoopsUser->isAdmin() ) {
	die( 'Only administrator can use this feature.' ) ;
}

// CASHE CONFIG

$module_handler =& xoops_gethandler('module');
$config_handler =& xoops_gethandler('config');
$module =& $module_handler->getByDirname($mydirname);
$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
$script_data_cashe = intval( @$mod_config['script_data_cashe'] ) ;

// GET SCRIPTLIST

require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
$scriptlist = array() ;
$scriptlist = dbcss_getscriptlist( $mydirname );


// TITLE UPDATE

if( ! empty( $_POST['scriptlink_update'] ) && ! empty( $_POST['title'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$errors = array() ;
	foreach( $_POST['title'] as $lid => $title ) {
		if( empty( $title ) ) continue ;
		$lid = intval( $lid ) ;
		$title = "'".mysql_real_escape_string($myts->stripSlashesGPC( @$_POST['title'][$lid] ))."'" ;
		$result = $db->query( "UPDATE ".$db->prefix($mydirname."_scriptbody")." SET title=$title WHERE lid=$lid" ) ;
		if( ! $result ) $errors[] = $lid ;
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptlink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_REGSTERED ) ;
	exit();
}

// DELETE

if( ! empty( $_POST['delete'] ) && ! empty( $_POST['action_selects'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$errors = array() ;
	foreach( $_POST['action_selects'] as $lid => $value ) {
		if( empty( $value ) ) continue ;
		$lid = intval( $lid ) ;

		// if( !empty( $script_data_cashe ) ){
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$lid.'_'.$site_salt.'.php' ;

			if( file_exists( $scriptlink_cache ) ){
				unlink( $scriptlink_cache );
			}
		// }

		$sql = "DELETE FROM ".$db->prefix($mydirname."_scriptbody")." WHERE lid = ".$lid;
		$result = $db->query($sql);
		if( ! $result ) $errors[] = $lid ;
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptlink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_DELETED ) ;
	exit();
}

// CONFIG CHECK
if( file_exists( XOOPS_TRUST_PATH.'/cache/' ) ){
	$cache_dir = true;
}

if( is_writable( XOOPS_TRUST_PATH.'/cache/' ) ){
	$writable = true;
}

// display stage

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'scriptlink' ,
	'scriptlist' => $scriptlist ,
	'cache_dir' => $cache_dir ,
	'writable' => $writable ,
	'script_data_cashe' => $script_data_cashe ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'dbcss') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_scriptlink.html' ) ;
xoops_cp_footer();

?>