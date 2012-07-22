<?php

function &attachfile_query( $sql )
{
	global $xoopsModuleConfig , $xoopsDB ;

	if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in get attached files" ) ;
	$attached_files = array() ;
	while( $attach_row = $xoopsDB->fetchArray( $result ) ) {
		$link_name = rawurldecode( $attach_row['title'] );
		if( ! empty( $xoopsModuleConfig['link_enc'] ) && function_exists('mb_convert_encoding') ) {
			$link_name = mb_convert_encoding( $link_name, $xoopsModuleConfig['link_enc'] ) ;
		}
		$attached_files[] = array(
			'attach_id' => intval( $attach_row['attach_id'] ),
			'module_dirname' => $attach_row['module_dirname'],
			'target_id' => intval( $attach_row['target_id'] ),
			'title' => $attach_row['title'],
			'saved_name' => $attach_row['saved_name'],
			'file_size' => intval( $attach_row['file_size'] ),
			'link_name' => $link_name,
		) ;
	}

	return $attached_files ;
}

function attachfile_get_saved_file_path( $mydirname , $saved_name )
{
	global $xoopsModuleConfig, $xoopsDB ;

	$uploads_path = XOOPS_TRUST_PATH."/uploads/".$mydirname ;
	if( strpos( $uploads_path, ".." ) )  die( _MD_ATTACHFILE_ERR_INVALIDUPLOADSPATH ) ;
	if( ! is_dir( $uploads_path ) ) die( _MD_ATTACHFILE_ERR_NONUPLOADSPATH ) ;
	if( ! is_writable( $uploads_path ) || ! is_readable( $uploads_path ) ) die( _MD_ATTACHFILE_ERR_DENYUPLOADSPATH ) ;
	$trans_saved_name = $saved_name ;
	if( ! empty( $xoopsModuleConfig['f_pre'] ) ) {
		if( $xoopsModuleConfig['f_pre'] == 1 ) {
			$trans_saved_name = XOOPS_DB_PREFIX.'_'.$trans_saved_name ;
		} else if( $xoopsModuleConfig['f_pre'] == 2 ) {
			$trans_saved_name = XOOPS_DB_NAME.'_'.$trans_saved_name ;
		}
	}
	return $uploads_path."/".$trans_saved_name ;
}

function attachfile_download_attach( $mydirname , $title , $saved_name )
{
	global $xoopsModuleConfig ;

	$saved_file_path = attachfile_get_saved_file_path( $mydirname , $saved_name ) ;

	header( "Cache-Control: private" ) ;
	header( "Content-Disposition: attachment; filename=".$title ) ;
	header( "Content-Type: application/octet-stream" ) ;
	header( "Content-Length: ".@filesize( $saved_file_path ) ) ;
	@readfile( $saved_file_path ) ;
}

function attachfile_delete_file( $mydirname , $attach_id )
{
	global $xoopsModuleConfig, $xoopsDB ;

	$attach_id = intval( $attach_id ) ;

	$sql = "SELECT saved_name FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE attach_id=$attach_id" ;
	if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in delete attache" ) ;
	while( list( $saved_name ) = $xoopsDB->fetchRow( $result ) ) {
		unlink( attachfile_get_saved_file_path( $mydirname , $saved_name ) ) ;
	}
	$xoopsDB->query( "DELETE FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE attach_id=$attach_id" ) ;
}

