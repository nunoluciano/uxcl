<?php
eval('
function '.$mydirname.'_global_search( $keywords , $andor , $limit , $offset , $userid )
{
	return xsns_search( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}
');

if(!function_exists('xsns_search')){

function xsns_search($mydirname, $queryarray, $andor, $limit, $offset, $userid)
{
	global $xoopsDB, $xoopsUser, $xoopsUserIsAdmin, $xoopsConfig;
	
	$lang_file = dirname(__FILE__).'/language/'.$xoopsConfig['language'].'/main.php';
	if(file_exists($lang_file)){
		require_once $lang_file;
	}
	
	require_once dirname(__FILE__).'/include/common_functions.php';
	
	$temp_arr = array();
	$datetime_arr = array();
	$perm_arr = array();
	$ret = array();
	
	$myts =& MyTextSanitizer::getInstance();
	$own_uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : -1;
	
	$count = is_array($queryarray) ? count($queryarray) : 0;
	
	// community search
	$where_sql = "";
	$uid_sql = empty($userid) ? "" : "uid_admin=".intval($userid);
	
	$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname.'_c_commu');
	if($count > 0){
		$kw_sql = "LIKE '%$queryarray[0]%'";
		$where_sql = " WHERE ((name $kw_sql OR info $kw_sql)";
		for($i=1; $i<$count; $i++){
			$kw_sql = "LIKE '%$queryarray[$i]%'";
			$where_sql .= " $andor (name $kw_sql OR info $kw_sql)";
		}
		$where_sql .= ")";
	}
	
	if(!empty($uid_sql)){
		if(!empty($where_sql)){
			$where_sql = $where_sql." AND ".$uid_sql;
		}
		else{
			$where_sql = " WHERE ".$uid_sql;
		}
	}
	$sql .= $where_sql. " ORDER BY r_datetime DESC";
	$rs = $xoopsDB->query($sql, $limit, $offset);
	
	$n = 0;
	
	while($row = $xoopsDB->fetchArray($rs)) {
		$temp_arr[$n] = array(
			'image' => '',
			'link' => '?cid='.intval($row['c_commu_id']),
			'title' => "["._MD_XSNS_COMMU."] ".$myts->htmlSpecialChars($row['name']),
			'time' => strtotime($row['r_datetime']),
			'uid' => intval($row['uid_admin']),
		);
		$datetime_arr[$n++] = strtotime($row['r_datetime']);
	}
	
	// topic search
	$where_sql = "";
	$uid_sql = empty($userid) ? "" : "tc.uid=".intval($userid);
	
	$sql = "SELECT ".
			"c.c_commu_id AS cid,".
			"c.uid_admin AS cadmin,".
			"c.uid_sub_admin AS csubadmin,".
			"c.public_flag AS cflag,".
			"t.c_commu_topic_id AS tid,".
			"t.name AS tname,".
			"tc.body AS tcbody,".
			"tc.uid AS tcuid,".
			"MAX(tc.r_datetime) AS max_r_datetime".
			" FROM (". $xoopsDB->prefix($mydirname.'_c_commu'). " c".
			" INNER JOIN ". $xoopsDB->prefix($mydirname.'_c_commu_topic_comment'). " tc".
			" USING(c_commu_id))".
			" INNER JOIN ". $xoopsDB->prefix($mydirname.'_c_commu_topic'). " t".
			" USING(c_commu_topic_id)";
	
	if($count > 0){
		$kw_sql = "LIKE '%$queryarray[0]%'";
		$where_sql = " WHERE ((t.name $kw_sql OR tc.body $kw_sql)";
		for($i=1; $i<$count; $i++){
			$kw_sql = "LIKE '%$queryarray[$i]%'";
			$where_sql .= " $andor (t.name $kw_sql OR tc.body $kw_sql)";
		}
		$where_sql .= ")";
	}
	
	if(!empty($uid_sql)){
		if(!empty($where_sql)){
			$where_sql = $where_sql." AND ".$uid_sql;
		}
		else{
			$where_sql = " WHERE ".$uid_sql;
		}
	}
	$sql .= $where_sql. " GROUP BY tid ORDER BY max_r_datetime DESC";
	$rs = $xoopsDB->query($sql, $limit, $offset);
	
	while($row = $xoopsDB->fetchArray($rs)) {
		// check community permission
		if($row['cflag']==3 && !$xoopsUserIsAdmin && $row['cadmin']!=$own_uid && $row['csubadmin']!=$own_uid){
			if($own_uid < 0){
				continue;
			}
			$cid = intval($row['cid']);
			if(!isset($perm_arr[$cid])){
				$perm_arr[$cid] = xsns_is_community_member($mydirname, $cid, $own_uid);
			}
			if(!$perm_arr[$cid]){
				continue;
			}
		}
		
		$temp_arr[$n] = array(
			'image' => '',
			'link' => '?p=topic&tid='.intval($row['tid']),
			'title' => "["._MD_XSNS_TOPIC."] ".$myts->htmlSpecialChars($row['tname']),
			'time' => strtotime($row['max_r_datetime']),
			'uid' => intval($row['tcuid']),
		);
		$datetime_arr[$n++] = strtotime($row['max_r_datetime']);
	}
	
	arsort($datetime_arr);
	
	$n = 0;
	foreach($datetime_arr as $id => $value){
		$ret[] =& $temp_arr[$id];
		if($limit==++$n){
			break;
		}
	}
	return $ret;
}

}

?>
