<?php
/*
 * Created on 2010/11/28 by naao http://www.naaon.com/
 * $Id: whatsnew.inc.php,v 0.01 2010/11/28 naao Exp $
 */

// === eval begin ===
eval( '
	function '.$mydirname.'_new($limit=0, $offset=0) {
		return xsns_new_base( "'.$mydirname.'", $limit , $offset ) ;
	}
' ) ;

if( ! function_exists( 'xsns_new_base' ) ) {

	function xsns_new_base( $mydirname, $limit=0, $offset=0 ) 
	{
		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;
		$constpref = '_MB_' . strtoupper( $mydirname ) ;

		$URL_MOD = XOOPS_URL."/modules/".$mydirname;

		$mytrustdirpath = dirname(dirname( __FILE__ )) ;

		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$block = array();
		$perm_arr = array();
	
		$own_uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : -1;
	
		// naao from
		//各トピの最新コメントIDを取得
		$sql = "SELECT c_commu_topic_id AS tid, MAX(c_commu_topic_comment_id) AS com_id FROM ". $db->prefix($mydirname.'_c_commu_topic_comment')." GROUP BY tid;";

		$result = $db->query($sql);
		if(!$result || $db->getRowsNum($result) < 1){
			return array();
		}
	
		while ( $dbdat = $db->fetchArray($result)){
			$com_num[] = intval($dbdat['com_id']);
		}

 	 	$whr_num = "tc.c_commu_topic_comment_id IN (" .implode( "," , $com_num ). ") ";

		// topic search
		$sql = "SELECT ".
			"c.c_commu_id AS cid,".
			"c.name AS cname,".
			"c.uid_admin AS cadmin,".
			"c.uid_sub_admin AS csubadmin,".
			"c.public_flag AS cflag,".
			"t.c_commu_topic_id AS tid,".
			"t.name AS tname,".
			"tc.body AS tcbody,".
			"tc.uid AS tcuid,".
			"tc.number AS comment_count,".
			"tc.r_datetime AS r_datetime,".
			"tc.c_commu_topic_comment_id ".
			" FROM (". $db->prefix($mydirname.'_c_commu'). " c".
			" INNER JOIN ". $db->prefix($mydirname.'_c_commu_topic_comment'). " tc".
			" USING(c_commu_id))".
			" INNER JOIN ". $db->prefix($mydirname.'_c_commu_topic'). " t".
			" USING(c_commu_topic_id)".
			" WHERE ".$whr_num.
			" ORDER BY r_datetime DESC";
		// naao to
	
		$rs = $db->query($sql);
		if(!$rs || $db->getRowsNum($rs) < 1){
			return array();
		}
	
		$today = date('Y-m-d');
		$i = 0;
		require_once dirname(dirname(__FILE__)).'/userlib/utils.php';
	
		$ret	= array();
		while($row = $db->fetchArray($rs)) {
		
			if($limit <= $i){
				break;
			}
		
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
		
			$r_time = strtotime($row['r_datetime']);
			$comment_index = intval(intval($row['comment_count'])/20)*20;	//naao
			
				$ret[$i]['description']	= trim( $myts->htmlSpecialChars($row['tcbody']));
				$ret[$i]['link']	= XOOPS_URL.'/modules/'.$mydirname.'/?p=topic&tid='.intval($row['tid']).'&s='.$comment_index.'#'.intval($row['comment_count']);
				$ret[$i]['cname'] 	=  $myts->htmlSpecialChars($row['cname']);
				$ret[$i]['cat_link'] 	= XOOPS_URL.'/modules/'.$mydirname.'/?cid='.intval($row['cid']);
				$ret[$i]['title']    	= $myts->htmlSpecialChars($row['tname']);
				$ret[$i]['time']	= $r_time;
				$ret[$i]['uid']  	= intval($row['tcuid']);
			//	$ret[$i]['hits'] 	= $row['view'];
				$ret[$i]['replies'] 	= intval($row['comment_count']) ;
			//	$ret[$i]['image']	= !empty($row['photo']) ? $URL_MOD."/upimg/".$row['photo'] : "";
				$ret[$i]['id']   	= intval($row['tid']);
				$i++;
		}

		return $ret;
	}

}

?>