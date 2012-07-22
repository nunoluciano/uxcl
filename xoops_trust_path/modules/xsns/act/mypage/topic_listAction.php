<?php
class Xsns_Topic_list_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$uid = $xoopsUser->getVar('uid');
	
	$limit = 30;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($uid);
	if(!is_object($user) || $user->getVar('level') < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$topic_list =& $user->getTopicList($limit, $start);
	$topic_count = $user->getTopicCount();
	
	$pager = $this->getPageSelector(XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=topic_list', 
						$start, $limit, count($topic_list), $topic_count);
	
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
	$this->context->setAttribute('topic_list', $topic_list);
	$this->context->setAttribute('pager', $pager);
}

}
?>
