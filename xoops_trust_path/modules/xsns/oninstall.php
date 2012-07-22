<?php

eval('function xoops_module_install_'.$mydirname.'($module){return xsns_oninstall($module, "'.$mydirname.'");}');

if( !function_exists('xsns_oninstall') ) {

function xsns_oninstall($module, $mydirname)
{
	global $ret;
	
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleInstall.' . ucfirst($mydirname) . '.Success' , 'xsns_message_append_oninstall' ) ;
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleInstall.' . ucfirst($mydirname) . '.Fail' , 'xsns_message_append_oninstall' ) ;
		$ret = array() ;
	}
	else{
		if( !is_array($ret) ){
			$ret = array() ;
		}
	}
	
	$constpref = '_MI_'.strtoupper($mydirname);
	if(strlen($mydirname) > 15){
		$ret[] = constant($constpref.'_INSTERR').'<br />';
	}
	
	$db =& Database::getInstance() ;
	$mid = $module->getVar('mid') ;
	
	// Tables
	$sql_ver = floatval(substr(mysql_get_server_info(), 0, 3));
	if($sql_ver < 4){
		$sql_file = 'mysql3.sql';
	}
	elseif($sql_ver == 4.0){
		$sql_file = 'mysql40.sql';
	}
	else{
		$sql_file = 'mysql.sql';
	}
	$sql_file_path = realpath(dirname(__FILE__).'/sql/'.$sql_file);
	$prefix_mod = $db->prefix() . '_' . $mydirname ;
	if( file_exists( $sql_file_path ) ) {
		$ret[] = "SQL file found at <b>".htmlspecialchars($sql_file_path)."</b>.<br /> Creating tables...";
		
		if( file_exists( XOOPS_ROOT_PATH.'/class/database/oldsqlutility.php' ) ) {
			include_once XOOPS_ROOT_PATH.'/class/database/oldsqlutility.php' ;
			$sqlutil = new OldSqlUtility ;
		} else {
			include_once XOOPS_ROOT_PATH.'/class/database/sqlutility.php' ;
			$sqlutil = new SqlUtility ;
		}

		$sql_query = trim( file_get_contents( $sql_file_path ) ) ;
		$sqlutil->splitMySqlFile( $pieces , $sql_query ) ;
		$created_tables = array() ;
		if( is_array( $pieces ) ) {
			foreach( $pieces as $piece ) {
				$prefixed_query = $sqlutil->prefixQuery( $piece , $prefix_mod ) ;
				if( ! $prefixed_query ) {
					$ret[] = "Invalid SQL <b>".htmlspecialchars($piece)."</b><br />";
					return false ;
				}
				if( ! $db->query( $prefixed_query[0] ) ) {
					$ret[] = '<b>'.htmlspecialchars( $db->error() ).'</b><br />' ;
					return false ;
				}
				else {
					if( ! in_array( $prefixed_query[4] , $created_tables ) ) {
						$ret[] = 'Table <b>'.htmlspecialchars($prefix_mod.'_'.$prefixed_query[4]).'</b> created.<br />';						$created_tables[] = $prefixed_query[4];
					}
					else {
						$ret[] = 'Data inserted to table <b>'.htmlspecialchars($prefix_mod.'_'.$prefixed_query[4]).'</b>.</br />';
					}
				}
			}
		}
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
				$tplfile->setVar( 'tpl_file' , $mydirname . '_' . $file ) ;
				$tplfile->setVar( 'tpl_desc' , '' , true ) ;
				$tplfile->setVar( 'tpl_module' , $mydirname ) ;
				$tplfile->setVar( 'tpl_lastmodified' , $mtime ) ;
				$tplfile->setVar( 'tpl_lastimported' , 0 ) ;
				$tplfile->setVar( 'tpl_type' , 'module' ) ;
				if( ! $tplfile_handler->insert( $tplfile ) ) {
					$ret[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span><br />';
				} else {
					$tplid = $tplfile->getVar( 'tpl_id' ) ;
					$ret[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tplid.'</b>)<br />';
					// generate compiled file
					include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
					include_once XOOPS_ROOT_PATH.'/class/template.php' ;
					if( ! xoops_template_touch( $tplid ) ) {
						$ret[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span><br />';
					} else {
						$ret[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> compiled.</span><br />';
					}
				}
			}
		}
		closedir( $handler ) ;
	}
	include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
	include_once XOOPS_ROOT_PATH.'/class/template.php' ;
	xoops_template_clear_module_cache( $mid ) ;
	
	
	// Set default categories
	$ini_category_list = array(
		// 小カテゴリ名, 表示順, 中カテゴリID
		array(constant($constpref.'_CATEGORY_1'), 1, 1),
		array(constant($constpref.'_CATEGORY_2'), 2, 1),
		array(constant($constpref.'_CATEGORY_3'), 3, 1),
		array(constant($constpref.'_CATEGORY_4'), 50, 1),
	);
	
	$sql_values = array();
	$selector_arr = array();
	$id = 1;
	
	foreach($ini_category_list as $category){
		$values = array();
		foreach($category as $v){
			$values[] = "'".$v."'";
		}
		$sql_values[] = "(".implode(',', $values).")";
		$selector_arr[] = "<a href=\"".XOOPS_URL."/modules/".$mydirname."/?cat_id=".($id++)."\">".$category[0]."<nobr><small>(0)</small></nobr></a>";
	}
	
	if(count($sql_values) > 0 || count($selector_arr) > 0){
		$sql = "INSERT INTO ".$db->prefix($mydirname.'_c_commu_category').
				" (name,sort_order,c_commu_category_parent_id) VALUES ".
				implode(",", $sql_values);
		if($db->query($sql)){
			$sql = "INSERT INTO ".$db->prefix($mydirname.'_c_commu_category_parent').
					" (name,sort_order,selector) VALUES".
					" ('".constant($constpref.'_CATEGORY')."', '1', '".implode("&nbsp;- ", $selector_arr)."')";
			return $db->query($sql);
		}
		else{
			return false;
		}
	}
	return true;
}


function xsns_message_append_oninstall( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['ret'] ) ) {
		foreach( $GLOBALS['ret'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}
}

}

?>
