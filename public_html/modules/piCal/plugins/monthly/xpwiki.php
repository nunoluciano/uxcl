<?php

	// a plugin for xpwiki

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
	//$options = explode( '|' , $plugin['options'] ) ;

	require_once XOOPS_TRUST_PATH.'/modules/xpwiki/include.php' ;
	
	$xpwiki =& XpWiki::getSingleton($plugin['dirname']);
	$xpwiki->init('#RenderMode');
	
	// to GMT
	$range_start_s -= $xpwiki->cont['LOCALZONE'];
	$range_end_s -= $xpwiki->cont['LOCALZONE'];
	
	$where = $xpwiki->func->get_readable_where();
	
	$where_base = "editedtime >= $range_start_s AND editedtime < $range_end_s";
	if ($where) {
		$where = '(' . $where . ') AND '.$where_base;
	} else {
		$where = $where_base;
	}
	
	// query (added 86400 second margin "begin" & "end")
	$result = $db->query( 'SELECT name, editedtime, title FROM ' . $db->prefix($plugin['dirname'] . '_pginfo') . ' WHERE ' . $where ) ;
	
	while( list( $page, $server_time ) = $db->fetchRow( $result ) ) {
		$server_time += $xpwiki->cont['LOCALZONE'];
		$user_time = $server_time + $tzoffset_s2u ;
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$target_date = date('j',$user_time) ;
		$title = ($xpwiki->root->pagename_num2str) ? preg_replace('/\/(?:[0-9\-]+|[B0-9][A-Z0-9]{9})$/','/'.$xpwiki->func->get_heading($page),$page) : $page;
		$tmp_array = array(
			'dotgif' => $plugin['dotgif'] ,
			'dirname' => $plugin['dirname'] ,
			'link' => $xpwiki->func->get_page_uri($page, true) ,
			'id' =>  $xpwiki->func->get_pgid_by_name($page) ,
			'server_time' => $server_time ,
			'user_time' => $user_time ,
			'name' => 'pgid' ,
			'title' => $myts->makeTboxData4Show($title)
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