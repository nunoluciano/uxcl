<?php
	// DEC 20050908
	// a plugin for membership that extracts birthdays
	// based on mylinks plugin
	//print_r("HEY");
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
//print_r("HEY");
	// set range (added 86400 second margin "begin" & "end")
	//$range_start_s = date("Y-m-d", mktime(0,0,0,$this->month,0,$this->year) ) ;
	//$range_end_s = date("Y-m-d",mktime(0,0,0,$this->month+1,1,$this->year) );
	
	// setting absurd range allows all member's birthdays to show in every year
	$range_start_s = "1904-01-01";
	$range_end_s = "2030-01-01";
	//print_r($range_start_s . "<BR>");
	//print_r($range_end_s);
	// query (added 86400 second margin "begin" & "end")
	$result = $db->query( "SELECT lastname,uid,birth_date FROM ".$db->prefix("membership_info")." WHERE birth_date >= '$range_start_s' AND birth_date < '$range_end_s'" ) ;
	
	//$result = $db->query( "SELECT lastname,uid,birth_date FROM ".$db->prefix("membership_info")." WHERE birth_date >= $range_start_s AND birth_date < $range_end_s" ) ;
	//print_r(var_export($result,TRUE));
	while( list( $lastname , $id , $server_time ) = $db->fetchRow( $result ) ) {
		//print_r($server_time);
		$server_time = strtotime($server_time);
		$user_time = $server_time + $tzoffset_s2u ;
		
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$target_date = date('j',$user_time) ;
		$tmp_array = array(
			'dotgif' => $plugin['dotgif'] ,
			'dirname' => $plugin['dirname'] ,
			'link' => XOOPS_URL."/modules/{$plugin['dirname']}/memb_user.php?uid=$id" ,
			'id' => $id ,
			'server_time' => $server_time ,
			'user_time' => $user_time ,
			'name' => 'lastname' ,
			'title' => $myts->makeTboxData4Show( $lastname )
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