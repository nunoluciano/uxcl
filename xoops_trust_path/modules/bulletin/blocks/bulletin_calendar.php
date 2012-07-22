<?php

function b_bulletin_calendar_show($options) {

	global $xoopsDB;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;

	require_once dirname(dirname(__FILE__)).'/class/bulletin_cal.php';
	require_once dirname(dirname(__FILE__)).'/class/bulletingp.php' ;

	$block = array();
//ver3.0 can_read access
	$gperm =& BulletinGP::getInstance($mydirname) ;
	$can_read_topic_ids = $gperm->makeOnTopics('can_read');
//	if (empty($can_read_topic_ids)){
//		return false;
//	}

	$today = isset( $_GET['today'] ) ? $_GET['today'] : date('Y-m') ;

	$year  = date('Y');
	$month = date('m');

	if(preg_match('/([0-9]{4})-([0-9]{2})/', $today, $todayarr)){
		$year  = $todayarr[1];
		$month = $todayarr[2];
	}
	if(!checkdate($month,1,$year)){
		$year  = date('Y');
		$month = date('m');
	}

	$weekname = array(_MB_BULLETIN_SUN,_MB_BULLETIN_MON,_MB_BULLETIN_TUE,_MB_BULLETIN_WED,_MB_BULLETIN_THE,_MB_BULLETIN_FRI,_MB_BULLETIN_SAT);

	//
	$sql = "SELECT published FROM ".$xoopsDB->prefix( "{$mydirname}_stories" );
	if (!empty($can_read_topic_ids)){
		$sql .= ' WHERE topicid IN ('.implode(',',$can_read_topic_ids).')';
		if (!$gperm->group_perm(2)){
			$sql .= " AND type > 0";
		}
	}else{
		if (!$gperm->group_perm(2)){
			$sql .= " WHERE type > 0";
		}
	}
	$sql .= " ORDER BY published ASC";
	list($startday) = $xoopsDB->fetchRow($xoopsDB->query($sql));

	$sql = "SELECT published FROM ".$xoopsDB->prefix( "{$mydirname}_stories" );
	if (!empty($can_read_topic_ids)){
		$sql .= ' WHERE topicid IN ('.implode(',',$can_read_topic_ids).')';
		if (!$gperm->group_perm(2)){
			$sql .= " AND type > 0";
		}
	}else{
		if (!$gperm->group_perm(2)){
			$sql .= " WHERE type > 0";
		}
	}
	$sql .= " ORDER BY published DESC";
	list($endday) = $xoopsDB->fetchRow($xoopsDB->query($sql));

	$starttimestamp4sql = mktime(0,0,0,$month,1,$year);
	$endtimestamp4sql   = mktime(0,0,0,$month+1,1,$year);

	$sql = "SELECT storyid, published FROM ".$xoopsDB->prefix( "{$mydirname}_stories" );
	$sql .= " WHERE published > 0 AND published <= ".time()." AND (expired = 0 OR expired > ".time().") AND $starttimestamp4sql <= published AND published < $endtimestamp4sql";
	if (!empty($can_read_topic_ids)){
		$sql .= ' AND topicid IN ('.implode(',',$can_read_topic_ids).')';
	}else{
		$sql .= ' AND topicid IN (0)';
	}
	if (!$gperm->group_perm(2)){
		$sql .= " AND type > 0";
	}
	$result = $xoopsDB->query($sql);


	$cal = new Bulletin_Cal;
	$cal->setDate($today, $startday, $endday);
	$cal->setWeekName( $weekname );
	while(list($storyid, $published) = $xoopsDB->fetchRow($result)){
		$day = intval(date('d', $published));
		$cal->setLink($day, XOOPS_URL.'/modules/'.$mydirname.'/index.php?caldate='.date('Y-m-d', $published));
	}
	$cal->setTitle(_MB_BULLETIN_DATE_FORMAT);
	$block['content'] = $cal->getThemeCalendar();

	return $block;

}
?>