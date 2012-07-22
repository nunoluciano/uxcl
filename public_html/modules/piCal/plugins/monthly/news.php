<?php

	// a plugin for news 1.1

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
	$result = $db->query( "SELECT title,storyid,published FROM ".$db->prefix("stories")." WHERE ($whr_topic) AND published < UNIX_TIMESTAMP() AND published >= $range_start_s AND published < $range_end_s AND (expired = 0 OR expired > '$now')" ) ;

	while( list( $title , $id , $server_time ) = $db->fetchRow( $result ) ) {
		$user_time = $server_time + $tzoffset_s2u ;
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$target_date = date('j',$user_time) ;
		$tmp_array = array(
			'dotgif' => $plugin['dotgif'] ,
			'dirname' => $plugin['dirname'] ,
			'link' => XOOPS_URL."/modules/{$plugin['dirname']}/article.php?storyid=$id" , // &amp;caldate={$this->year}-{$this->month}-$target_date" ,
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