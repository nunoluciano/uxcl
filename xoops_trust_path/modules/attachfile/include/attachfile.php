<?php

include_once dirname( __FILE__ ).'/utility.php' ;
include_once dirname( __FILE__ ).'/permission.php' ;
include_once dirname( __FILE__ ).'/attach_functions.php' ;

$mode = attachfile_reqstr( 'mode' ) ;

if( $mode == 'upop' || $mode == 'dpop' ) {

	// params
	$module_dirname = attachfile_reqstr( 'module_dirname' ) ;
	$target_id = attachfile_reqint( 'target_id' ) ;

	// permission check
	// check download permission
	$error_msg = attachfile_check_download_permission( $mydirname , $module_dirname , $target_id ) ;
	if ( isset( $error_msg ) ) {
		echo $error_msg ;
		return ;
	}

	// transaction
	// N/A

	// view
	attachfile_display_list( $mydirname , $module_dirname , $target_id, $mode ) ;

} else if( $mode == 'download' ) {

	// params
	$attach_id = attachfile_reqint( 'attach_id' ) ;

	// pre transaction (for permission check)
	// ** DON'T GET "module_dirname" AND "target_id" FROM REQUEST.
	// ** THEY MIGHT BE CHEAT.
	// ** YOU SHOULD GET THEM ONLY BY "attach_id" IN DOWNLOAD PROCESS.
	$sql = "SELECT * FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE attach_id=$attach_id" ;
	$attached_files =& attachfile_query( $sql ) ;
	$attached_files_count = count( $attached_files[0] ) ;
	if( $attached_files_count == 0 ) die( _MD_ATTACHFILE_ERR_READATTACH ) ;
	$module_dirname = $attached_files[0]['module_dirname'] ;
	$target_id = $attached_files[0]['target_id'] ;

	// permission check
	// check download permission
	$error_msg = attachfile_check_download_permission( $mydirname , $module_dirname , $target_id ) ;
	if ( isset( $error_msg ) ) {
		echo $error_msg ;
		return ;
	}

	// transaction
	$agent = $_SERVER["HTTP_USER_AGENT"] ;
	$title = rawurldecode( $attached_files[0]['title'] ) ;

	if( strstr( $agent, "MSIE" ) ) {
		if( ! empty( $xoopsModuleConfig['ttl_enc_ie'] ) && function_exists('mb_convert_encoding') ) {
			$title = mb_convert_encoding( $title, $xoopsModuleConfig['ttl_enc_ie'] ) ;
		}
	} else {
		if( ! empty( $xoopsModuleConfig['ttl_enc_oth'] ) && function_exists('mb_convert_encoding') ) {
			$title = mb_convert_encoding( $title, $xoopsModuleConfig['ttl_enc_oth'] ) ;
		}
	}
	$saved_name = $attached_files[0]['saved_name'] ;

	// view
	attachfile_download_attach( $mydirname , $title , $saved_name ) ;

} else if( $mode == 'delete' ) {

	// params
	$attach_id = attachfile_reqint( 'attach_id' ) ;

	// pre transaction (for permission check)
	// ** DON'T GET "module_dirname" AND "target_id" FROM REQUEST.
	// ** THEY MIGHT BE CHEAT.
	// ** YOU SHOULD GET THEM ONLY BY "attach_id" IN DELETE PROCESS.
	$sql = "SELECT * FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE attach_id=$attach_id" ;
	$attached_files =& attachfile_query( $sql ) ;
	$attached_files_count = count( $attached_files[0] ) ;
	if( $attached_files_count == 0 ) die( _MD_ATTACHFILE_ERR_READATTACH ) ;
	$module_dirname = $attached_files[0]['module_dirname'] ;
	$target_id = $attached_files[0]['target_id'] ;

	// permission check
	// check download permission
	$error_msg = attachfile_check_upload_permission( $mydirname , $module_dirname , $target_id ) ;
	if ( isset( $error_msg ) ) {
		echo $error_msg ;
		return ;
	}

	// transaction
	attachfile_delete_file( $mydirname , $attach_id ) ;

	// view
	attachfile_display_list( $mydirname , $module_dirname , $target_id, 'upop' ) ;

} else if( $mode == 'upload' ) {

	// params
	$module_dirname = attachfile_reqstr( 'module_dirname' ) ;
	$target_id = attachfile_reqint( 'target_id' ) ;

	// permission check
	// check download permission
	$error_msg = attachfile_check_upload_permission( $mydirname , $module_dirname , $target_id ) ;
	if ( isset( $error_msg ) ) {
		echo $error_msg ;
		return ;
	}

	// transaction
	attachfile_upload_file( $mydirname , $module_dirname , $target_id ) ;

	// view
	attachfile_display_list( $mydirname , $module_dirname , $target_id, 'upop' ) ;

}

?>
