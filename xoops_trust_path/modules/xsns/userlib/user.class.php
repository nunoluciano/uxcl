<?php

require_once 'root.class.php';
require_once XSNS_USERLIB_DIR.'/blog_module.php';

//******************************************************************************

class XsnsUser extends XoopsUser
{
	var $handler = NULL;
	var $ts = NULL;
	var $friend_blog_count = NULL;
	//--------------------------------------------------------------------------
	
	function XsnsUser()
	{
		$this->XoopsUser();
		
		$this->ts =& XsnsTextSanitizer::getInstance();
		
		$this->handler = array(
			'community' => XsnsCommunityHandler::getInstance(),
			'member' => XsnsMemberHandler::getInstance(),
			'user' => XsnsUserHandler::getInstance(),
			'friend' => XsnsFriendHandler::getInstance(),
			'confirm' => XsnsConfirmHandler::getInstance(),
			'module_config' => XsnsModuleConfigHandler::getInstance(),
			'intro' => XsnsIntroductionHandler::getInstance(),
		);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInfo()
	{
		$uid = $this->getVar('uid');
		$avatar = $this->getAvatar();
		
		$ret = array(
			'uid' => $uid,
			'name' => $this->getVar('uname'),
			'page_url' => XSNS_URL_MYPAGE.'&uid='.$uid,
			'avatar_url' => $avatar['url'],
			'avatar_width' => $avatar['width'],
			'avatar_height' => $avatar['height'],
			'last_login' => $this->getVar('last_login'),
		);
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getAvatar()
	{
		$image_default = '/images/cm_no_avatar.gif';
		
		if($this->getVar('user_avatar') != 'blank.gif'){
			$image_url = XOOPS_UPLOAD_URL.'/'.$this->getVar('user_avatar');
			$image_path = XOOPS_UPLOAD_PATH.'/'.$this->getVar('user_avatar');
		}
		else{
			$image_url = XSNS_BASE_URL. $image_default;
			$image_path = XSNS_BASE_DIR. $image_default;
		}
		
		if(!function_exists('getimagesize') || !($imagesize = getimagesize($image_path))){
			$ret = array(
				'url' => XSNS_BASE_URL. $image_default,
				'width' => '',
				'height' => '',
			);
			return $ret;
		}
		
		$w_ratio = XSNS_AVATAR_MAX_WIDTH / $imagesize[0];
		$h_ratio = XSNS_AVATAR_MAX_HEIGHT / $imagesize[1];
		$ratio = ($w_ratio < $h_ratio) ? $w_ratio : $h_ratio;
		if($ratio > 1){
			$ratio = 1;
		}
		
		$ret = array(
			'url' => $image_url,
			'width' => intval($ratio * $imagesize[0]),
			'height' => intval($ratio * $imagesize[1]),
		);
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function isCommunityMember($cid)
	{
		$c_member =& $this->handler['member']->getOne($cid, $this->getVar('uid'));
		return is_object($c_member) ? true : false;
	}
	
	//--------------------------------------------------------------------------
	
	function isFriend($uid)
	{
		$friend =& $this->handler['friend']->getOne($this->getVar('uid'), $uid);
		return is_object($friend) ? true : false;
	}
	
	//--------------------------------------------------------------------------
	
	function &getCommunityList($limit=0, $start=0, $order_by_rand=false)
	{
		$criteria = new Criteria('ccm.uid', $this->getVar('uid'));
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		if($order_by_rand){
			$criteria->setSort('RAND()');
		}
		return $this->handler['community']->getList($criteria);
	}
	
	//--------------------------------------------------------------------------
	
	function getCommunityCount()
	{
		$criteria = new Criteria('u.uid', $this->getVar('uid'));
		return $this->handler['member']->getCount($criteria);
	}
	
	//--------------------------------------------------------------------------
	
	function &getTopicList($limit=0, $start=0)
	{
		$sql = "SELECT ".
				"c.c_commu_id,".
				"c.name as cname,".
				"ct.c_commu_topic_id,".
				"ct.name as tname,".
				"MAX(ctc.r_datetime) as max_r_datetime".
				" FROM ((". $this->handler['community']->prefix('c_commu'). " c".
				" INNER JOIN ". $this->handler['community']->prefix('c_commu_member'). " cm".
				" USING(c_commu_id))".
				" INNER JOIN ". $this->handler['community']->prefix('c_commu_topic_comment'). " ctc".
				" USING(c_commu_id))".
				" INNER JOIN ". $this->handler['community']->prefix('c_commu_topic'). " ct".
				" USING(c_commu_topic_id)".
				" WHERE cm.uid='".$this->getVar('uid')."'".
				" GROUP BY ctc.c_commu_topic_id".
				" ORDER BY max_r_datetime DESC";
		$rs = $this->handler['community']->db->query($sql, $limit, $start);
		$ret = array();
		while($row = $this->handler['community']->db->fetchArray($rs)){
			$url = XSNS_URL_TOPIC;
			$ret[] = array(
				'name' => $this->ts->makeTboxData4Preview($row['tname']),
				'url' => $url.'&tid='.$row['c_commu_topic_id'],
				'time' => XsnsUtils::getUserTimestamp($row['max_r_datetime']),
				'commu_name' => $this->ts->makeTboxData4Preview($row['cname']),
				'commu_url' => XSNS_URL_COMMU.'?cid='.$row['c_commu_id'],
			);
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getTopicCount()
	{
		$sql = "SELECT ct.c_commu_topic_id".
				" FROM ((". $this->handler['community']->prefix('c_commu'). " c".
				" INNER JOIN ". $this->handler['community']->prefix('c_commu_member'). " cm".
				" USING(c_commu_id))".
				" INNER JOIN ". $this->handler['community']->prefix('c_commu_topic_comment'). " ctc".
				" USING(c_commu_id))".
				" INNER JOIN ". $this->handler['community']->prefix('c_commu_topic'). " ct".
				" USING(c_commu_topic_id)".
				" WHERE cm.uid='".$this->getVar('uid')."'".
				" GROUP BY ctc.c_commu_topic_id";
		$rs = $this->handler['community']->db->query($sql);
		if($rs){
			return $this->handler['community']->db->getRowsNum($rs);
		}
		return 0;
	}
	
	//--------------------------------------------------------------------------
	
	function setCommunityAdmin($cid)
	{
		$community =& $this->handler['community']->get($cid);
		$community->setVar('uid_admin', $this->getVar('uid'));
		return $this->handler['community']->insert($community);
	}
	
	//--------------------------------------------------------------------------
	
	function setCommunitySubAdmin($cid)
	{
		$community =& $this->handler['community']->get($cid);
		$community->setVar('uid_sub_admin', $this->getVar('uid'));
		return $this->handler['community']->insert($community);
	}
	
	//--------------------------------------------------------------------------
	
	function joinCommunity($cid)
	{
		$new_member =& $this->handler['member']->create();
		$new_member->setVars(array(
			'c_commu_id' => $cid,
			'uid' => $this->getVar('uid'),
			'r_datetime' => date('Y-m-d H:i:s'),
		));
		return $this->handler['member']->insert($new_member);
	}
	
	//--------------------------------------------------------------------------
	
	function leaveCommunity($cid)
	{
		$member =& $this->handler['member']->getOne($cid, $this->getVar('uid'));
		return $this->handler['member']->delete($member);
	}
	
	//--------------------------------------------------------------------------
	
	function setFriend($uid)
	{
		$friend =& $this->handler['friend']->create();
		$friend->setVar('uid_from', $uid);
		$friend->setVar('uid_to', $this->getVar('uid'));
		return $this->handler['friend']->insert($friend);
	}
	
	//--------------------------------------------------------------------------
	
	function unsetFriend($uid)
	{
		$friend =& $this->handler['friend']->getOne($this->getVar('uid'), $uid);
		return $this->handler['friend']->delete($friend);
	}
	
	//--------------------------------------------------------------------------
	
	function &getFriendList($limit=0, $start=0, $order_by_rand=false)
	{
		$ret = array();
		
		$criteria = new Criteria('f.uid_from', $this->getVar('uid'));
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		if($order_by_rand){
			$criteria->setSort('RAND()');
		}
		
		$friend_obj_list =& $this->handler['friend']->getObjects($criteria);
		if(is_array($friend_obj_list)){
			foreach($friend_obj_list as $friend_obj){
				$friend =& $this->handler['user']->get($friend_obj->getVar('uid_to'));
				if(is_object($friend)){
					$ret[] =& $friend->getInfo();
				}
				unset($friend);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getFriendCount()
	{
		$criteria = new Criteria('f.uid_from', $this->getVar('uid'));
		return $this->handler['friend']->getCount($criteria);
	}
	
	//--------------------------------------------------------------------------
	
	function &getModuleList($view_mode=true)
	{
		return $this->handler['module_config']->getList($this->getVar('uid'), $view_mode);
	}
	
	//--------------------------------------------------------------------------
	
	function &getMyBlogList($limit, $start, &$blog_count)
	{
		$blog_module_mgr =& XsnsBlogModuleManager::getInstance();
		return $blog_module_mgr->getMyBlogList($this->getVar('uid'), $limit, $start, $blog_count);
	}
	
	//--------------------------------------------------------------------------
	
	function &getFriendBlogList($limit, $start, &$blog_count)
	{
		$blog_module_mgr =& XsnsBlogModuleManager::getInstance();
		return $blog_module_mgr->getFriendBlogList($this->getVar('uid'), $limit, $start, $blog_count);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInformationList()
	{
		$ret = array();
		
		$sql = "SELECT mode,COUNT(*),MAX(r_datetime) AS max_r_datetime".
				" FROM ".$this->handler['confirm']->prefix('c_commu_confirm').
				" WHERE uid_to='".$this->getVar('uid')."'".
				" GROUP BY mode".
				" ORDER BY max_r_datetime DESC";
		$rs = $this->handler['confirm']->db->query($sql);
		if(!$rs || $this->handler['confirm']->db->getRowsNum($rs) < 1){
			return $ret;
		}
		
		while($row = $this->handler['confirm']->db->fetchArray($rs)){
			$mode = intval($row['mode']);
			if(defined('_MD_XSNS_INDEX_INFO_MSG_'.$mode)){
				$ret[] = array(
					'message' => sprintf(constant('_MD_XSNS_INDEX_INFO_MSG_'.$mode), $row['COUNT(*)']),
					'url' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=confirm#mode'.$mode,
					'time' => XsnsUtils::getUserTimestamp($row['max_r_datetime']),
				);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getIntroList($limit, $start=0, $order_by_rand=false)
	{
		$ret = array();
		
		$criteria = new CriteriaCompo(new Criteria('uid_to', $this->getVar('uid')));
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		if($order_by_rand){
			$criteria->setSort('RAND()');
		}
		else{
			$criteria->setSort('r_datetime');
			$criteria->setOrder('DESC');
		}
		$intro_obj_list =& $this->handler['intro']->getObjects($criteria);
		
		foreach($intro_obj_list as $intro_obj){
			if(!is_object($intro_obj)){
				continue;
			}
			$uid_from = $intro_obj->getVar('uid_from');
			$user_from =& $this->handler['user']->get($uid_from);
			if(!is_object($user_from)){
				continue;
			}
			$ret[] = array(
				'user_from' => $user_from->getInfo(),
				'body' => $intro_obj->getVar('body'),	// disallow XOOPS code
			);
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getIntroCount()
	{
		$criteria = new Criteria('uid_to', $this->getVar('uid'));
		$intro_obj_list =& $this->handler['intro']->getObjects($criteria);
		return count($intro_obj_list);
	}
	
	//--------------------------------------------------------------------------
	
	function &getMypageMenu($total_width = 600)
	{
		global $xoopsUser, $xoopsModuleConfig;
		
		$uid = $this->getVar('uid');
		$own_uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
		$own_user =& $this->handler['user']->get($own_uid);
		
		if($own_uid > 0 && $uid == $own_uid){
			$is_own_page = true;
			$is_friend_page = false;
		}
		else{
			$is_own_page = false;
			$is_friend_page = is_object($own_user) ? $own_user->isFriend($uid) : false;
		}
		
		$blog_module_mgr =& XsnsBlogModuleManager::getInstance();
		
		$ret = array();
		
		$ret['is_own_page'] = $is_own_page;
		$ret['is_friend_page'] = $is_friend_page;
		
		$ret['title'] = sprintf(_MD_XSNS_TITLE_MYPAGE_UNAME, $this->getVar('uname'));
		
		if($is_own_page){
			$ret['url'] = array(
				'home' => XSNS_URL_MYPAGE.'&uid='.$uid,
				'friend' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=friend_list&uid='.$uid,
				'blog' => sprintf($blog_module_mgr->getUserBlogUrl(), $uid),
				'news' => XSNS_URL_MYPAGE_NEWS.'&uid='.$uid,
				'footprint' => XSNS_URL_MYPAGE_FOOTPRINT,
				'profile' => XSNS_URL_MYPAGE_PROFILE,
			);
		}
		else{
			$ret['url'] = array(
				'home' => XSNS_URL_MYPAGE.'&uid='.$uid,
				'friend' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=friend_list&uid='.$uid,
				'blog' => sprintf($blog_module_mgr->getUserBlogUrl(), $uid),
				'news' => XSNS_URL_MYPAGE_NEWS.'&uid='.$uid,
			);
			
			if($is_friend_page){
				$ret['url']['intro'] = XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=intro_add&uid='.$uid;
			}
			else{
				$ret['url']['friend_add'] = XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=friend_add&uid='.$uid;
			}
		}
		
		$menu_count = count($ret['url']);
		
		if(!$xoopsModuleConfig['blog_module_name']){
			$menu_count--;
		}
		if($is_own_page && !$xoopsModuleConfig['use_footprint']){
			$menu_count--;
		}
		
		// Menu item width (last item width minimum = 120px)
		$ret['width'] = intval(($total_width-120)/($menu_count-1));
		$ret['width_large'] = ($ret['width'] >= 160) ? $ret['width'] : 120;
		
		return $ret;
	}
	
	//--------------------------------------------------------------------------
}

//******************************************************************************

class XsnsUserHandler extends XoopsUserHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsUserHandler()
	{
		$this->db =& Database::getInstance();
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsUserHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &get($uid)
	{
		$ret = false;
		if (intval($uid) > 0) {
			$sql = 'SELECT * FROM '.$this->db->prefix('users').' WHERE uid='.intval($uid);
			if ($result = $this->db->query($sql)) {
				if ($this->db->getRowsNum($result) == 1) {
					$user = new XsnsUser();
					$user->assignVars($this->db->fetchArray($result));
					$ret = $user;
				}
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
