<?php

if (! function_exists('b_d3downloads_pickup_show') ) {
	function b_d3downloads_pickup_show( $options )
	{
		global $xoopsConfig ;
		$db =& Database::getInstance() ;
		$myts =& MyTextSanitizer::getInstance() ;

		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/block_download.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$file_ids = empty( $options[1] ) ? '' : $options[1] ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , d3download_list_order() ) ? 'd.date DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$max_size = empty( $options[4] ) ?  25 : intval( $options[4] )  ;
		$date_format = empty( $options[5] ) ? 'Y/m/d' :  htmlspecialchars ( $options[5] , ENT_QUOTES ) ;
		$block_type= empty( $options[6] ) ? 1 : intval( $options[6] ) ;
		$this_template = empty( $options[7] ) ? 'db:'.$mydirname.'_block_pickup.html' : trim( $options[7] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$user_access = new user_access( $mydirname ) ;
		$whr = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
		$block_download = new block_download( $mydirname ) ;
		$downdata = $block_download->get_downdata_for_block( $whr, $max_entry, $max_size, $date_format, $selected_order, 0, 0, 0, 1, $file_ids ) ;

		if( ! empty( $downdata ) ){
			$block['download'] = $downdata ;
			$block['mydirname'] = $mydirname ;
			$block['mod_url'] = XOOPS_URL.'/modules/'.$mydirname ;
			$block['selected_order'] = $selected_order;
			$block['type'] = $block_type;
			$block['lang_title'] = _MB_D3DOWNLOADS_LANG_TITLE;
			$block['lang_category'] = _MB_D3DOWNLOADS_LANG_CTITLE;
			$block['lang_postname'] = _MB_D3DOWNLOADS_LANG_POSTNAME;
			$block['lang_hits'] = _MB_D3DOWNLOADS_LANG_HITS;
			$block['lang_rating'] = _MB_D3DOWNLOADS_LANG_RATING;
			$block['lang_votes'] = _MB_D3DOWNLOADS_LANG_VOTES;
			$block['lang_updated'] = _MB_D3DOWNLOADS_LANG_DATE;

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

if (! function_exists('b_d3downloads_pickup_edit') ) {
	function b_d3downloads_pickup_edit( $options )
	{
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$file_ids = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , d3download_list_order() ) ? 'd.date DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$max_size = empty( $options[4] ) ?  25 : intval( $options[4] )  ;
		$date_format = empty( $options[5] ) ? 'Y/m/d' :  htmlspecialchars ( $options[5] , ENT_QUOTES ) ;
		$block_type= empty( $options[6] ) ? 1 : intval( $options[6] ) ;
		$this_template = empty( $options[7] ) ? 'db:'.$mydirname.'_block_pickup.html' : trim( $options[7] ) ;
		if( $block_type == 1 ) {
			$block_type_1 = "checked='checked'" ;
			$block_type_2 = "" ;
			$block_type_3 = "" ;
		} elseif( $block_type == 2 ) {
			$block_type_1 = "" ;
			$block_type_2 = "checked='checked'" ;
			$block_type_3 = "" ;
		} elseif( $block_type == 3 ) {
			$block_type_1 = "" ;
			$block_type_2 = "" ;
			$block_type_3 = "checked='checked'" ;
		}

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		// get downloads_title
		$downloaddata = array() ;
		$downloaddata = d3download_get_downloads_title( $mydirname ) ;

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl = new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'file_ids' => implode( ',' , $file_ids ) ,
			'order_options' => d3download_list_order() ,
			'selected_order' => $selected_order ,
			'max_entry' => $max_entry ,
			'max_size' => $max_size ,
			'date_format' => $date_format ,
			'block_size_1' => $block_type_1 ,
			'block_size_2' => $block_type_2 ,
			'block_size_3' => $block_type_3 ,
			'download' => $downloaddata ,
			'this_template' => $this_template ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_pickup.html' ) ;
	}
}

?>