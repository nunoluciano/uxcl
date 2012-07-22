<?php

	// a plugin for eguide 2.x by nobu

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
	$just1gif = 0;
	
	// set range (added 86400 second margin "begin" & "end")
	$range_start_s = mktime(0,0,0,$this->month,0,$this->year) ;
	$range_end_s = mktime(0,0,0,$this->month+1,1,$this->year) ;

	// query
    $cond = isset($_GET['eid'])?" AND e.eid=".intval($_GET['eid']):"";
	$sql = 'SELECT c.catid,c.catname,e.title,IF(exdate,from_unixtime(exdate,"%Y-%m-%d"),
		from_unixtime(edate,"%Y-%m-%d")) eday, IF(exdate,exdate,edate) eday2 FROM '
		. $db->prefix("eguide_category")." c RIGHT JOIN "
		. $db->prefix("eguide")." e ON c.catid=e.topicid LEFT JOIN "
		. $db->prefix("eguide_extent")." x ON e.eid=eidref "
		. "GROUP BY catid,eid,exid "
		. "HAVING (eday2 BETWEEN $range_start_s AND $range_end_s) "
		. "ORDER BY eday,c.weight,c.catid";
    $result = $db->query( $sql ) ;
	if (!function_exists("eguide_marker")) {
		function eguide_marker($full, $dirname) {
		    static $marker;
		    if (empty($marker)) {
				$module_handler =& xoops_gethandler('module');
				$module =& $module_handler->getByDirname('eguide');
				$config_handler =& xoops_gethandler('config');
				$config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
				$marker = preg_split('/,|[\r\n]+/',$config['maker_set']);
		    }
		    $tmp = $marker;
		    while(list($k,$v) = array_splice($tmp, 0, 2)) {
				if ($full<$k) return $v;
		    }
	    	return '';
		}
	}
	$tmp_array = array();
	while( list( $catid, $catname, $title,  $eday) = $db->fetchRow( $result ) ) {
		$edate = explode("-",$eday);
		$server_time = mktime(0,0,0,$edate[1],$edate[2],$edate[0]) ;
		$user_time = $server_time + $tzoffset_s2u ;
		if ($user_time<$now) $full = -1;
		// Category Title
		$mark = $catname ;
		if(!$mark) $mark = $title;
		if(!$mark) $mark = $eday;
		$param = $catid ? "catid=".$catid : "";
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$target_date = date('j',$user_time) ;		
		$tmp_array[$target_date][$catid] = array(
			'dotgif' => $plugin['dotgif'] ,
			'dirname' => $plugin['dirname'] ,
			'link' => XOOPS_URL."/modules/{$plugin['dirname']}/event.php?$param&amp;caldate={$this->year}-{$this->month}-$target_date" ,
			'id' => $catid ,
			'name' => 'catid' ,
			'title' => $mark
		) ;
		//var_dump($tmp_array); die;
	}
	$plugin_returns = $tmp_array ;
?>
