<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     attach_download
 * Version:  1.0
 * Date:     2007/03/22
 * Author:   t_yamo
 * Purpose:  
 * Input:    
 * 
 * Example1: Display popup: {attachfile_attach_download dirname=attachfile target_id=$post.id}
 * Example2: Display label: {attachfile_attach_download dirname=attachfile label=1}
 * -------------------------------------------------------------
 */
function smarty_function_attachfile_attach_download( $params, &$smarty )
{
	$dirname = isset( $params['dirname'] ) ? $params['dirname'] : @$GLOBALS['xoopsModuleConfig']['attachfile_attach_dirname'] ;

	if( ! preg_match( '/^[0-9a-zA-Z_-]+$/' , $dirname ) || ! file_exists( XOOPS_TRUST_PATH.'/modules/attachfile/include/attach_smarty_functions.php' ) ) {
		echo "<p>attach_download does not set properly.</p>" ;
	} else {
		require_once( XOOPS_TRUST_PATH.'/modules/attachfile/include/attach_smarty_functions.php' ) ;
		if( isset( $params['label'] ) ) {
			// Example2
			attachfile_display_download_label( $dirname , $params ) ;
		} else {
			// Example1
			attachfile_display_download( $dirname , $params ) ;
		}
	}
}

?>
