<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     attach_num
 * Version:  1.0
 * Date:     2007/03/22
 * Author:   t_yamo
 * Purpose:  
 * Input:    
 * 
 * Example1: Display num: {attachfile_attach_num dirname=attachfile target_id=$post.id}
 * Example2: Display label: {attachfile_attach_num dirname=attachfile label=1}
 * -------------------------------------------------------------
 */
function smarty_function_attachfile_attach_num( $params , &$smarty )
{
	$dirname = isset( $params['dirname'] ) ? $params['dirname'] : @$GLOBALS['xoopsModuleConfig']['attachfile_attach_dirname'] ;

	if( ! preg_match( '/^[0-9a-zA-Z_-]+$/' , $dirname ) || ! file_exists( XOOPS_TRUST_PATH.'/modules/attachfile/include/attach_smarty_functions.php' ) ) {
		echo "<p>attach_num does not set properly.</p>" ;
	} else {
		require_once( XOOPS_TRUST_PATH.'/modules/attachfile/include/attach_smarty_functions.php' ) ;
		if( isset( $params['label'] ) ) {
			// Example2
			attachfile_display_num_label( $dirname , $params ) ;
		} else {
			// Example1
			attachfile_display_num( $dirname , $params ) ;
		}
	}
}

?>
