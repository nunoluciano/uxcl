<?php

if (! function_exists('b_dbcss_scripthook_show') ) {
	function b_dbcss_scripthook_show( $options )
	{
		require_once dirname( dirname(__FILE__) ).'/include/main_functions.php' ;
		$mydirname = empty( $options[0] ) ? 'dbcss' : $options[0] ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$lid = empty( $options[1] ) ? 0 : intval ( $options[1] ) ;

		$useblock_header= empty( $options[2] ) ? 0 : 1 ;

		if( ! empty( $lid ) ){
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname($mydirname);
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );
			$script_data_cashe = intval( @$mod_config['script_data_cashe'] ) ;

			if( ! empty( $script_data_cashe ) ){
				$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
				$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$lid.'_'.$site_salt.'.php' ;
			}

			if( ! empty( $script_data_cashe ) && file_exists( $scriptlink_cache ) ){
				@include $scriptlink_cache ;
				$created = $created ? intval( $created ) : 0 ;
				$file_time = filemtime( $scriptlink_cache );

				if( ! empty( $body ) ){
					// TIME CHECK FOR SECURITY.
					if( $file_time == $created ){
						$scriptbody = dbcss_scriptdatashow( htmlspecialchars( $body, ENT_QUOTES ) ) ;
					}
				}
				$scriptcss = $css ? dbcss_scriptdatashow( htmlspecialchars( $css, ENT_QUOTES ) ) : 0 ;
			} elseif( empty( $script_data_cashe ) || empty( $scriptbody ) ){
				$db =& Database::getInstance();
				$sql = "SELECT body, css FROM ".$db->prefix( $mydirname."_scriptbody" )." WHERE lid = $lid";
				$result = $db->query( $sql );
				while( list( $txt, $csstxt ) = $db->fetchRow( $result ) ) {
					$scriptbody = dbcss_scriptdatashow( htmlspecialchars( $txt, ENT_QUOTES ) );
					$scriptcss = dbcss_scriptdatashow( htmlspecialchars( $csstxt, ENT_QUOTES ) );
				}
			}

		}
		if( ! empty( $scriptbody ) ){
			global $xoopsTpl;
			if( ! empty( $scriptcss ) ){
				$scriptdata = $scriptbody . "\n" . $scriptcss;
			} else {
				$scriptdata = $scriptbody;
			}

			if( ! empty( $useblock_header ) ) {
				$xoopsTpl->assign('xoops_block_header', $scriptdata . "\n" . $xoopsTpl->get_template_vars('xoops_block_header'));
			} else {
				$xoopsTpl->assign('xoops_module_header', $scriptdata . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));
			}
		}
	}
}

if (! function_exists('b_dbcss_scripthook_edit')) {
	function b_dbcss_scripthook_edit( $options )
	{
		$mydirname = empty( $options[0] ) ? 'dbcss' : $options[0] ;
		$lid = empty( $options[1] ) ? 0 : intval( $options[1] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		// get script_title
		$script = array( 0 => '--' ) ;
		$result = $db->query("SELECT lid, title FROM ".$db->prefix( $mydirname."_scriptbody" )."");
		while( list( $id , $title ) = $db->fetchRow( $result ) ) {
			$script[ $id ] = sprintf('%06d',$id).': '.$myts->makeTboxData4Show( $title ) ;
		}

		$useblock_header= empty( $options[2] ) ? 0 : 1 ;
		if( $useblock_header ) {
			$block_header_yes = "checked='checked'" ;
			$block_header_no = "" ;
		} else {
			$block_header_no = "checked='checked'" ;
			$block_header_yes = "" ;
		}

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'script' => $script ,
			'lid' => $lid ,
			'block_header_yes' => $block_header_yes ,
			'block_header_no' => $block_header_no ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_script.html' ) ;
	}
}

?>