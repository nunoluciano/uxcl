<?php

eval( ' function xoops_module_update_'.$mydirname.'( $module, $prev_version) { return bulletin_onupdate_base( $module, $prev_version , "'.$mydirname.'" ) ; } ' ) ;


function bulletin_onupdate_base( $module, $prev_version , $mydirname )
{
	global $msgs, $xoopsDB, $xoopsUser, $xoopsConfig ;

	// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$isCube = true ;
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Success', 'bulletin_message_append_onupdate' ) ;
		$msgs = array() ;
	} else {
		$isCube = false ;
		if( ! is_array( $msgs ) ) $msgs = array() ;
	}

	$db =& Database::getInstance() ;
	$mid = $module->getVar('mid') ;


	// transations on module update
	// TABLES (write here ALTER TABLE etc. if necessary)
	if( $prev_version < 200 ){

		$msgs[] = 'Executing compatible programs... (ver '. $prev_version / 100 .' to 2.x)';

		$sql = sprintf("SHOW TABLES LIKE '%s'", $xoopsDB->prefix("{$mydirname}_relation") );
		list($result) = $xoopsDB->fetchRow($xoopsDB->query($sql));
		if( empty($result) ){
			$sql = "CREATE TABLE `".$xoopsDB->prefix("{$mydirname}_relation")."` (  `storyid` int(8) NOT NULL default '0',  `linkedid` int(8) NOT NULL default '0',  `dirname` varchar(25) NOT NULL default '') ENGINE=MyISAM;";
			if( $xoopsDB->query($sql) ){
				$msgs[] = '&nbsp;&nbsp;Table <b>'.htmlspecialchars($xoopsDB->prefix("{$mydirname}_relation")).'</b> created.';
			}else{
				$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
			}
		}else{
			$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Table <b>'.htmlspecialchars($result).'</b> already exsits.</span>';
		}

		$sql = sprintf("SHOW COLUMNS FROM %s LIKE 'block'", $xoopsDB->prefix("{$mydirname}_stories") );
		list($result) = $xoopsDB->fetchRow($xoopsDB->query($sql));
		if( empty($result) ){
			$sql = sprintf("ALTER TABLE %s ADD `block` TINYINT( 1 ) DEFAULT '1'", $xoopsDB->prefix("{$mydirname}_stories") );
			if( $xoopsDB->query($sql) ){
				$msgs[] = '&nbsp;&nbsp;Column <b>block</b> added.';
			}else{
				$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
			}
		}else{
			$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Column <b>block</b> already exsits.</span>';
		}

		// This is Duplication V2 compatibility...
		if( preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ){
			$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

			$sql = sprintf("SHOW TABLES LIKE '%s%%'", str_replace('_','\_',$xoopsDB->prefix("bulletin{$mydirnumber}_")) );
			$result = $xoopsDB->query($sql);
			while(list($table) = $xoopsDB->fetchRow($result)){
				$sql = "SELECT * FROM ".$xoopsDB->prefix('modules')." WHERE dirname = 'bulletin{$mydirnumber}'";

				list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
				if($count == 0){
					$renamed = preg_replace('/^' .$xoopsDB->prefix("bulletin{$mydirnumber}"). '/i', $xoopsDB->prefix($mydirname), $table);
					$sql = "ALTER TABLE `".addslashes($table)."` RENAME `".addslashes($renamed)."` ";
					if( $xoopsDB->query($sql) ){
						$msgs[] = '&nbsp;&nbsp;Table <b>'.htmlspecialchars($table).'</b> is renamed into <b>'.htmlspecialchars($renamed).'</b>.';
					}else{
						$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Failed to rename table <b>'.htmlspecialchars($table).'</b></span>';
					}
				}
			}
		}
	}
	// update table structure from 2.04
	$check_rs = $db->query( "SELECT topic_created FROM ".$db->prefix($mydirname.'_topics') ) ;
	if( empty( $check_rs ) ) {
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname.'_topics')." ADD `topic_created` int(10) unsigned NOT NULL default 0, ADD `topic_modified` int(10) unsigned NOT NULL default 0, MODIFY `topic_imgurl` varchar(255) NOT NULL default '', MODIFY `topic_title` varchar(255) NOT NULL default ''" ) ;
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname.'_stories')." MODIFY `uid` mediumint(8) unsigned NOT NULL default 0" ) ;
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname.'_relation')." ADD KEY (`storyid`), ADD PRIMARY KEY (`storyid`,`linkedid`,`dirname`)" ) ;
	}
