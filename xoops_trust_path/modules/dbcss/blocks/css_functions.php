<?php

if (! function_exists('b_dbcss_dbhook_show')) {
	function b_dbcss_dbhook_show( $options )
	{
		$mydirname = empty( $options[0] ) ? 'dbcss' : $options[0] ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		if ( empty($options[1]) ) {
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname($mydirname);
			$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
			$this_template = htmlspecialchars ( $mod_config['css_template'] , ENT_QUOTES ) ;
		} else {
			$this_template = htmlspecialchars ( $options[1] , ENT_QUOTES ) ;
		}

		$useblock_header= empty( $options[2] ) ? 0 : 1 ;
		$selected_media = empty( $options[3] ) ? 'all' : htmlspecialchars ( $options[3] , ENT_QUOTES ) ;

		require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
		global $xoopsTpl;
		if( $useblock_header) {
			$xoopsTpl->assign('xoops_block_header', dbcss_dbmoduleheader( $mydirname , $this_template , $selected_media ) . "\n" . $xoopsTpl->get_template_vars('xoops_block_header'));
		} else {
			$xoopsTpl->assign('xoops_module_header', dbcss_dbmoduleheader( $mydirname , $this_template , $selected_media ) . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));
		}
	}
}

if (! function_exists('b_dbcss_dbhook_edit')) {
	function b_dbcss_dbhook_edit( $options )
	{
		$db =& Database::getInstance();
		$mydirname = empty( $options[0] ) ? 'dbcss' : $options[0] ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		if ( empty($options[1]) ) {
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname($mydirname);
			$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
			$this_template = htmlspecialchars ( $mod_config['css_template'] , ENT_QUOTES ) ;
			$edit_template = $mydirname.'_'.$this_template;
		} else {
			$this_template = htmlspecialchars ( $options[1] , ENT_QUOTES ) ;
			if ( strstr ( $this_template , $mydirname.'_' )){
				$edit_template = $this_template ;
			} else {
				$edit_template = $mydirname.'_'.$this_template;
			}
		}

		require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
		$tplfile = dbcss_gettplname( $mydirname ) ;

		$useblock_header= empty( $options[2] ) ? 0 : 1 ;
		if( $useblock_header ) {
			$block_header_yes = "checked='checked'" ;
			$block_header_no = "" ;
		} else {
			$block_header_no = "checked='checked'" ;
			$block_header_yes = "" ;
		}
		$selected_media = empty( $options[3] ) ? 'all' : htmlspecialchars ( $options[3] , ENT_QUOTES ) ;

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'edit_template' => $edit_template ,
			'block_header_yes' => $block_header_yes ,
			'block_header_no' => $block_header_no ,
			'tplfile' => $tplfile ,
			'media_options' => b_dbcss_list_mediatype() ,
			'selected_media' => $selected_media ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_css.html' ) ;
	}
}

if (! function_exists('b_dbcss_hook_show')) {
	function b_dbcss_hook_show( $options )
	{
		$mydirname = empty( $options[0] ) ? 'dbcss' : $options[0] ;
		$myts =& MyTextSanitizer::getInstance();

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		if ( empty($options[1]) ) {
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname($mydirname);
			$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
			$css_name = $myts->htmlSpecialChars ( $mod_config['css_uri'] ) ;
		} else {
			$css_name = $myts->htmlSpecialChars ( $options[1] ) ;
		}

		$useblock_header= empty( $options[2] ) ? 0 : 1 ;
		$selected_media = empty( $options[3] ) ? 'all' : htmlspecialchars ( $options[3] , ENT_QUOTES ) ;

		global $xoopsTpl;
		require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
		if( $useblock_header) {
			$xoopsTpl->assign('xoops_block_header', dbcss_moduleheader( $mydirname , $css_name , $selected_media ) . "\n" . $xoopsTpl->get_template_vars('xoops_block_header'));
		} else {
			$xoopsTpl->assign('xoops_module_header', dbcss_moduleheader( $mydirname , $css_name , $selected_media ) . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));
		}
	}
}

if (! function_exists('b_dbcss_hook_edit')) {
	function b_dbcss_hook_edit( $options )
	{
		$mydirname = empty( $options[0] ) ? 'dbcss' : $options[0] ;
		$myts =& MyTextSanitizer::getInstance();
		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		if ( empty($options[1]) ) {
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname($mydirname);
			$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
			$css_name = $myts->htmlSpecialChars( $mod_config['css_uri'] ) ;
		} else {
			$css_name = $myts->htmlSpecialChars ( $options[1] ) ;
		}

		$useblock_header= empty( $options[2] ) ? 0 : 1 ;
		if( $useblock_header ) {
			$block_header_yes = "checked='checked'" ;
			$block_header_no = "" ;
		} else {
			$block_header_no = "checked='checked'" ;
			$block_header_yes = "" ;
		}

		$selected_media = empty( $options[3] ) ? 'all' : htmlspecialchars ( $options[3] , ENT_QUOTES ) ;
		$media_options = b_dbcss_list_mediatype();

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'css_name' => $css_name ,
			'block_header_yes' => $block_header_yes ,
			'block_header_no' => $block_header_no ,
			'media_options' => b_dbcss_list_mediatype() ,
			'selected_media' => $selected_media ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_cssfile.html' ) ;
	}
}

if (! function_exists('b_dbcss_list_mediatype')) {
	function b_dbcss_list_mediatype()
	{
		return array(
			'' => '----' ,
			'all' => 'all' ,
			'screen' => 'screen' ,
			'tty' => 'tty' ,
			'tv' => 'tv' ,
			'projection' => 'projection' ,
			'print' => 'print' ,
			'handheld' => 'handheld' ,
			'braille'=> 'braille' ,
			'embossed'=> 'embossed' ,
			'speech' => 'speech' ,
			'aural' => 'aural' ,
		) ;
	}
}
?>