<?php

require_once 'root.class.php';
require_once 'topic.class.php';
require_once 'member.class.php';
require_once 'category.class.php';

//******************************************************************************

class XsnsCommunity extends XsnsRoot
{
	var $handler = NULL;
	
	//--------------------------------------------------------------------------
	
	function XsnsCommunity()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_commu_id', XOBJ_DTYPE_INT);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('uid_admin', XOBJ_DTYPE_INT);
		$this->initVar('uid_sub_admin', XOBJ_DTYPE_INT);
		$this->initVar('info', XOBJ_DTYPE_TXTAREA);
		$this->initVar('c_commu_category_id', XOBJ_DTYPE_INT);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
		$this->initVar('r_date', XOBJ_DTYPE_DATE);
		$this->initVar('public_flag', XOBJ_DTYPE_INT);
		$this->initVar('access_count', XOBJ_DTYPE_INT);
		$this->initVar('update_freq', XOBJ_DTYPE_FLOAT);
		$this->initVar('popularity', XOBJ_DTYPE_FLOAT);
		$this->initVar('up_datetime', XOBJ_DTYPE_DATETIME);
		
		$this->handler = array(
			'community' => XsnsCommunityHandler::getInstance(),
			'user' => XsnsUserHandler::getInstance(),
			'member' => XsnsMemberHandler::getInstance(),
			'image' => XsnsImageHandler::getInstance(),
			'topic' => XsnsTopicHandler::getInstance(),
			'comment' => XsnsTopicCommentHandler::getInstance(),
			'category' => XsnsCategoryHandler::getInstance(),
			'access_log' => XsnsAccessLogHandler::getInstance(),
		);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInfo()
	{
		$ret = array();
		foreach($this->vars as $key => $value){
			$ret[$key] = $this->getVar($key);
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function checkAuthority($perm_flag=NULL)
	{
		if(is_null($perm_flag)){
			// default value
			$permission = XSNS_AUTH_XOOPS_ADMIN | XSNS_AUTH_ADMIN | XSNS_AUTH_SUB_ADMIN | XSNS_AUTH_MEMBER;
		}
		else{
			$permission = intval($perm_flag);
		}
		
		if($permission & $this->getAuthority()){
			return true;
		}
		return false;
	}
	
	//--------------------------------------------------------------------------
	
	function getAuthority()
	{
		global $xoopsUser, $xoopsUserIsAdmin;
		if(is_object($xoopsUser)){
			$uid = $xoopsUser->getVar('uid');
		}
		else{
			return 0;
		}
		
		if(in_array(XOOPS_GROUP_ANONYMOUS, $xoopsUser->getGroups())){
			return XSNS_AUTH_GUEST;
		}
		
		$status = 0;
		
		if($xoopsUserIsAdmin){
			$status = $status | XSNS_AUTH_XOOPS_ADMIN;
		}
		
		if($uid > 0){
			if($uid == $this->getVar('uid_admin')){
				$status = $status | XSNS_AUTH_ADMIN;
			}
			elseif($uid == $this->getVar('uid_sub_admin')){
				$status = $status | XSNS_AUTH_SUB_ADMIN;
			}
			else{
				if( $c_member =& $this->handler['member']->getOne($this->getVar('c_commu_id'), $uid) ){
					$status = $status | XSNS_AUTH_MEMBER;
				}
				else{
					$status = $status | XSNS_AUTH_NON_MEMBER;
				}
			}
		}
		return $status;
	}
	
	//--------------------------------------------------------------------------
	
	function &getMemberObjects($limit=0, $start=0, $order_by_rand=false)
	{
		$criteria = new Criteria('cm.c_commu_id', $this->getVar('c_commu_id'));
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		if($order_by_rand){
			$criteria->setSort('RAND()');
		}
		return $this->handler['member']->getObjects($criteria);
	}
	
	//--------------------------------------------------------------------------
	
	function getMemberCount()
	{
		$criteria = new Criteria('cm.c_commu_id', $this->getVar('c_commu_id'));
		return $this->handler['member']->getCount($criteria);
	}
	
	//--------------------------------------------------------------------------
	
	function &getTopicList($limit=0, $start=0, $get_body=false)
	{
		return $this->handler['topic']->getListForCommunity($this->getVar('c_commu_id'), $limit, $start, $get_body);
	}
	
	//--------------------------------------------------------------------------
	
	function getTopicCount()
	{
		return $this->handler['topic']->getCountForCommunity($this->getVar('c_commu_id'));
	}
	
	//--------------------------------------------------------------------------
	
	function getCategoryName()
	{
		$category =& $this->handler['category']->get($this->getVar('c_commu_category_id'));
		if(is_object($category)){
			return $category->getVar('name');
		}
		return NULL;
	}
	
	//--------------------------------------------------------------------------
	
	function incrementAccessCount($interval = 3600)	// [sec.]
	{
		global $xoopsUser;
		if(!is_object($xoopsUser)){
			return false;
		}
		$own_uid = $xoopsUser->getVar('uid');
		
		$now_time = time();
		$now_datetime = date('Y-m-d H:i:s', $now_time);
		$last_datetime = date('Y-m-d H:i:s', ($now_time - $interval));
		
		$cid = $this->getVar('c_commu_id');
		
		$criteria = new CriteriaCompo(new Criteria('uid', $own_uid));
		$criteria->add(new Criteria('c_commu_id', $cid));
		$criteria->add(new Criteria('r_datetime', $last_datetime, '>'));
		$last_access = $this->handler['access_log']->getCount($criteria);
		
		if(!$last_access){
			$new_access_log =& $this->handler['access_log']->create();
			$new_access_log->setVars(array(
				'uid' => $own_uid,
				'c_commu_id' => $cid,
				'r_datetime' => $now_datetime,
			));
			
			if($this->handler['access_log']->insert($new_access_log, true)){	// queryF
				$access_count = $this->getVar('access_count') + 1;
				$this->setVar('access_count', $access_count);
				return $this->handler['community']->insert($this, true);	// queryF
			}
		}
		return false;
	}
	//--------------------------------------------------------------------------

	function getAccessCountInPeriod($day_range = 0)
	{
		$criteria = new CriteriaCompo(new Criteria('c_commu_id', $this->getVar('c_commu_id')));
		
		if($day_range > 0 && $day_range<=365){
			$start_date = date('Y-m-d', time() - 86400 * $day_range);
			$criteria->add(new Criteria('r_datetime', $start_date, '>='));
		}
		return $this->handler['access_log']->getCount($criteria);
	}
	//--------------------------------------------------------------------------

	function getCommentPostCountInPeriod($day_range = 0)
	{
		$criteria = new CriteriaCompo(new Criteria('c_commu_id', $this->getVar('c_commu_id')));
		
		if($day_range > 0 && $day_range<=365){
			$start_date = date("Y-m-d", time() - 86400 * $day_range);
			$criteria->add(new Criteria('r_datetime', $start_date, '>='));
		}
		return $this->handler['comment']->getCount($criteria);
	}
	//--------------------------------------------------------------------------
	
	function getPastTime()
	{
		return time() - $this->getVar('r_datetime');	// [sec.]
	}
	//--------------------------------------------------------------------------
	
	function getPopularity($day_range, $delay_time)
	{
		$past_time = $this->getPastTime();
		if($past_time < $delay_time){
			return 0;
		}
		$past_day = $past_time / 86400;
		if($day_range > $past_day){
			$day_range = $past_day;
		}
		$access_count = $this->getAccessCountInPeriod($day_range);
		if($day_range > 0){
			return round($access_count/$day_range, 1);
		}
		return 0;
	}
	//--------------------------------------------------------------------------

	function getUpdateFrequency($day_range, $delay_time)
	{
		$past_time = $this->getPastTime();
		if($past_time < $delay_time){
			return 0;
		}
		$past_day = $past_time / 86400;
		if($day_range > $past_day){
			$day_range = $past_day;
		}
		$post_count = $this->getCommentPostCountInPeriod($day_range);
		if($day_range > 0){
			return round($post_count/$day_range, 1);
		}
		return 0;
	}
	//--------------------------------------------------------------------------

	function getPopularityLevel($popularity)
	{
		global $xoopsModuleConfig;
		if($popularity < 0 || !isset($xoopsModuleConfig['pop_level_max']) || $xoopsModuleConfig['pop_level_max'] < 1){
			return 0;
		}
		$level = 1 + intval(4 * $popularity/$xoopsModuleConfig['pop_level_max']);
		return ($level>5) ? 5 : $level;
	}
	//--------------------------------------------------------------------------

	function getUpdateFrequencyLevel($update_freq)
	{
		global $xoopsModuleConfig;
		if($update_freq < 0 || !isset($xoopsModuleConfig['freq_level_max']) || $xoopsModuleConfig['freq_level_max'] < 1){
			return 0;
		}
		$level = 1 + intval(4 * $update_freq/$xoopsModuleConfig['freq_level_max']);
		return ($level>5) ? 5 : $level;
	}
	//--------------------------------------------------------------------------

	function getStatistics()
	{
		$pop_images = array(
			'rank0.gif', 'rank1y.gif', 'rank2y.gif', 'rank3y.gif', 'rank4y.gif', 'rank5y.gif'
		);
		$up_images = array(
			'rank0.gif', 'rank1r.gif', 'rank2r.gif', 'rank3r.gif', 'rank4r.gif', 'rank5r.gif'
		);
		
		$popularity = $this->getVar('popularity');
		$update_freq = $this->getVar('update_freq');
		
		$pop_level = $this->getPopularityLevel($popularity);
		$up_level = $this->getUpdateFrequencyLevel($update_freq);
		
		$pop_img = isset($pop_images[$pop_level]) ? XSNS_BASE_URL.'/images/'.$pop_images[$pop_level] : "";
		$up_img = isset($up_images[$up_level]) ? XSNS_BASE_URL.'/images/'.$up_images[$up_level] : "";
		
		$statistics = array(
			'popularity' => array(
				'value' => $popularity,
				'image' => $pop_img,
			),
			'update_frequency' => array(
				'value' => $update_freq,
				'image' => $up_img,
			),
		);
		return $statistics;
	}
	//--------------------------------------------------------------------------
	
	function setStatistics($interval = 3600, $day_range = 30, $delay_time = 3600)
	{
		$this->incrementAccessCount($interval);
		
		if($this->checkUpdateInterval()){
			$popularity = $this->getPopularity($day_range, $delay_time);
			$update_freq = $this->getUpdateFrequency($day_range, $delay_time);
			
			$this->setVars(array(
				'update_freq' => floatval($update_freq),
				'popularity' => floatval($popularity),
				'up_datetime' => date('Y-m-d H:i:s'),
			));
			$this->handler['community']->insert($this, true);	// queryF
		}
	}
	//--------------------------------------------------------------------------
	
	function checkUpdateInterval($up_interval = 600)
	{
		if($up_interval < $this->getPastTime()){
			return true;
		}
		return false;
	}
	//--------------------------------------------------------------------------
	
	function &getImage($thumb_id=XSNS_IMAGE_SIZE_M)
	{
		$ret = NULL;
		$this->handler['image']->setFormLimit(1);
		$image =& $this->handler['image']->getList(1, $this->getVar('c_commu_id'), $thumb_id);
		if(is_array($image) && count($image)==1){
			$ret =& $image[0];
		}
		return $ret;
	}
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsCommunityHandler extends XsnsRootHandler
{
	var $errors = array();
	//--------------------------------------------------------------------------
	
	function XsnsCommunityHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsCommunity";
		$this->table_name = "c_commu";
		$this->primary_key = "c_commu_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsCommunityHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getList($criteria = NULL)
	{
		$limit = $start = 0;
		$ret = array();
		
		$sql = "SELECT cc.*,COUNT(ccm.uid) AS member_count FROM ".
				$this->prefix($this->table_name)." cc".
				" LEFT JOIN ".$this->prefix('c_commu_member')." ccm".
				" ON cc.c_commu_id=ccm.c_commu_id";
		$sql_order = "";
		
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql_where = $criteria->render();
			if(!empty($sql_where)){
				$sql .= " WHERE ".$sql_where;
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
			
			if ($criteria->getSort() != '') {
				$sql_order .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
			}
		}
		$sql .= " GROUP BY ccm.c_commu_id". $sql_order;
		
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		
		$obj_list = array();
		$cids = array();
		$cat_ids = array();
		$image_handler =& XsnsImageHandler::getInstance();
		$image_handler->setFormLimit(1);
		$category_handler =& XsnsCategoryHandler::getInstance();
		
		while ($row = $this->db->fetchArray($result)) {
			$obj = new $this->obj_class();
			$obj->assignVars($row);
			$cid = $obj->getVar('c_commu_id');
			$obj_list[$cid] = $obj;
			$cids[] = $cid;
		}
		$image_list =& $image_handler->getListByIds(1, $cids, XSNS_IMAGE_SIZE_S);
		$category_list =& $category_handler->getNameList();
		
		foreach($obj_list as $cid => $obj){
			if(!is_object($obj)){
				continue;
			}
			$cat_id = $obj->getVar('c_commu_category_id');
			$ret[] = array(
				'c_commu_id' => $cid,
				'name' => $obj->getVar('name'),
			//	'info' => $obj->getVar('info', 'x'),		// stripXoopsCode
				'info' => strip_tags($obj->getVar('info')),	// naao
				'category_name' => isset($category_list[$cat_id]) ? $category_list[$cat_id] : "",
				'member_count' => $obj->getMemberCount(),	// != $row['member_count']
				'page_url' => XSNS_BASE_URL.'/?cid='.$cid,
				'image' => isset($image_list[$cid][0]) ? $image_list[$cid][0] : array(),
			);
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function nameExists($name)
	{
		$criteria = new Criteria('name', $name);
		return ($this->getCount($criteria) > 0) ? true : false;
	}
	
	//--------------------------------------------------------------------------
	
	function checkParams($cid, $name, $info, $cat_id, $public_id)
	{
		$ts =& XsnsTextSanitizer::getInstance();
		$name = $ts->stripSlashesGPC($name);
		
		$this->errors = array();
		
		// 名前が入力されていない
		if(empty($name)){
			$this->errors[] = _MD_XSNS_INDEX_NAME_NG;
		}
		
		// 同じ名前が既に存在する
		if($this->nameExists($name)){
			if($cid == 0){
				$this->errors[] = _MD_XSNS_INDEX_NAME_EXISTS_NG;
			}
			else{
				$community =& $this->get($cid);
				if(is_object($community) && $name != $community->getVar('name', 'n')){	// raw data
					$this->errors[] = _MD_XSNS_INDEX_NAME_EXISTS_NG;
				}
			}
		}
		
		// 説明文が入力されていない
		if(empty($info)){
			$this->errors[] = _MD_XSNS_INDEX_DESC_NG;
		}
		
		// カテゴリが選択されていない
		if($cat_id < 1){
			$this->errors[] = _MD_XSNS_INDEX_CATEGORY_NG;
		}
		
		if(count($this->errors) == 0){
			return true;
		}
		return false;
	}
	
	//------------------------------------------------------------------------------
	
	function getErrors()
	{
		return $this->errors;
	}
	
	//------------------------------------------------------------------------------
}

//******************************************************************************

?>