//ver2.22->ver3.0
	$sql = sprintf("SHOW TABLES LIKE '%s'", $db->prefix("{$mydirname}_topic_access") );
	list($result) = $db->fetchRow($db->query($sql));
	if( empty($result) ){
		$sql ="CREATE TABLE ".$db->prefix("{$mydirname}_topic_access")." (
		topic_id smallint(5) unsigned NOT NULL default 0,
		uid mediumint(8) default NULL,
		groupid smallint(5) default NULL,
		can_post tinyint(1) NOT NULL default 0,
		can_edit tinyint(1) NOT NULL default 0,
		can_delete tinyint(1) NOT NULL default 0,
		post_auto_approved tinyint(1) NOT NULL default 0,
		UNIQUE KEY (topic_id,uid),
		UNIQUE KEY (topic_id,groupid),
		KEY (topic_id),
		KEY (uid),
		KEY (groupid),
		KEY (can_post)
		) ENGINE=MyISAM;
		";
		if( $db->query($sql) ){
			$msgs[] = '&nbsp;&nbsp;Table <b>'.htmlspecialchars($db->prefix("{$mydirname}_topic_access")).'</b> created.';
		}else{
			$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
		}
//ver2.22->ver3.0  creat data to topic_access
		$can_groups = array();
		$can_read_topic_id = array();
		$topic_access_data = "";
		$sql = "SELECT gperm_groupid FROM ".$db->prefix('group_permission');
		$sql .= " WHERE gperm_itemid = ".$mid;
		$sql .= " AND gperm_modid = 1";
		$sql .= " AND gperm_name = 'module_read'";
		$result = $db->query($sql);
		if (empty($result)){
			$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
		}else{
			while ($myrow = $db->fetchArray($result)) {
				$can_groups[$myrow['gperm_groupid']]['can_read'] = 1;
				$can_groups[$myrow['gperm_groupid']]['can_post'] = 0;
				$can_groups[$myrow['gperm_groupid']]['can_edit'] = 0;
				$can_groups[$myrow['gperm_groupid']]['can_delete'] = 0;
				$can_groups[$myrow['gperm_groupid']]['post_auto_approved'] = 0;
			}
			if (!empty($can_groups)){
				//ca_post,post_auto_approved
				$sql = "SELECT * FROM ".$db->prefix('group_permission');
				$sql .= " WHERE gperm_modid = ".$mid;
				$sql .= " AND gperm_name = 'bulletin_permit'";
				$result = $db->query($sql);
				if (empty($result)){
					$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
				}else{
					while ($myrow = $db->fetchArray($result)) {
						if(isset($can_groups[$myrow['gperm_groupid']])){
							switch ($myrow['gperm_itemid']) {
							case 1:
								$can_groups[$myrow['gperm_groupid']]['can_post'] = 1;
								break;
							case 2:
								$can_groups[$myrow['gperm_groupid']]['post_auto_approved'] = 1;
								break;
							}
						}
					}
					$sql = "SELECT gperm_groupid FROM ".$db->prefix('group_permission');
					$sql .= " WHERE gperm_itemid = ".$mid;
					$sql .= " AND gperm_modid = 1";
					$sql .= " AND gperm_name = 'module_admin'";
					$result = $db->query($sql);
					if (empty($result)){
						$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
					}else{
						while ($myrow = $db->fetchArray($result)) {
							if(isset($can_groups[$myrow['gperm_groupid']])){
								$can_groups[$myrow['gperm_groupid']]['can_post'] = 1;
								$can_groups[$myrow['gperm_groupid']]['can_edit'] = 1;
								$can_groups[$myrow['gperm_groupid']]['can_delete'] = 1;
								$can_groups[$myrow['gperm_groupid']]['post_auto_approved'] = 1;
							}
						}
						$sql = "SELECT topic_id FROM ".$db->prefix("{$mydirname}_topics");
						$result = $db->query($sql);
						if (empty($result)){
							$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
						}else{
							while ($myrow = $db->fetchArray($result)) {
								$can_read_topic_id[] = $myrow['topic_id'];
							}
							if (!empty($can_read_topic_id)){
								foreach ($can_read_topic_id as $topic_id) {
									foreach ($can_groups as $groupid => $value) {
										$sql = "INSERT INTO `".$db->prefix("{$mydirname}_topic_access")."`";
										$sql .= " (`topic_id`, `uid`, `groupid`, `can_post`, `can_edit`, `can_delete`, `post_auto_approved`)";
										$sql .= " VALUES (".$topic_id.", NULL, ".$groupid.", ".$value['can_post'].", ".$value['can_edit'].", ".$value['can_delete'].", ".$value['post_auto_approved'].")";
										if ($db->query($sql)){
											$msgs[] = '&nbsp;&nbsp;Table <b>'.htmlspecialchars($db->prefix("{$mydirname}_topic_access")).'</b> add '.$topic_id.' for group '.$groupid ;
										}else{
											$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">Invalid SQL <b>'.htmlspecialchars($sql).'</b></span>';
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	// TEMPLATES (all templates have been already removed by modulesadmin)
	$tplfile_handler =& xoops_gethandler( 'tplfile' ) ;
	$tpl_path = dirname(__FILE__).'/templates' ;
	if( $handler = @opendir( $tpl_path . '/' ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 1 ) == '.' ) continue ;
			$file_path = $tpl_path . '/' . $file ;
			if( is_file( $file_path ) && substr( $file , -5 ) == '.html' ) {
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
					include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
					include_once XOOPS_ROOT_PATH.'/class/template.php';
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
	include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
	include_once XOOPS_ROOT_PATH.'/class/template.php' ;
	xoops_template_clear_module_cache( $mid ) ;

	// BLOCKS
	$tpl_path = dirname(__FILE__).'/templates/blocks' ;
	if( $handler = @opendir( $tpl_path . '/' ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 1 ) == '.' ) continue ;
			$file_path = $tpl_path . '/' . $file ;
			if( is_file( $file_path ) && substr( $file , -5 ) == '.html' ) {
				$mtime = intval( @filemtime( $file_path ) ) ;
				$tpl_file = $mydirname . '_' . $file;
				$tpl_source = file_get_contents( $file_path );
				$sql = "SELECT tpl_id, tpl_refid FROM ".$db->prefix('tplfile')." WHERE tpl_module='$mydirname' AND tpl_file='".mysql_escape_string($tpl_file)."'";
				list($tpl_id, $block_id) = $db->fetchRow($db->query($sql));
				if( empty($tpl_id) && empty($block_id)){
					$blocks_info = $module->getInfo('blocks');
					$show_func = '';
					foreach($blocks_info as $oneblock){
						if($tpl_file == $oneblock['template']){
							$show_func = $oneblock['show_func'];
							break;
						}
					}
					if( $show_func != ''){
						$sql = sprintf("SELECT bid FROM %s WHERE dirname=%s AND show_func=%s", $db->prefix("newblocks"), $db->quoteString($mydirname), $db->quoteString($show_func) ) ;
						list($block_id) = $xoopsDB->fetchRow($xoopsDB->query($sql));
						if($block_id){
							$tplfile =& $tplfile_handler->create();
							$tplfile->setVar('tpl_module', $mydirname);
							$tplfile->setVar('tpl_refid', $block_id);
							$tplfile->setVar('tpl_source', $tpl_source, true);
							$tplfile->setVar('tpl_tplset', 'default');
							$tplfile->setVar('tpl_file', $tpl_file, true);
							$tplfile->setVar('tpl_type', 'block');
							$tplfile->setVar('tpl_lastimported', 0);
							$tplfile->setVar('tpl_lastmodified', time());
							$tplfile->setVar('tpl_desc', '', true);
							if (!$tplfile_handler->insert($tplfile)) {
								$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not insert template <b>'.$tpl_file.'</b> to the database.</span>';
							} else {
								$newid = $tplfile->getVar('tpl_id');
								$msgs[] = '&nbsp;&nbsp;Template <b>'.$tpl_file.'</b> added to the database.';
								if ($xoopsConfig['template_set'] == 'default') {
									if (!xoops_template_touch($block_id)) {
										$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Template <b>'.$tpl_file.'</b> recompile failed.</span>';
									} else {
										$msgs[] = '&nbsp;&nbsp;Template <b>'.$tpl_file.'</b> recompiled.';
									}
								}
							}
							$sql = "UPDATE ".$db->prefix("newblocks")." SET template='".mysql_escape_string($tpl_file)."', last_modified=".time()." WHERE bid=".$block_id;
							if( !$result = $db->query($sql) ) {
								$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
							}else{
								$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$newid.'</b>)';
							}
						}
					}
				}
				elseif (!empty($tpl_id) && isset($tpl_source) && $tpl_source != '') {
					$sql = "SELECT COUNT(*) FROM ".$db->prefix('tplsource')." WHERE tpl_id='$tpl_id'";
					list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
					if($count==0){
						$sql = sprintf("INSERT INTO %s (tpl_id, tpl_source) VALUES (%u, %s)", $db->prefix('tplsource'), $tpl_id, $db->quoteString($tpl_source));
					}else{
						$sql = "UPDATE ".$db->prefix("tplsource")." SET tpl_source='".mysql_escape_string($tpl_source)."' WHERE tpl_id=".$tpl_id;
					}
					if( !$result = $db->query($sql) ) {
						$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
					} else {
						$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tpl_id.'</b>)';
						// generate compiled file
						include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
						include_once XOOPS_ROOT_PATH.'/class/template.php';
						if( ! xoops_template_touch( $tpl_id ) ) {
							$msgs[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span>';
						} else {
							$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> compiled.</span>';
						}
					}
					$sql = "UPDATE ".$db->prefix("newblocks")." SET template='".mysql_escape_string($tpl_file)."', last_modified=".time()." WHERE bid=".$block_id;
					if( !$result = $db->query($sql) ) {
						$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
					}else{
						$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tpl_id.'</b>)';
					}
				}
			}
		}
		closedir( $handler ) ;
	}

	return true ;
}

function bulletin_message_append_onupdate( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['msgs'] ) ) {
		foreach( $GLOBALS['msgs'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}
}

?>