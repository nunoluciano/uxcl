<?php

require_once dirname( dirname( __FILE__ ) ) .'/class/AttachfilePlugin.class.php';

function attachfile_check_upload_permission( $mydirname , $module_dirname , $target_id )
{
	$mytrustdirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$targettrustdirname = attachfile_get_targettrustdirname( $module_dirname ) ;

	$pluginObj = & AttachfilePlugin::getInstance ( $mydirname ,  $module_dirname , $targettrustdirname );
	
	if( ! $pluginObj->mPlug->attachfile_check_upload_permission_plugin( $target_id ) ) {
		return _MD_ATTACHFILE_ERR_CANTUPLOAD.' ('.$module_dirname.')' ;
	}
	return null ;
}

function attachfile_check_download_permission( $mydirname , $module_dirname , $target_id )
{
	$mytrustdirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$targettrustdirname = attachfile_get_targettrustdirname( $module_dirname ) ;

	$pluginObj = & AttachfilePlugin::getInstance ( $mydirname ,  $module_dirname , $targettrustdirname );

	if( ! $pluginObj->mPlug->attachfile_check_download_permission_plugin( $target_id ) ) {
		return _MD_ATTACHFILE_ERR_CANTDOWNLOAD.' ('.$module_dirname.')' ;
	}
	return null ;
}

function attachfile_get_targettrustdirname( $module_dirname )
{
	$targettrustfile = XOOPS_ROOT_PATH.'/modules/'.$module_dirname.'/mytrustdirname.php' ;
	if( ! file_exists( $targettrustfile ) ) {
		// Maybe non "D3 module".
		return '' ;
	}
	// ** YOU DON'T INCLUDE THIS FILE IN OTHER FUNCTION OR GLOBAL AREA.
	// ** THIS FILE OVERWRITE $mytrustdirname IN attachfile MODULE.
	// ** YOU SHOULD INCLUDE THIS FILE ONLY IN LIMITED FUNCTION.
	include $targettrustfile ;
	return $mytrustdirname ;
}

?>
