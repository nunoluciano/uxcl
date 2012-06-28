<?php

eval( ' function xoops_module_update_'.$mydirname.'( $module ) { return dbcss_onupdate_base( $module , "'.$mydirname.'" ) ; } ' ) ;


if( ! function_exists( 'dbcss_onupdate_base' ) ) {

function dbcss_onupdate_base( $module , $mydirname )
{
	// transations on module update

	global $msgs ; // TODO :-D

	// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Success', 'dbcss_message_append_onupdate' ) ;
		$msgs = array() ;
	} else {
		if( ! is_array( $msgs ) ) $msgs = array() ;
	}

	$db =& Database::getInstance() ;
	$mid = $module->getVar('mid') ;

	// TABLES (write here ALTER TABLE etc. if necessary)

	// 0.6 -> 0.7
	$check_sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_metalink") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "CREATE TABLE ".$db->prefix($mydirname."_metalink")." (lid int(10) NOT NULL default '0', metakey text NOT NULL, metadesc text NOT NULL, robots varchar(100) NOT NULL default '', rating varchar(100) NOT NULL default '', author varchar(255) NOT NULL default '', UNIQUE KEY lid (lid)) TYPE=MyISAM" ) ;
	}

	// 0.8 -> 0.9
	$check_sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_scriptbody") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "CREATE TABLE ".$db->prefix($mydirname."_scriptbody")." (lid mediumint(5) unsigned NOT NULL auto_increment, title varchar(255) NOT NULL default '', created int(10) NOT NULL default '0', body text NOT NULL, css text NOT NULL, UNIQUE KEY lid (lid)) TYPE=MyISAM;" ) ;
	}

	// 0.9 -> 1.0
	$check_sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_cssexport") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "CREATE TABLE ".$db->prefix($mydirname."_cssexport")." (lid int(10) NOT NULL default '0', exportdir varchar(255) NOT NULL default '', UNIQUE KEY lid (lid)
) TYPE=MyISAM;" ) ;
	}

	// configs (Though I know it is not a recommended way...)
	$check_sql = "SHOW COLUMNS FROM ".$db->prefix("config")." LIKE 'conf_title'" ;
	if( ( $result = $db->query( $check_sql ) ) && ( $myrow = $db->fetchArray( $result ) ) && @$myrow['Type'] == 'varchar(30)' ) {
		$db->queryF( "ALTER TABLE ".$db->prefix("config")." MODIFY `conf_title` varchar(255) NOT NULL default '', MODIFY `conf_desc` varchar(255) NOT NULL default ''" ) ;
	}

	// configs (Though I know it is not a recommended way...)
	$check_sql = "SHOW COLUMNS FROM ".$db->prefix("config")." LIKE 'conf_title'" ;
	if( ( $result = $db->query( $check_sql ) ) && ( $myrow = $db->fetchArray( $result ) ) && @$myrow['Type'] == 'varchar(30)' ) {
		$db->queryF( "ALTER TABLE ".$db->prefix("config")." MODIFY `conf_title` varchar(255) NOT NULL default '', MODIFY `conf_desc` varchar(255) NOT NULL default ''" ) ;
	}

	// TEMPLATES (all templates have been already removed by modulesadmin)
	include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
	include_once XOOPS_ROOT_PATH.'/class/template.php' ;

	$tplfile_handler =& xoops_gethandler( 'tplfile' ) ;
	$tpl_path = dirname(__FILE__).'/templates' ;

	if( $handler = @opendir( $tpl_path . '/' ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 1 ) == '.' ) continue ;
			$file_path = $tpl_path . '/' . $file ;
			if( is_file( $file_path ) ) {
				$mtime = intval( @filemtime( $file_path ) ) ;
				$tplfile =& $tplfile_handler->create() ;
				$tplfile->setVar( 'tpl_source' , file_get_contents( $file_path ) , true ) ;
				$tplfile->setVar( 'tpl_refid' , $mid ) ;
				$tplfile->setVar( 'tpl_tplset' , 'default' ) ;
				$tplfile->setVar( 'tpl_file' , $mydirname . '_' . $file ) ;
				$tplfile->setVar( 'tpl_desc' , '' , true ) ;
				$tplfile->setVar( 'tpl_module' , $mydirname ) ;
				$tplfile->setVar( 'tpl_lastmodified' , $mtime ) ;
				$tplfile->setVar( 'tpl_lastimported' , 0 ) ;
				$tplfile->setVar( 'tpl_type' , 'module' ) ;
				if( ! $tplfile_handler->insert( $tplfile ) ) {
					$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
				} else {
					$tplid = $tplfile->getVar( 'tpl_id' ) ;
					$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tplid.'</b>)';
					// generate compiled file
					if( ! xoops_template_touch( $tplid ) ) {
						$msgs[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span>';
					} else {
						$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> compiled.</span>';
					}
				}
			}
		}
		closedir( $handler ) ;
	}

	/*************** BEGIN DBCSS SPECIFIC PART ******************/
	// CSS TEMPLATES
	if( file_exists( XOOPS_TRUST_PATH.'/uploads/'.$mydirname ) ) {
		$CSS_path = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;

		if( $handler = @opendir( $CSS_path . '/' ) ) {
			while( ( $file = readdir( $handler ) ) !== false ) {
				if( substr( $file , 0 , 1 ) == '.' ) continue ;
				$file_path = $CSS_path . '/' . $file ;
				if ( is_file( $file_path ) && substr( $file , -4 ) == '.css'){
					$mtime = intval( @filemtime( $file_path ) ) ;
					$tplfile =& $tplfile_handler->create() ;
					$tplfile->setVar( 'tpl_source' , file_get_contents( $file_path ) , true ) ;
					$tplfile->setVar( 'tpl_refid' , $mid ) ;
					$tplfile->setVar( 'tpl_tplset' , 'default' ) ;
					$tplfile->setVar( 'tpl_file' , $mydirname . '_' . $file ) ;
					$tplfile->setVar( 'tpl_desc' , '' , true ) ;
					$tplfile->setVar( 'tpl_module' , $mydirname ) ;
					$tplfile->setVar( 'tpl_lastmodified' , $mtime ) ;
					$tplfile->setVar( 'tpl_lastimported' , 0 ) ;
					$tplfile->setVar( 'tpl_type' , 'module' ) ;
					if( ! $tplfile_handler->insert( $tplfile ) ) {
						$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
					} else {
						$tplid = $tplfile->getVar( 'tpl_id' ) ;
						$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tplid.'</b>)';
						// generate compiled file
						if( ! xoops_template_touch( $tplid ) ) {
							$msgs[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span>';
						} else {
							$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> compiled.</span>';
						}
					}
				}
			}
		}
		closedir( $handler ) ;
	}
	xoops_template_clear_module_cache( $mid ) ;
	/*************** END DBCSS SPECIFIC PART ******************/

	return true ;
}

function dbcss_message_append_onupdate( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['msgs'] ) ) {
		foreach( $GLOBALS['msgs'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

}

?>