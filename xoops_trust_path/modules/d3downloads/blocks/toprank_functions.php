<?php

if (! function_exists('b_d3downloads_toprank_show') ) {
	function b_d3downloads_toprank_show( $options )
	{
		global $xoopsConfig ;
		$db =& Database::getInstance() ;
		$myts =& MyTextSanitizer::getInstance() ;

		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/block_download.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$categories = empty( $options[1] ) ? '' : $options[1] ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , d3download_list_order() ) ? 'd.hits DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$max_size = empty( $options[4] ) ?  25 : intval( $options[4] )  ;
		$date_format = empty( $options[5] ) ? 'Y/m/d' :  htmlspecialchars ( $options[5] , ENT_QUOTES ) ;
		$block_type= empty( $options[6] ) ? 1 : intval( $options[6] ) ;
		$this_template = empty( $options[7] ) ? 'db:'.$mydirname.'_block_toprank.html' : trim( $options[7] ) ;
		$intree = empty( $options[8] ) ? 0 : 1 ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$user_access = new user_access( $mydirname ) ;
		$whr = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
		$block_download = new block_download( $mydirname ) ;
		$downdata = $block_download->get_downdata_for_block( $whr, $max_entry, $max_size, $date_format, $selected_order, $categories, $intree );

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

if (! function_exists('b_d3downloads_toprank_edit') ) {
	function b_d3downloads_toprank_edit( $options )
	{
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , d3download_list_order() ) ? 'd.hits DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$max_size = empty( $options[4] ) ?  25 : intval( $options[4] )  ;
		$date_format = empty( $options[5] ) ? 'Y/m/d' :  htmlspecialchars ( $options[5] , ENT_QUOTES ) ;
		$block_type= empty( $options[6] ) ? 1 : intval( $options[6] ) ;
		$this_template = empty( $options[7] ) ? 'db:'.$mydirname.'_block_toprank.html' : trim( $options[7] ) ;
		$intree = empty( $options[8] ) ? 0 : 1 ;
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
			'max_size' => $max_size ,
			'date_format' => $date_format ,
			'block_size_1' => $block_type_1 ,
			'block_size_2' => $block_type_2 ,
			'block_size_3' => $block_type_3 ,
			'intree' => $intree ,
			'categories_list' => $categories_list ,
			'this_template' => $this_template ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_toprank.html' ) ;
	}
}

?>