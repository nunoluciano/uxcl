<?php

eval('function xoops_module_uninstall_'.$mydirname.'($module){return xsns_onuninstall($module, "'.$mydirname.'");}');

if( !function_exists('xsns_onuninstall') ) {

function xsns_onuninstall($module, $mydirname)
{
	global $ret;
	if( !is_array($ret) ) $ret = array();
	
	if(defined('XOOPS_CUBE_LEGACY')){
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUninstall.' . ucfirst($mydirname) . '.Success' , 'xsns_message_append_onuninstall' ) ;
	}
	else{
		// Restore userinfo.php, edituser.php
		$userinfo_file = XOOPS_ROOT_PATH.'/userinfo.php';
		$edituser_file = XOOPS_ROOT_PATH.'/edituser.php';
		$userinfo_file_b = dirname(__FILE__).'/x20/bak_userinfo.php';
		$edituser_file_b = dirname(__FILE__).'/x20/bak_edituser.php';
		
		if(file_exists($userinfo_file_b) && file_exists($edituser_file_b)){
			@copy($userinfo_file_b, $userinfo_file);
			@copy($edituser_file_b, $edituser_file);
		}
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
		$ret[] = "SQL file found at <b>".htmlspecialchars($sql_file_path)."</b>.<br /> Deleting tables...<br />";
		$sql_lines = file( $sql_file_path ) ;
		foreach( $sql_lines as $sql_line ) {
			if( preg_match( '/^CREATE TABLE \`?([a-zA-Z0-9_-]+)\`?/i' , $sql_line , $regs ) ) {
				$sql = 'DROP TABLE '.$prefix_mod.'_'.$regs[1] ;
				if (!$db->query($sql)) {
					$ret[] = '<span style="color:#ff0000;">ERROR: Could not drop table <b>'.htmlspecialchars($prefix_mod.'_'.$regs[1]).'<b>.</span><br />';
				} else {
					$ret[] = 'Table <b>'.htmlspecialchars($prefix_mod.'_'.$regs[1]).'</b> dropped.<br />';
				}
			}
		}
	}
	return true;
}


function xsns_message_append_onuninstall( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['ret'] ) ) {
		foreach( $GLOBALS['ret'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}
}

}
?>
