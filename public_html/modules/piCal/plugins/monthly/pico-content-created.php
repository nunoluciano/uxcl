<?php

	// a plugin for pico

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

	// get config
	$module_handler =& xoops_gethandler('module');
	$pico_module =& $module_handler->getByDirname($plugin['dirname']);
	$config_handler =& xoops_gethandler('config');
	$pico_configs = $config_handler->getConfigList( $pico_module->mid() ) ;

	// var_dump( $pico_configs ) ;
	// $pico_configs['use_wraps_mode'] = true ;
	// $pico_configs['use_rewrite'] = false ;

	// options
	$options = explode( '|' , $plugin['options'] ) ;
	// options[0] : category extract
	if( ! empty( $options[0] ) ) {
		$cat_ids = array_map( 'intval' , explode( ',' , $options[0] ) ) ;
		$whr_cat = 'o.cat_id IN (' . implode( ',' , $cat_ids ) . ')' ;
	} else {
		$whr_cat = '1' ;
	}

	// categories can be read by current viewer (check by category_permissions)
	require_once XOOPS_TRUST_PATH.'/modules/pico/include/common_functions.php' ;
	$whr_read4content = 'o.`cat_id` IN (' . implode( "," , pico_get_categories_can_read( $plugin['dirname'] ) ) . ')' ;

	// query (added 86400 second margin "begin" & "end")
	$result = $db->query( "SELECT o.subject,o.content_id,o.created_time,o.vpath FROM ".$db->prefix($plugin['dirname']."_contents")." o WHERE o.visible AND ($whr_read4content) AND ($whr_cat) AND o.created_time >= $range_start_s AND o.created_time < $range_end_s" ) ;

	while( $content_row = $db->fetchArray( $result ) ) {
		$id = $content_row['content_id'] ;
		$title = $content_row['subject'] ;
		$server_time = $content_row['created_time'] ;
		$user_time = $server_time + $tzoffset_s2u ;
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$target_date = date('j',$user_time) ;
		$tmp_array = array(
			'dotgif' => $plugin['dotgif'] ,
			'dirname' => $plugin['dirname'] ,
			'link' => XOOPS_URL.'/modules/'.$plugin['dirname'].'/'.pico_make_content_link4html( $pico_configs , $content_row ) ,
			'id' => $id ,
			'server_time' => $server_time ,
			'user_time' => $user_time ,
			'name' => 'content_id' ,
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