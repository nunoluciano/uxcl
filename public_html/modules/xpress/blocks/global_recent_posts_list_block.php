<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '
function b_'.$mydirname.'_global_posts_show($options){
	return _b_global_posts_show($options) ;
}
function b_'.$mydirname.'_global_posts_edit($options){
	return _b_global_posts_edit($options) ;
}
' ) ;

if( ! defined( 'XPRESS_GLOBAL_POSTS_BLOCK_INCLUDED' ) ) {
	define( 'XPRESS_GLOBAL_POSTS_BLOCK_INCLUDED' , 1 ) ;
	function _b_global_posts_edit($options)
	{
		$mydirname = empty( $options[0] ) ? 'xpress' : $options[0] ;
		$this_template = empty( $options[1] ) ? 'db:'.$mydirname.'_global_recent_posts_list_block.html' : trim( $options[1] );
		$disp_count = empty( $options[2] ) ? '10' : $options[2] ;
		$disp_red = empty( $options[3] ) ? '1' : $options[3] ;
		$disp_green = empty( $options[4] ) ? '7' : $options[4] ;
		$date_format = empty( $options[5] ) ? '' : $options[5] ;
		$time_format = empty( $options[6] ) ? '' : $options[6] ;
		$Shown_for_each_blog = empty( $options[7] ) ? false : true ;		
		$exclusion_blog = empty( $options[8] ) ? '0' : $options[8] ;

		$mydirpath = XOOPS_ROOT_PATH . '/modules/' . $mydirname;
		
		require_once(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/blocks/block_common.php');

		$form  = javascript_check();
		$form .= "MyDirectory <input type='text' name='options[0]' value='" . $mydirname . "' /><br />\n";
		$form .= block_template_setting($mydirname,'options[1]',htmlspecialchars($this_template,ENT_QUOTES));
		$form .= "<br />\n";	
		$form .= _MB_XP2_COUNT .": <input type='text' size='3' name='options[2]' value='" . $disp_count . "' /><br />\n";
		$form .= _MB_XP2_REDNEW_DAYS .": <input type='text' size='3' name='options[3]' value='" . $disp_red . "' /><br />\n";
		$form .= _MB_XP2_GREENNEW_DAYS .": <input type='text' size='3' name='options[4]' value='" . $disp_green . "' /><br />\n";
		$form .= _MB_XP2_DATE_FORMAT .": <input type='text' name='options[5]' value='" . $date_format . "' /><br />\n";
		$form .= _MB_XP2_TIME_FORMAT .": <input type='text' name='options[6]' value='" . $time_format . "' /><br />\n";
		$form .= yes_no_radio_option('options[7]', _MB_XP2_SHOWN_FOR_EACH_BLOG , $Shown_for_each_blog) . "<br />\n";
	    $form .= blog_select('options[8]' , $exclusion_blog,true);

		return $form;
	}

	function _b_global_posts_show($options)
	{
		$mydirname = empty( $options[0] ) ? 'xpress' : $options[0] ;
		$mydirpath = XOOPS_ROOT_PATH . '/modules/' . $mydirname;
		$block_function_name = basename( __FILE__ );
		
		require_once $mydirpath.'/include/xpress_block_render.php';
		return xpress_block_render($mydirname,$block_function_name,$options);
	}
}
?>