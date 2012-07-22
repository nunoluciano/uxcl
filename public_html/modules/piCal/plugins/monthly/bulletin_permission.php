<?php

	// a plugin for bulletin 2.0

	if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

	/*
		$db : db instance
		$myts : MyTextSanitizer instance
		$this->year : year
		$this->month : month
		$this->user_TZ : user's timezone (+1.5 etc)
		$this->server_TZ : server's timezone (-2.5 etc)
		$tzoffset_s2u : the offset from server to user
		$now : the result of time()
		$plugin = array('dirname'=>'dirname','name'=>'name','dotgif'=>'*.gif','options'=>'options')
		$just1gif : 0 or 1

		$plugin_returns[ DATE ][]
	*/

	// set range (added 86400 second margin "begin" & "end")
	$range_start_s = mktime(0,0,0,$this->month,0,$this->year) ;
	$range_end_s = mktime(0,0,0,$this->month+1,1,$this->year) ;

	// options
	$options = explode( '|' , $plugin['options'] ) ;
	// options[0] : category extract
	if( ! empty( $options[0] ) ) {
		$whr_topic = '`topicid` IN (' . addslashes( $options[0] ) . ')' ;
	} else {
		$whr_topic = '1' ;
	}
	// query (added 86400 second margin "begin" & "end")
//ver2.0
//	$result = $db->query( "SELECT title,storyid,published FROM ".$db->prefix($plugin['dirname']."_stories")." WHERE ($whr_topic) AND published < UNIX_TIMESTAMP() AND published >= $range_start_s AND published < $range_end_s AND type=1 AND (expired = 0 OR expired > '$now')" ) ;
//ver3.0 suport
	$sql = "SELECT title,storyid,published";
	$sql .= " FROM ".$db->prefix($plugin['dirname']."_stories");
	$sql .= " WHERE ($whr_topic) AND published < UNIX_TIMESTAMP() AND published >= $range_start_s AND published < $range_end_s AND (expired = 0 OR expired > '$now')";

	if ($GLOBALS['xoopsUser']) {
		$groups = $GLOBALS['xoopsUser']->getGroups();
	} else {
		$groups = XOOPS_GROUP_ANONYMOUS;
	}
	$module_handler =& xoops_gethandler('module');
	$module = $module_handler->getByDirname($plugin['dirname']);
	$mid = $module->mid();
	include_once XOOPS_TRUST_PATH.'/modules/bulletin/class/bulletingp.php';

	if ( file_exists(XOOPS_TRUST_PATH.'/modules/bulletin/admin/category_access.php') ) {
		//ver3.0 can_read access
		$gperm =& BulletinGP::getInstance($plugin['dirname']) ;
		$checkright = $gperm->checkRight('module_read', $mid, $groups);
		$can_read_topic_ids = $gperm->makeOnTopics('can_read');

		if (empty($can_read_topic_ids) || !$checkright){
			$sql .= ' AND topicid IN (0)';
		}else{
			$sql .= ' AND topicid IN ('.implode(',',$can_read_topic_ids).')';
		}
		if (!$gperm->group_perm(2)){
			$sql .= " AND type > 0";
		}
	}else{
		$gperm =new BulletinGP() ;
		$checkright = $gperm->checkRight('module_read', $mid, $groups);
		if ( !$checkright){
			$sql .= ' AND topicid IN (0)';
		}
		$sql .= " AND type > 0";
	}

	$result = $db->query( $sql ) ;

	while( list( $title , $id , $server_time ) = $db->fetchRow( $result ) ) {
		$user_time = $server_time + $tzoffset_s2u ;
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$target_date = date('j',$user_time) ;
		$tmp_array = array(
			'dotgif' => $plugin['dotgif'] ,
			'dirname' => $plugin['dirname'] ,
			'link' => XOOPS_URL."/modules/{$plugin['dirname']}/index.php?page=article&amp;storyid=$id" , // &amp;caldate={$this->year}-{$this->month}-$target_date" ,
			'id' => $id ,
			'server_time' => $server_time ,
			'user_time' => $user_time ,
			'name' => 'storyid' ,
			'title' => $myts->makeTboxData4Show( $title )
		) ;
		if( $just1gif ) {
			// just 1 gif per a plugin & per a day
			$plugin_returns[ $target_date ][ $plugin['dirname'] ] = $tmp_array ;
		} else {
			// multiple gifs allowed per a plugin & per a day
			$plugin_returns[ $target_date ][] = $tmp_array ;
		}
	}


?>