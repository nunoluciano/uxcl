<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

// referer check
$ref = xoops_getenv('HTTP_REFERER');
if( $ref == '' || strpos( $ref , XOOPS_URL.'/modules/system/admin.php' ) === 0 ) {
	/* module specific part */
	global $xoopsDB ;

	// 0.75 to 0.76
	$result = $xoopsDB->query( "SELECT event_tz FROM ".$xoopsDB->prefix("pical{$mydirnumber}_event")." LIMIT 1" ) ;
	if( $result ) {
		list( $event_tz ) = $xoopsDB->fetchRow( $result ) ;
		if( ! strstr( $event_tz , '.' ) ) {
			$xoopsDB->queryF( "ALTER TABLE ".$xoopsDB->prefix("pical{$mydirnumber}_event")." MODIFY event_tz float(2,1) NOT NULL default 0.0, MODIFY server_tz float(2,1) NOT NULL default 0.0, MODIFY poster_tz float(2,1) NOT NULL default 0.0, ADD KEY (admission), ADD KEY (allday), ADD KEY (start), ADD KEY (end), ADD KEY (start_date), ADD KEY (end_date), ADD KEY (dtstamp), ADD KEY (unique_id), ADD KEY (cid), ADD KEY (event_tz), ADD KEY (server_tz), ADD KEY (poster_tz), ADD KEY (uid), ADD KEY (groupid), ADD KEY (class), ADD KEY (rrule_pid), ADD KEY (categories)" ) ;
		}
	}
	// ALTER TABLE xoops_pical_event MODIFY event_tz smallint(5) NOT NULL default 0, MODIFY server_tz smallint(5) NOT NULL default 0, MODIFY poster_tz smallint(5) NOT NULL default 0, DROP KEY admission, DROP KEY allday, DROP KEY start, DROP KEY end, DROP KEY start_date, DROP KEY end_date, DROP KEY dtstamp, DROP KEY unique_id, DROP KEY cid, DROP KEY event_tz, DROP KEY server_tz, DROP KEY poster_tz, DROP KEY uid, DROP KEY groupid, DROP KEY class, DROP KEY rrule_pid, DROP KEY categories ;

	// 0.76 to 0.8
	$result = $xoopsDB->query( "SELECT * FROM ".$xoopsDB->prefix("pical{$mydirnumber}_plugins")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->queryF( "ALTER TABLE ".$xoopsDB->prefix("pical{$mydirnumber}_cat")." CHANGE cat_extkey1 cat_depth TINYINT unsigned NOT NULL DEFAULT 0, ADD cat_style varchar(255) NOT NULL default '', ADD KEY (pid), ADD KEY (weight), ADD KEY (cat_depth)" ) ;

		$xoopsDB->queryF( "CREATE TABLE ".$xoopsDB->prefix("pical{$mydirnumber}_plugins")." (
		  pi_id smallint(5) unsigned zerofill NOT NULL auto_increment,
		  pi_title varchar(255) NOT NULL default '',
		  pi_type varchar(8) NOT NULL default '',
		  pi_dirname varchar(50) NOT NULL default '',
		  pi_file varchar(50) NOT NULL default '',
		  pi_dotgif varchar(255) NOT NULL default '',
		  pi_options varchar(255) NOT NULL default '',
		  pi_enabled tinyint NOT NULL default 0,
		  pi_weight smallint(5) unsigned NOT NULL default 0,
		  last_modified timestamp ,

		  KEY (pi_weight),
		  KEY (pi_type),
		  KEY (pi_dirname),
		  KEY (pi_file),
		  KEY (pi_options),
		  KEY (pi_enabled),
		  PRIMARY KEY (pi_id)
		) ENGINE=MyISAM " ) ;

	}
	// DROP TABLE xoops_pical_plugins ;

	// 0.8RC to 0.8RC2
	$result = $xoopsDB->query( "SELECT pi_weight FROM ".$xoopsDB->prefix("pical{$mydirnumber}_plugins")." LIMIT 1" ) ;
	if( ! $result ) {
		$xoopsDB->queryF( "ALTER TABLE ".$xoopsDB->prefix("pical{$mydirnumber}_plugins")." ADD pi_weight smallint(5) unsigned NOT NULL default 0, ADD KEY (pi_weight)" ) ;
	}


	/* General part */

	// Keep the values of block's options when module is updated (by nobunobu)
	include dirname( __FILE__ ) . "/updateblock.inc.php" ;

}

?>