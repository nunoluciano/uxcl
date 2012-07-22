<?php

eval('function xoops_module_update_'.$mydirname.'($module){return xsns_onupdate($module, "'.$mydirname.'");}');

if( !function_exists('xsns_onupdate') ) {

function xsns_onupdate($module, $mydirname)
{
	global $ret;

	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Success', 'xsns_message_append_onupdate' ) ;
		$ret = array() ;
	} else {
		if( ! is_array( $ret ) ) $ret = array() ;
	}
	
	$db =& Database::getInstance() ;
	$mid = $module->getVar('mid') ;
	
	
	// 1.0.x => 1.1.x
	$check_sql = "SELECT config_id FROM ".$db->prefix($mydirname.'_c_mypage_config');
	if(!$db->query($check_sql)){
		$sql = "CREATE TABLE `".$db->prefix($mydirname.'_c_mypage_config')."` (".
				"`config_id` int(11) unsigned NOT NULL auto_increment,".
				"`uid` int(11) unsigned NOT NULL,".
				"`config_values` text NOT NULL,".
				"PRIMARY KEY  (`config_id`)".
				") ENGINE=MyISAM";
		$db->query($sql);
	}
	
	
	// Templates
	$tplfile_handler =& xoops_gethandler( 'tplfile' ) ;
	$tpl_path = dirname(__FILE__).'/templates' ;
	if( $handler = @opendir( $tpl_path . '/' ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 1 ) == '.' || !preg_match('/(\.html$)|(\.css$)/i', $file)){
				continue ;
			}
			$file_path = $tpl_path . '/' . $file ;
			if( is_file( $file_path ) ) {
				$mtime = intval( @filemtime( $file_path ) ) ;
				$tplfile =& $tplfile_handler->create() ;
				$tplfile->setVar( 'tpl_source' , file_get_contents( $file_path ) , true ) ;
				$tplfile->setVar( 'tpl_refid' , $mid ) ;
				$tplfile->setVar( 'tpl_tplset' , 'default' ) ;
				$tplfile->setVar( 'tpl_file' , $mydirname.'_'.$file ) ;
				$tplfile->setVar( 'tpl_desc' , '' , true ) ;
				$tplfile->setVar( 'tpl_module' , $mydirname ) ;
				$tplfile->setVar( 'tpl_lastmodified' , $mtime ) ;
				$tplfile->setVar( 'tpl_lastimported' , 0 ) ;
				$tplfile->setVar( 'tpl_type' , 'module' ) ;
				if( ! $tplfile_handler->insert( $tplfile ) ) {
					$ret[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
				} else {
					$tplid = $tplfile->getVar( 'tpl_id' ) ;
					$ret[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tplid.'</b>)';
					// generate compiled file
					include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
					include_once XOOPS_ROOT_PATH.'/class/template.php' ;
					if( ! xoops_template_touch( $tplid ) ) {
						$ret[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span>';
					} else {
						$ret[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> compiled.</span>';
					}
				}
			}
		}
		closedir( $handler ) ;
	}
	include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
	include_once XOOPS_ROOT_PATH.'/class/template.php' ;
	xoops_template_clear_module_cache( $mid ) ;

	return true ;
}

function xsns_message_append_onupdate( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['ret'] ) ) {
		foreach( $GLOBALS['ret'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}
}

}

?>
