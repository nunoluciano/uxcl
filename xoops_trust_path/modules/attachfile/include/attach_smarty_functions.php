<?php

include_once dirname( __FILE__ ).'/permission.php' ;

// called as smarty plugin by client module
function attachfile_display_upload( $mydirname , $params )
{
	global $xoopsModule , $xoopsDB ;

	// 'isactive'/'module_read' check and include language
	// If the check failed, this function does nothing (not error).
	if( ! attachfile_process_instead_of_common( $mydirname ) ) {
		return ;
	}

	$module_dirname = $xoopsModule->getVar('dirname') ;
	$target_id = $params['target_id'] ;

	// if new post
	if( ! isset( $target_id ) ) {
		echo _MD_ATTACHFILE_NOTSPECIFIEDID ;
		return ;
	}

	// check upload permission
	$error_msg = attachfile_check_upload_permission( $mydirname , $module_dirname , $target_id ) ;
	if ( isset( $error_msg ) ) {
		echo $error_msg ;
		return ;
	}

	// transaction and view
	$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE module_dirname='$module_dirname' AND target_id=$target_id" ;
	if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in upload popup" ) ;
	$row = $xoopsDB->fetchRow( $result ) ;
	attachfile_display_popup_link( $mydirname , $module_dirname , $target_id , 'upop' , _MD_ATTACHFILE_UPLOAD_POPUP , $row[0] );
}

// called as smarty plugin by client module
function attachfile_display_download( $mydirname , $params )
{
	global $xoopsModule , $xoopsDB ;

	// 'isactive'/'module_read' check and include language
	// If the check failed, this function does nothing (not error).
	if( ! attachfile_process_instead_of_common( $mydirname ) ) {
		return ;
	}

	if ( isset( $params['target_dirname'] ) ) {
		$module_dirname = $params['target_dirname'] ;
	} else {
		$module_dirname = $xoopsModule->getVar('dirname') ;
	}

	$target_id = intval( $params['target_id'] ) ;

	// check download permission
	$error_msg = attachfile_check_download_permission( $mydirname , $module_dirname , $target_id ) ;
	if ( isset( $error_msg ) ) {
		echo $error_msg ;
		return ;
	}

	// transaction and view
	$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE module_dirname='$module_dirname' AND target_id=$target_id" ;
	if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in download popup" ) ;
	$row = $xoopsDB->fetchRow( $result ) ;
	attachfile_display_popup_link( $mydirname , $module_dirname , $target_id , 'dpop' , _MD_ATTACHFILE_DOWNLOAD_POPUP , $row[0] );
}

// called as smarty plugin by client module
function attachfile_display_num( $mydirname , $params )
{
	global $xoopsModule , $xoopsDB ;

	// 'isactive'/'module_read' check and include language
	// If the check failed, this function does nothing (not error).
	if( ! attachfile_process_instead_of_common( $mydirname ) ) {
		return ;
	}

	$module_dirname = $xoopsModule->getVar('dirname') ;
	$target_id = intval( $params['target_id'] ) ;

	// check download permission(= check num permission)
	$error_msg = attachfile_check_download_permission( $mydirname , $module_dirname , $target_id ) ;
	if ( isset( $error_msg ) ) {
		echo $error_msg ;
		return ;
	}

	// transaction and view
	$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE module_dirname='$module_dirname' AND target_id=$target_id" ;
	if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in num popup" ) ;
	$row = $xoopsDB->fetchRow( $result ) ;
	echo $row[0] ;
}

// called as smarty plugin by client module
function attachfile_display_upload_label( $mydirname , $params )
{
	// This function only use display static messages,
	// so it skip permission check.
	attachfile_include_language( $mydirname ) ;
	echo _MD_ATTACHFILE_LABEL_UPLOAD ;
}

// called as smarty plugin by client module
function attachfile_display_download_label( $mydirname , $params )
{
	// This function only use display static messages,
	// so it skip permission check.
	attachfile_include_language( $mydirname ) ;
	echo _MD_ATTACHFILE_LABEL_DOWNLOAD ;
}

// called as smarty plugin by client module
function attachfile_display_num_label( $mydirname , $params )
{
	// This function only use display static messages,
	// so it skip permission check.
	attachfile_include_language( $mydirname ) ;
	echo _MD_ATTACHFILE_LABEL_NUM ;
}

// called by smarty plugins private
function attachfile_display_popup_link( $mydirname , $module_dirname , $target_id , $mode , $title , $count )
{
	echo '<a href="javascript:void(0)" onclick="window.open(\''.XOOPS_URL.'/modules/'.$mydirname.'/index.php?mode='.$mode.'&module_dirname='.$module_dirname.'&target_id='.$target_id.'\', \'attachfile_popup\', \'width=400,height=200,toolbar=no,menubar=no,scrollbars=yes,location=yes,status=yes,resizable=yes\')">'.$title.'(<span id="'.$mydirname.'_COUNT_'.$module_dirname.'_'.$target_id.'">'.$count.'</span>)</a>' ;
}

// called by smarty plugins private
function attachfile_process_instead_of_common( $mydirname )
{
	global $xoopsUser ;

	// check the attachfile exists and is active
	// (instead of common.php)
	$module_hanlder =& xoops_gethandler( 'module' ) ;
	$module =& $module_hanlder->getByDirname( $mydirname ) ;
	if( ! is_object( $module ) || ! $module->getVar( 'isactive' ) ) {
		return false ;
	}

	// check permission of "module_read"
	// (instead of common.php)
	$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
	$groups = is_object( $xoopsUser ) ? $xoopsUser->getGroups() : array( XOOPS_GROUP_ANONYMOUS ) ;
	if( ! $moduleperm_handler->checkRight( 'module_read' , $module->getVar( 'mid' ) , $groups ) ) {
		return false ;
	}

	// language files
	// (instead of common.php)
	attachfile_include_language( $mydirname ) ;

	return true ;
}

// called by smarty plugins private
function attachfile_include_language( $mydirname )
{
	global $xoopsConfig ;

	$mydirpath = XOOPS_ROOT_PATH.'/modules/'.$mydirname ;
	$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$root =& XCube_Root::getSingleton() ;
		$language = $root->mLanguageManager->getLanguage() ;
	} else {
		$language = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'] ;
	}
	if( file_exists( "$mydirpath/language/$language/main.php" ) ) {
		// user customized language file (already read by common.php)
		include_once "$mydirpath/language/$language/main.php" ;
	} else if( file_exists( "$mytrustdirpath/language/$language/main.php" ) ) {
		// default language file
		include_once "$mytrustdirpath/language/$language/main.php" ;
	} else {
		// fallback english
		include_once "$mytrustdirpath/language/english/main.php" ;
	}
}

?>
