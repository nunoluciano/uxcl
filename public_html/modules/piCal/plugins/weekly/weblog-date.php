<?php
    // a plugin for weblog

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

    // set range (added 86400 second margin "begin" & "end")
    $wtop_date = $this->date - ( $this->day - $this->week_start + 7 ) % 7 ;
    $range_start_s = mktime(0,0,0,$this->month,$wtop_date-1,$this->year) ;
    $range_end_s = mktime(0,0,0,$this->month,$wtop_date+8,$this->year) ;

    $add_whr = "" ;
//    $group_by = "" ;  // show by each entry
    $group_by = " group by left(from_unixtime(created)+0,8) " ;  // show by daily 

    if( ! defined('_WEBLOG_COMMON_FUNCTIONS') )
		$original_mydirname = @$mydirname ;
		$mydirname = $plugin['dirname'] ;
        include_once sprintf('%s/modules/%s/config.php',XOOPS_ROOT_PATH,$plugin['dirname']) ;
		$mydirname = @$original_mydirname ;
    if( function_exists('weblog_create_permissionsql') ){
        $mod_handler =& xoops_gethandler('module');
        $weblogmodule_config_handler =& xoops_gethandler('config');
        $mod_weblog =& $mod_handler->getByDirname($plugin['dirname']); 
        $weblog_config = $weblogmodule_config_handler->getConfigList($mod_weblog->mid());
        list( $bl_contents_field , $add_whr ) = weblog_create_permissionsql($weblog_config,$plugin['dirname']) ;
    }else{
        $add_whr = "" ;
    }

    // query (added 86400 second margin "begin" & "end")
    $weblog_minical_sql = "SELECT title,blog_id,`created`,count(blog_id) FROM ".$db->prefix('weblog'.$mydirnumber). " as bl WHERE `created` >= $range_start_s AND `created` < $range_end_s and private!='Y' " . $add_whr . $group_by ;
    $result = $db->query($weblog_minical_sql) ;
    while( list( $title , $blog_id , $server_time , $entry_num) = $db->fetchRow( $result ) ) {
        $user_time = $server_time + $tzoffset_s2u ;
      $entry_num = ($entry_num>1) ? $entry_num.'entries' : $entry_num.'entry' ;
//        if( date( 'n' , $user_time ) != $this->month ) continue ;
        $target_date = date('j',$user_time) ;
        $tmp_array = array(
            'dotgif' => $plugin['dotgif'] ,
            'dirname' => $plugin['dirname'] ,
            'link' => XOOPS_URL."/modules/" . $plugin['dirname'] . "/index.php?caldate=" . date('Y-n-j',$user_time).'&date='.date('Ymd',$user_time) ,
            'id' => $blog_id . $server_time ,
            'server_time' => $server_time ,
            'user_time' => $user_time ,
            'name' => 'blog_id' ,
            'title' => $plugin['name'].'('.$entry_num.')' 
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