function attachfile_upload_file( $mydirname , $module_dirname , $target_id )
{
	global $xoopsModuleConfig, $xoopsDB ;

	$mime_type_limit_mode = $xoopsModuleConfig['mimem'] ;
	$mime_types = split( "\|", $xoopsModuleConfig['mimet'] ) ;
	$upload_mime_type = $_FILES['attach']['type'] ;
	if( $mime_type_limit_mode == 1 ) {
		// Deny
		if ( in_array( $upload_mime_type, $mime_types ) ) die( _MD_ATTACHFILE_ERR_DENY_MIMETYPE ) ;
	} else if ( $mime_type_limit_mode == 2 ) {
		// Allow
		if ( ! in_array( $upload_mime_type, $mime_types ) ) die( _MD_ATTACHFILE_ERR_DENY_MIMETYPE ) ;
	}

	$attach_size = $_FILES['attach']['size'] ;
	if( isset( $_FILES['attach'] ) && $attach_size != 0 ) {
		if( ! empty( $xoopsModuleConfig['max_size'] ) ) {
			if( $attach_size > $xoopsModuleConfig['max_size'] * 1000 ) die( _MD_ATTACHFILE_ERR_FILELARGE ) ;
		}
		$attach_name = $_FILES['attach']['name'] ;
		$attach_tmp_name = $_FILES['attach']['tmp_name'] ;
		$attach_name = addslashes( rawurlencode( $attach_name ) ) ;
		if( ! $xoopsDB->query( "INSERT INTO ".$xoopsDB->prefix( $mydirname."_attach" )." SET module_dirname='$module_dirname',target_id=$target_id,title='$attach_name',saved_name='',file_size=$attach_size" ) ) die( "DB ERROR IN INSERT attach" ) ;
		$attach_id = $xoopsDB->getInsertId();
		$saved_name = $module_dirname.str_pad( $attach_id, 10, "0", STR_PAD_LEFT ) ;
		if( ! $xoopsDB->query( "UPDATE ".$xoopsDB->prefix( $mydirname."_attach" )." SET saved_name='$saved_name' WHERE attach_id=$attach_id" ) ) die( "DB ERROR IN UPDATE attach" ) ;
		if( ! move_uploaded_file( $attach_tmp_name, attachfile_get_saved_file_path( $mydirname , $saved_name ) ) ) die( _MD_ATTACHFILE_ERR_UPLOADFAILED ) ;
	}
}

function attachfile_display_list( $mydirname , $module_dirname , $target_id, $mode )
{
	global $xoopsUser , $xoopsConfig , $xoopsModule , $xoopsModuleConfig , $xoopsDB ;

	$mod_url = XOOPS_URL.'/modules/'.$mydirname ;

	$sql = "SELECT * FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE module_dirname='$module_dirname' AND target_id=$target_id ORDER BY attach_id" ;
	$attached_files =& attachfile_query( $sql ) ;
	$attached_files_count = count( $attached_files ) ;
	$attached_files4assign = attachfile_htmlspecialchars_to_2array( $attached_files ) ;

	// TODO:template cache
	include_once XOOPS_ROOT_PATH.'/class/template.php';
	$xoopsTpl = new XoopsTpl() ;
	if( $xoopsConfig['debug_mode'] == 3 ) {
		$xoopsTpl->xoops_setDebugging( true ) ;
	}
	$xoopsTpl->assign(
		array(
			'module_title' => _MD_ATTACHFILE_TITLE ,
			'xoops_css' => XOOPS_URL. "/themes/" . $xoopsConfig['theme_set'] . "/style.css" ,
			'mod_url' => $mod_url ,
			'mydirname' => $mydirname ,
			'module_dirname' => $module_dirname ,
			'target_id' => $target_id ,
			'attached_files_count' => $attached_files_count ,
			'attached_files' => $attached_files4assign ,
			'unique_id' => $mydirname.'_COUNT_'.$module_dirname.'_'.$target_id ,
		)
	) ;
    $xoopsTpl->display( 'db:'.$mydirname.'_'.$mode.'.html' ) ;
}

function attachfile_htmlspecialchars_to_2array( $target )
{
	return array_map( 'attachfile_htmlspecialchars_to_array' , $target ) ;
}

function attachfile_htmlspecialchars_to_array( $target )
{
	return array_map( 'attachfile_htmlspecialchars' , $target ) ;
}

function attachfile_htmlspecialchars( $target )
{
	return htmlspecialchars( $target , ENT_QUOTES ) ;
}

?>
