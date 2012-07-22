<?php

if (! function_exists('b_d3downloads_download_show') ) {
	function b_d3downloads_download_show( $options )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$download_id = intval( @$options[1] ) ;
		$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_download.html' : trim( $options[2] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$mod_url = XOOPS_URL.'/modules/'.$mydirname ;
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

		$user_access = new user_access( $mydirname ) ;
		$whr_cat4read = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
		$mydownload = new MyDownload( $mydirname );
		$download4assign = $mydownload->get_downdata_for_singleview( $whr_cat4read, $download_id, 0, 0, 0, 1 ) ;
		$canuseshots = ! empty( $mod_config['useshots'] ) ? 1 : 0 ;
		$use_license = ! empty( $mod_config['use_license'] ) ? 1 : 0 ;
		$show_postname = ! empty( $mod_config['show_postname'] ) ? 1 : 0 ;

		if( ! empty( $download4assign ) ){
			global $xoopsModule;
			$dirname = is_object( @$xoopsModule ) ? $xoopsModule->getVar('dirname') : '' ;
			if( is_object( $GLOBALS['xoopsTpl'] ) && $dirname != $mydirname ) {
				require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
				$my_module_header = d3download_dbmoduleheader( $mydirname );
				$GLOBALS['xoopsTpl']->assign('xoops_module_header', $my_module_header . "\n" . $GLOBALS['xoopsTpl']->get_template_vars( "xoops_module_header" ) );
			}
			$block['download'] = $download4assign ;
			$block['mydirname'] = $mydirname ;
			$block['mod_url'] = $mod_url ;
			$block['canuseshots'] = $canuseshots ;
			$block['use_license'] = $use_license ;
			$block['show_postname'] = $show_postname ;
			$block['lang_title'] = _MB_D3DOWNLOADS_LANG_TITLE;
			$block['lang_ctitle'] = _MB_D3DOWNLOADS_LANG_CTITLE;
			$block['lang_version'] = _MB_D3DOWNLOADS_LANG_VERSION;
			$block['lang_updated'] = _MB_D3DOWNLOADS_LANG_DATE;
			$block['lang_description'] = _MB_D3DOWNLOADS_LANG_DESCRIPTION;
			$block['lang_hits'] = _MB_D3DOWNLOADS_LANG_HITS;
			$block['lang_size'] = _MB_D3DOWNLOADS_LANG_SIZE;
			$block['lang_kb'] = _MB_D3DOWNLOADS_LANG_KB;
			$block['lang_platform'] = _MB_D3DOWNLOADS_LANG_PLATFORM;
			$block['lang_license'] = _MB_D3DOWNLOADS_LICENSE;
			$block['lang_homepage'] = _MB_D3DOWNLOADS_LANG_HOMEPAGE;
			$block['lang_broken'] = _MB_D3DOWNLOADS_BROKEN_FILE;
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

if (! function_exists('b_d3downloads_download_edit') ) {
	function b_d3downloads_download_edit( $options )
	{
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$db =& Database::getInstance() ;
		$myts =& MyTextSanitizer::getInstance() ;
		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$download_id = intval( @$options[1] ) ;
		$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_download.html' : trim( $options[2] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		// get downloads_title
		$downloaddata = array() ;
		$downloaddata = d3download_get_downloads_title( $mydirname ) ;

		// get downloads_for edit
		$res = $db->query( "SELECT lid, cid FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid='".$download_id."'" ) ;
		while( list( $id , $catid ) = $db->fetchRow( $res ) ) {
			$lid = intval( $id ) ;
			$cid = intval( $catid ) ;
		}

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl = new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'download' => $downloaddata ,
			'download_id' => $download_id ,
			'lid' => $lid ,
			'cid' => $cid ,
			'this_template' => $this_template ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_download.html' ) ;
	}
}


?>