<?php

	// a plugin for d3pipes

	if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

	/*
		$db : db instance
		$myts : MyTextSanitizer instance
		$this->year : year
		$this->month : month
		$this->date : date
		$this->week_start : sunday:0 monday:1
		$this->user_TZ : user's timezone (+1.5 etc)
		$this->server_TZ : server's timezone (-2.5 etc)
		$tzoffset_s2u : the offset from server to user
		$now : the result of time()
		$plugin = array('dirname'=>'dirname','name'=>'name','dotgif'=>'*.gif','options'=>'options')
		
		$plugin_returns[ DATE ][]
	*/

	// set range (added 86400 second margin "begin" & "end")
	$wtop_date = $this->date - ( $this->day - $this->week_start + 7 ) % 7 ;
	$range_start_s = mktime(0,0,0,$this->month,$wtop_date-1,$this->year) ;
	$range_end_s = mktime(0,0,0,$this->month,$wtop_date+8,$this->year) ;

	$unique_id = uniqid( rand() ) ; // just dummy
	// options
	$options = explode( '|' , $plugin['options'] ) ;
	// options[0] : category extract
	$pipe_ids = empty( $options[0] ) ? array(1) : array_map( 'intval' , explode( ',' , preg_replace( '/[^0-9,:]/' , '' ,  $options[0] ) ) ) ;
	$max_entries =  100 ;
	$union_class = 'mergesort' ;
	$link2clipping = false ;
	$keep_pipeinfo = false ;

	require_once XOOPS_TRUST_PATH.'/modules/d3pipes/include/common_functions.php' ;
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname($plugin['dirname']);
	$config_handler =& xoops_gethandler('config');
	$configs = $config_handler->getConfigList( $module->mid() ) ;
	
	$union_obj =& d3pipes_common_get_joint_object( $plugin['dirname'] , 'union' , $union_class , sizeof( $pipe_ids ) == 1 ? $pipe_ids[0].':'.$max_entries : implode( ',' , $pipe_ids ) . '||' . ($keep_pipeinfo?1:0) ) ;
	$union_obj->setModConfigs( $configs ) ;
	$entries = $union_obj->execute( array() , $max_entries ) ;
	$pipes_entries = method_exists( $union_obj , 'getPipesEntries' ) ? $union_obj->getPipesEntries() : array() ;
	$errors = $union_obj->getErrors() ;

	foreach( $entries as $entry ) {

		if ( $entry['clipping_id'] ) {
			$link = XOOPS_URL."/modules/{$plugin['dirname']}/index.php?page=clipping&amp;clipping_id={$entry['clipping_id']}";
			$id = (int)$entry['clipping_id'] ;
		} else {
			$link = $entry['link'] ;
			$id = (int)$entry['id'] ;
		}

		$user_time = $entry['pubtime'] + $tzoffset_s2u ;
		if( $range_start_s <= $user_time && $user_time < $range_end_s ) {
			$target_date = date('j',$user_time) ;
			$tmp_array = array(
				'dotgif' => $plugin['dotgif'] ,
				'dirname' => $plugin['dirname'] ,
				'link' => $myts->makeTboxData4Show( $link ) ,
				'id' => $id ,
				'server_time' => $server_time ,
				'user_time' => $user_time ,
				'name' => 'post_id' ,
				'title' => $myts->makeTboxData4Show( $entry['headline'] ) ,
				'description' => empty( $entry['description'] ) ? '' : $myts->makeTboxData4Show( $entry['description'] ) ,
			) ;

			// multiple gifs allowed per a plugin & per a day
			$plugin_returns[ $target_date ][] = $tmp_array ;
		}
	}


?>