<?php

require_once dirname( dirname(__FILE__) ).'/class/gtickets.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
require_once dirname( dirname(__FILE__) ).'/include/import_functions.php' ;

// uploads_dir config check
$uploads_dir_error = 0;
$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;
$safe_mode = ini_get( "safe_mode" ) ;
if( ! is_dir( $uploads_dir ) ) {
	if( $safe_mode ) {
		$uploads_dir_error = 1;
	}
	$mrs = mkdir( $uploads_dir , 0777 ) ;
	if( ! $mrs ) {
		$uploads_dir_error = 1;
	} else @chmod( $uploads_dir , 0777 ) ;
}
if( ! is_writable( $uploads_dir ) || ! is_readable( $uploads_dir ) ) {
	$mrs = chmod( $uploads_dir , 0777 ) ;
	if( ! $mrs ) {
		$uploads_dir_error = 1;
	}
}
if( empty( $uploads_dir_error ) ){
	$uploadfile_info = sprintf( _MD_D3DOWNLOADS_FILE_IMPORT_HELP , $uploads_dir );
} else {
	$uploadfile_info = sprintf( _MD_D3DOWNLOADS_FILE_CONFIGERROR_HELP , $uploads_dir );
}

// get importable modules list
$module_handler =& xoops_gethandler( 'module' ) ;
$modules =& $module_handler->getObjects() ;
$importable_modules = array() ;
foreach( $modules as $module ) {
	$mid = $module->getVar('mid') ;
	$dirname = $module->getVar('dirname') ;
	$dirpath = XOOPS_ROOT_PATH.'/modules/'.$dirname ;
	$mytrustdirname = '' ;
	$tables = $module->getInfo('tables') ;
	$version = intval( $module->getVar('version'));
	if( file_exists( $dirpath.'/mytrustdirname.php' ) ) {
		include $dirpath.'/mytrustdirname.php' ;
	}
	if( $mytrustdirname == 'd3downloads' && $dirname != $mydirname ) {
		// d3downloads
		$importable_modules[$mid] = 'd3downloads:'.$module->getVar('name')." ( $dirname )" ;
	} elseif( stristr( @$tables[0] , 'mydownloads' ) ) {
		// mydownloads
		$importable_modules[$mid] = 'mydownloads:'.$module->getVar('name')." ($dirname)" ;
	} elseif( stristr( @$tables[0] , 'wfdownloads' ) && $version >= '310' ) {
		// wfdownloads
		$importable_modules[$mid] = 'wfdownloads:'.$module->getVar('name')." ($dirname)" ;
	} elseif( $mytrustdirname == 'mydownloads_w' ) {
		// mydownloads_w
		$importable_modules[$mid] = 'mydownloads_w:'.$module->getVar('name')." ( $dirname )" ;
	}
}

// TRANSACTION STAGE

if( ! empty( $_POST['do_import'] ) && ! empty( $_POST['import_mid'] ) ) {
	set_time_limit( 0 ) ;

	if ( ! $xoopsGTicket->check( true , 'd3downloads' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	$import_mid = intval( @$_POST['import_mid'] ) ;
	if( empty( $importable_modules[ $import_mid ] ) ) die( _MD_D3DOWNLOADS_ERR_INVALIDMID ) ;
	list( $fromtype , ) = explode( ':' , $importable_modules[ $import_mid ] ) ;
	switch( $fromtype ) {
		case 'd3downloads' :
			d3download_import_from_d3download( $mydirname , $import_mid, $uploads_dir_error ) ;
			break ;
		case 'mydownloads' :
			d3download_import_from_mydownloads( $mydirname , $import_mid ) ;
			break ;
		case 'wfdownloads' :
			d3download_import_from_wfdownloads( $mydirname , $import_mid ) ;
			break ;
		case 'mydownloads_w' :
			d3download_import_from_mydownloads( $mydirname , $import_mid ) ;
			break ;
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import" , 3 , _MD_D3DOWNLOADS_IMPORTDONE ) ;
	exit ;
}

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_name' => $xoopsModule->getVar('name') ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'mod_config' => $xoopsModuleConfig ,
	'import_from_options' => $importable_modules ,
	'uploadfile_info' => $uploadfile_info ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3downloads') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_import.html' ) ;
xoops_cp_footer();

?>