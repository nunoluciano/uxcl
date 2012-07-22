<?php

	// a plugin for piCal (Don't refer this plugin!)

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
		$plugin = array('dirname'=>'dirname','name'=>'name','dotgif'=>'*.gif')
		$just1gif : 0 or 1
		
		$plugin_returns[ DATE ][]
	*/

	// for Duplicatable
	if( ! preg_match( '/^(\D+)(\d*)$/' , $plugin['dirname'] , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $plugin['dirname'] ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	if( $this->base_url == XOOPS_URL."/modules/".$plugin['dirname'] ) {
		$cal =& $this ;
	} else {
		// create a targeting instance of piCal 
		$cal = new piCal_xoops( "" , $this->language , true ) ;
	
		// this should not be affected by $_GET['cid']
		$cal->now_cid = '' ;

		// setting properties of piCal
		global $xoopsDB ;
		$cal->conn = $xoopsDB->conn ;
		include XOOPS_ROOT_PATH."/modules/{$plugin['dirname']}/include/read_configs.php" ;
		$cal->base_url = XOOPS_URL."/modules/".$plugin['dirname'] ;
		$cal->base_path = XOOPS_ROOT_PATH."/modules/".$plugin['dirname'] ;
		$cal->images_url = "$cal->base_url/images/$skin_folder" ;
		$cal->images_path = "$cal->base_path/images/$skin_folder" ;
	}

	// options
	$options = explode( '|' , $plugin['options'] ) ;
	// options[0] : category extract
	if( ! empty( $options[0] ) ) {
		$cids = explode( ',' , $options[0] ) ;
		$whr_cid_limit = '0' ;
		foreach( $cids as $cid ) {
			$whr_cid_limit .= " OR categories LIKE '%".sprintf("%05d,",intval($cid))."%'" ;
		}
	} else {
		$whr_cid_limit = '1' ;
	}

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $cal->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $cal->get_where_about_class() ;

	// 範囲の取得
	$range_start_s = mktime(0,0,0,$this->month,0,$this->year) ;
	$range_end_s = mktime(0,0,0,$this->month+1,1,$this->year) ;

	// 全日イベント以外の処理
	$result = mysql_query( "SELECT summary,id,start FROM $cal->table WHERE admission > 0 AND start >= $range_start_s AND start < $range_end_s AND ($whr_categories) AND ($whr_class) AND ($whr_cid_limit) AND allday <= 0" , $this->conn ) ;

	while( list( $title , $id , $server_time ) = $db->fetchRow( $result ) ) {
		$user_time = $server_time + $tzoffset_s2u ;
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$target_date = date('j',$user_time) ;
		$tmp_array = array(
			'dotgif' => $plugin['dotgif'] ,
			'dirname' => $plugin['dirname'] ,
			'link' => XOOPS_URL."/modules/{$plugin['dirname']}/index.php?smode=Daily&amp;caldate={$this->year}-{$this->month}-{$target_date}" ,
			'id' => $id ,
			'server_time' => $server_time ,
			'user_time' => $user_time ,
			'name' => 'id' ,
			'title' => $this->text_sanitizer_for_show( $title )
		) ;
		if( $just1gif ) {
			// just 1 gif per a plugin & per a day
			$plugin_returns[ $target_date ][ $plugin['dirname'] ] = $tmp_array ;
		} else {
			// multiple gifs allowed per a plugin & per a day
			$plugin_returns[ $target_date ][] = $tmp_array ;
		}
	}

	// 全日イベント専用の処理
	$result = mysql_query( "SELECT summary,id,start,end FROM $cal->table WHERE admission > 0 AND start >= $range_start_s AND start < $range_end_s AND ($whr_categories) AND ($whr_class) AND ($whr_cid_limit) AND allday > 0" , $this->conn ) ;

	while( list( $title , $id , $start_s , $end_s ) = $db->fetchRow( $result ) ) {
		if( $start_s < $range_start_s ) $start_s = $range_start_s ;
		if( $end_s > $range_end_s ) $end_s = $range_end_s ;

		while( $start_s < $end_s ) {
			$user_time = $start_s + $tzoffset_s2u ;
			if( date( 'n' , $user_time ) == $this->month ) {
				$target_date = date('j',$user_time) ;
				$tmp_array = array(
					'dotgif' => $plugin['dotgif'] ,
					'dirname' => $plugin['dirname'] ,
					'link' => XOOPS_URL."/modules/{$plugin['dirname']}/index.php?smode=Daily&amp;caldate={$this->year}-{$this->month}-{$target_date}" ,
					'id' => $id ,
					'server_time' => $server_time ,
					'user_time' => $user_time ,
					'name' => 'id' ,
					'title' => $this->text_sanitizer_for_show( $title )
				) ;
				if( $just1gif ) {
					// just 1 gif per a plugin & per a day
					$plugin_returns[ $target_date ][ $plugin['dirname'] ] = $tmp_array ;
				} else {
					// multiple gifs allowed per a plugin & per a day
					$plugin_returns[ $target_date ][] = $tmp_array ;
				}
			}
			$start_s += 86400 ;
		}
	}


?>