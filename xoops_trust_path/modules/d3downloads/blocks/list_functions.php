<?php

if (! function_exists('b_d3downloads_list_show') ) {
	function b_d3downloads_list_show( $options )
	{
		global $xoopsConfig ;
		$db =& Database::getInstance() ;
		$myts =& MyTextSanitizer::getInstance() ;

		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/block_download.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$categories = empty( $options[1] ) ? '' : $options[1] ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , d3download_list_order() ) ? 'd.date DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$date_format = empty( $options[4] ) ? 'Y/m/d' :  htmlspecialchars ( $options[4] , ENT_QUOTES ) ;
		$show_body = empty( $options[5] ) ? false : true ;
		$this_template = empty( $options[6] ) ? 'db:'.$mydirname.'_block_list.html' : trim( $options[6] ) ;
		$intree = empty( $options[7] ) ? 0 : 1 ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$user_access = new user_access( $mydirname ) ;
		$whr = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
		$block_download = new block_download( $mydirname ) ;
		$downdata = $block_download->get_downdata_for_block( $whr, $max_entry, 0, $date_format, $selected_order, $categories, $intree ) ;
		if( ! empty( $downdata ) ){
			$block['download'] = $downdata ;
			$block['mydirname'] = $mydirname ;
			$block['mod_url'] = XOOPS_URL.'/modules/'.$mydirname ;
			$block['show_body'] = $show_body;

			if( empty( $options['disable_renderer'] ) ) {
				require_once XOOPS_ROOT_PATH.'/class/template.php' ;
				$tpl = new XoopsTpl() ;
				$tpl->assign( 'block' , $block ) ;
				$ret['content'] = $tpl->fetch( $this_template ) ;
				return $ret ;
			} else {
				return $block ;
			}
		}
	}
}

if (! function_exists('b_d3downloads_list_edit') ) {
	function b_d3downloads_list_edit( $options )
	{
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , d3download_list_order() ) ? 'd.date DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$date_format = empty( $options[4] ) ? 'Y/m/d' :  htmlspecialchars ( $options[4] , ENT_QUOTES ) ;
		$show_body = empty( $options[5] ) ? false : true ;
		$this_template = empty( $options[6] ) ? 'db:'.$mydirname.'_block_list.html' : trim( $options[6] ) ;
		$intree = empty( $options[7] ) ? 0 : 1 ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		// getcategories_list
		$categories_list = array() ;
		$categories_list = d3download_get_categories_list( $mydirname ) ;

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl = new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'categories' => implode( ',' , $categories ) ,
			'order_options' => d3download_list_order() ,
			'selected_order' => $selected_order ,
			'max_entry' => $max_entry ,
			'date_format' => $date_format ,
			'show_body' => $show_body ,
			'intree' => $intree ,
			'categories_list' => $categories_list ,
			'this_template' => $this_template ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_list.html' ) ;
	}
}

?>