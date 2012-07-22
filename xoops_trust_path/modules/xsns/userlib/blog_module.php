<?php

class XsnsBlogModuleManager
{
	var $module_dirname = NULL;
	var $user_blog_url = NULL;
	
	function XsnsBlogModuleManager()
	{
		global $xoopsModuleConfig;
		
		switch($xoopsModuleConfig['blog_module_name']){
			case 0:
			default:
				$default_dirname = NULL;
				$user_url = NULL;
				break;
			
			case 1: // weblog
				$default_dirname = 'weblog';
				$user_url = 'index.php?user_id=%d';
				break;
			
			case 2: // weblog D3
				$default_dirname = 'weblogD3';
				$user_url = 'index.php?user_id=%d';
				break;
			
			case 3: // WordPress ME
				$default_dirname = 'wordpress';
				$user_url = 'index.php?author=%d';
				break;
			
			case 4: // d3blog
				$default_dirname = 'd3blog';
				$user_url = 'index.php?uid=%d';
				break;
			
			case 5: // minidiary
				$default_dirname = 'minidiary';
				$user_url = 'index.php?req_uid=%d';
				break;
		}
		
		if(!empty($default_dirname) && !empty($user_url)){
			$this->module_dirname = empty($xoopsModuleConfig['blog_module_dir'])?
				$default_dirname : $xoopsModuleConfig['blog_module_dir'];
			
			$this->user_blog_url = XOOPS_URL.'/modules/'.$this->module_dirname.'/'.$user_url;
		}
	}

	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsBlogModuleManager();
		}
		return $instance;
	}

	function &getModule()
	{
		global $xoopsUser;
		$ret = NULL;
		
		if(empty($this->module_dirname) || empty($this->user_blog_url)){
			return $ret;
		}
		
		$criteria = new CriteriaCompo(new Criteria('hassearch', 1));
		$criteria->add(new Criteria('isactive', 1));
		$criteria->add(new Criteria('dirname', $this->module_dirname));
		$module_handler =& xoops_gethandler('module');
		$blog_module_list =& $module_handler->getList($criteria);
		if(count($blog_module_list) != 1){
			return $ret;
		}
		
		$blog_module =& $module_handler->getByDirName($this->module_dirname);
		if(!is_object($blog_module) || strtolower(get_class($blog_module))!='xoopsmodule'){
			return $ret;
		}
		
		$gperm_handler =& xoops_gethandler('groupperm');
		$groups = is_object($xoopsUser)? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		
		if($gperm_handler->checkRight('module_read', $blog_module->getVar('mid'), $groups)) {
			$ret =& $blog_module;
		}
		return $ret;
	}

	function getModuleDirName()
	{
		return $this->module_dirname;
	}

	function getUserBlogUrl()
	{
		return $this->user_blog_url;
	}
	
	function &getMyBlogList($uid, $limit, $start, &$blog_count)
	{
		$ts =& XsnsTextSanitizer::getInstance();
		$ret = array();
		$blog_module =& $this->getModule();
		
		if(is_null($blog_module)){
			return $ret;
		}
		
		$user_blog_url = $this->getUserBlogUrl();
		$module_url = XOOPS_URL.'/modules/'.$this->getModuleDirName();
		
		$blog_list_temp = $order = array();
		$blog_count = 0;
		
		$user_handler =& XsnsUserHandler::getInstance();
		$user =& $user_handler->get($uid);
		if(!is_object($user)){
			return $ret;
		}
		$uname = $user->getVar('uname');
		
		$results =& $blog_module->search('', '', 0, 0, $uid);
		if (!is_array($results) || count($results) == 0) {
			return $ret;
		}
		
		foreach($results as $result){
			if(isset($result['image']) && $result['image'] != ''){
				$image_url = $module_url.'/'.$result['image'];
			}
			else{
				$image_url = XOOPS_URL.'/images/icons/posticon2.gif';
			}
			$blog_list_temp[] = array(
				'image' => $image_url,
				'link' => $module_url.'/'.$result['link'],
				'link_author' => sprintf($user_blog_url, $uid),
				'title' => $ts->makeTboxData4Preview($result['title']),
				'time' => isset($result['time'])? date("Y-m-d H:i:s", $result['time']) : '',
				'author' => $uname,
			);
			$order[$blog_count] = isset($result['time'])? $result['time'] : 0;
			$blog_count++;
		}
		
		if($start < 0){
			$start = 0;
		}
		
		if(count($order) > 0){
			arsort($order);
			$count = 0;
			foreach($order as $key => $value){
				if($count>=$start && $count<$start+$limit){
					$ret[] = $blog_list_temp[$key];
				}
				$count++;
			}
		}
		return $ret;
	}
	
	
	function &getFriendBlogList($uid, $limit, $start, &$blog_count)
	{
		$ts =& XsnsTextSanitizer::getInstance();
		$ret = array();
		$blog_module =& $this->getModule();
		
		if(is_null($blog_module)){
			return $ret;
		}
		
		$user_blog_url = $this->getUserBlogUrl();
		$module_url = XOOPS_URL.'/modules/'.$this->getModuleDirName();
		
		$user_handler =& XsnsUserHandler::getInstance();
		$user =& $user_handler->get($uid);
		if(!is_object($user)){
			return $ret;
		}
		
		$friend_list =& $user->getFriendList();
		$blog_list_temp = $order = array();
		$blog_count = 0;
		
		foreach($friend_list as $friend){
			$results =& $blog_module->search('', '', 0, 0, $friend['uid']);
			if (!is_array($results) || count($results) == 0) {
				continue;
			}
			
			foreach($results as $result){
				if(isset($result['image']) && $result['image'] != ''){
					$image_url = $module_url.'/'.$result['image'];
				}
				else{
					$image_url = XOOPS_URL.'/images/icons/posticon2.gif';
				}
				$blog_list_temp[] = array(
					'image' => $image_url,
					'link' => $module_url.'/'.$result['link'],
					'link_author' => sprintf($user_blog_url, $friend['uid']),
					'title' => $ts->makeTboxData4Preview($result['title']),
					'time' => isset($result['time'])? date("Y-m-d H:i:s", $result['time']) : '',
					'author' => $friend['name'],
				);
				$order[$blog_count] = isset($result['time'])? $result['time'] : 0;
				$blog_count++;
			}
			unset($results);
		}
		
		if($start < 0){
			$start = 0;
		}
		
		if(count($order) > 0){
			arsort($order);
			$count = 0;
			foreach($order as $key => $value){
				if($count>=$start && $count<$start+$limit){
					$ret[] = $blog_list_temp[$key];
				}
				$count++;
			}
		}
		return $ret;
	}
}
?>
