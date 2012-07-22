<?php

if (! function_exists('b_d3downloads_category_show') ) {
	function b_d3downloads_category_show( $options )
	{
		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$intree = empty( $options[1] ) ? 0 : 1 ;
		$cols= empty( $options[2] ) ? 1 : intval( $options[2] ) ;
		$this_template = empty( $options[3] ) ? 'db:'.$mydirname.'_block_category.html' : trim( $options[3] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$user_access = new user_access( $mydirname ) ;
		$whr = "cid IN ( ".implode( ",", $user_access->can_read() )." )" ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		$whr_append = $mycategory->default_whr_append() ;
		$category = $mycategory->sitemap( 'index.php?', $whr, 0, $whr_append, $intree ) ;

		if( ! empty( $category ) ){
			$block['category'] = $category ;
			$block['mydirname'] = $mydirname ;
			$block['mod_url'] = XOOPS_URL.'/modules/'.$mydirname ;
			$block['intree'] = $intree;
			$block['cols'] = $cols;
			$block['lang_total'] = _MB_D3DOWNLOADS_TOTAL;

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

if (! function_exists('b_d3downloads_category_edit') ) {
	function b_d3downloads_category_edit( $options )
	{
		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$intree = empty( $options[1] ) ? 0 : 1 ;
		$cols= empty( $options[2] ) ? 1 : intval( $options[2] ) ;
		$this_template = empty( $options[3] ) ? 'db:'.$mydirname.'_block_category.html' : trim( $options[3] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl = new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'intree' => $intree ,
			'cols' => $cols ,
			'this_template' => $this_template ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_category.html' ) ;
	}
}

?>