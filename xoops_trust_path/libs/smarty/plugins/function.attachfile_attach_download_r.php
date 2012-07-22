<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     attach_download
 * Version:  1.0
 * Date:     2011/04/09
 * Author:   naao
 * Purpose:  
 * Input:    
 * 
 * Example1: {attachfile_attach_download item=attached item2=attach_link module_dirname=$mydirname dirname=attachfile target_id=$post.id}
 * -------------------------------------------------------------
 */
function smarty_function_attachfile_attach_download_r( $params, &$smarty )
{
	$mydirname = isset( $params['dirname'] ) ? $params['dirname'] : @$GLOBALS['xoopsModuleConfig']['attachfile_attach_dirname'] ;

	if( ! preg_match( '/^[0-9a-zA-Z_-]+$/' , $mydirname ) || ! file_exists( XOOPS_TRUST_PATH.'/modules/attachfile/include/attach_smarty_functions.php' ) ) {
		echo "<p>attach_download does not set properly.</p>" ;
	} else {
		require_once( XOOPS_TRUST_PATH.'/modules/attachfile/include/attach_smarty_functions.php' ) ;

		// 'isactive'/'module_read' check and include language
		// If the check failed, this function does nothing (not error).
		if( ! attachfile_process_instead_of_common( $mydirname ) ) {
			return ;
		}

		//$module_dirname = $xoopsModule->getVar('dirname') ;
		$module_dirname = $params['module_dirname'] ;
		$target_id = intval( $params['target_id'] ) ;
		$item = !empty($params['item']) ? $params['item'] : "attached" ;
		$item2 = !empty($params['item2']) ? $params['item2'] : "attach_link" ;

		// check download permission(= check num permission)
		$error_msg = attachfile_check_download_permission( $mydirname , $module_dirname , $target_id ) ;
		if ( isset( $error_msg ) ) {
			echo $error_msg ;
		}

		$xoopsDB =& Database::getInstance() ;

		// transaction and view
		$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix( $mydirname."_attach" )." WHERE module_dirname='$module_dirname' AND target_id=$target_id" ;
		if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in num popup" ) ;
		$row = $xoopsDB->fetchRow( $result ) ;
		$rtn = attachfile_display_popup_link_r( $mydirname , $module_dirname , $target_id , 'dpop' , _MD_ATTACHFILE_DOWNLOAD_POPUP , $row[0] );
		$smarty->assign( $item , $row[0] ) ;
		$smarty->assign( $item2 , $rtn ) ;
	}
}

function attachfile_display_popup_link_r( $mydirname , $module_dirname , $target_id , $mode , $title , $count )
{
	return '<a href="javascript:void(0)" onclick="window.open(\''.XOOPS_URL.'/modules/'.$mydirname.'/index.php?mode='.$mode.'&module_dirname='.$module_dirname.'&target_id='.$target_id.'\', \'attachfile_popup\', \'width=400,height=200,toolbar=no,menubar=no,scrollbars=yes,location=yes,status=yes,resizable=yes\')">'.$title.'(<span id="'.$mydirname.'_COUNT_'.$module_dirname.'_'.$target_id.'">'.$count.'</span>)</a>' ;

}

?>
