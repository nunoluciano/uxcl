<?php

if (! function_exists('b_d3downloads_recent_show') ) {
	function b_d3downloads_recent_show( $options )
	{
		global $xoopsConfig ;
		$db =& Database::getInstance() ;
		$myts =& MyTextSanitizer::getInstance() ;

		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/block_download.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$max_entry = empty( $options[1] ) ? 10 : intval( $options[1] )  ;
		$max_size = empty( $options[2] ) ?  25 : intval( $options[2] )  ;
		$date_format = empty( $options[3] ) ? 'Y/m/d' :  htmlspecialchars ( $options[3] , ENT_QUOTES ) ;
		$block_type= empty( $options[4] ) ? 1 : intval( $options[4] ) ;
		$this_template = empty( $options[5] ) ? 'db:'.$mydirname.'_block_recent.html' : trim( $options[5] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$user_access = new user_access( $mydirname ) ;
		$whr = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
		$block_download = new block_download( $mydirname ) ;

		$downdata = $block_download->get_downdata_for_block( $whr, $max_entry, $max_size, $date_format, 'd.date DESC' ) ;

		if( ! empty( $downdata ) ){
			$block['download'] = $downdata ;
			$block['mydirname'] = $mydirname ;
			$block['mod_url'] = XOOPS_URL.'/modules/'.$mydirname ;
			$block['type'] = $block_type;
			$block['lang_title'] = _MB_D3DOWNLOADS_LANG_TITLE;
			$block['lang_category'] = _MB_D3DOWNLOADS_LANG_CTITLE;
			$block['lang_postname'] = _MB_D3DOWNLOADS_LANG_POSTNAME;
			$block['lang_hits'] = _MB_D3DOWNLOADS_LANG_HITS;
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

if (! function_exists('b_d3downloads_recent_edit') ) {
	function b_d3downloads_recent_edit( $options )
	{
		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$max_entry = empty( $options[1] ) ? 10 : intval( $options[1] )  ;
		$max_size = empty( $options[2] ) ?  25 : intval( $options[2] )  ;
		$date_format = empty( $options[3] ) ? 'Y/m/d' :  htmlspecialchars ( $options[3] , ENT_QUOTES ) ;
		$block_type= empty( $options[4] ) ? 1 : intval( $options[4] ) ;
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
		$this_template = empty( $options[5] ) ? 'db:'.$mydirname.'_block_recent.html' : trim( $options[5] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl = new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'max_entry' => $max_entry ,
			'max_size' => $max_size ,
			'date_format' => $date_format ,
			'block_size_1' => $block_type_1 ,
			'block_size_2' => $block_type_2 ,
			'block_size_3' => $block_type_3 ,
			'this_template' => $this_template ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_recent.html' ) ;
	}
}

?>