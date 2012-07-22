<?php
class Xsns_Blog_list_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$limit = 30;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($own_uid);
	if(!is_object($user) || $user->getVar('level') < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$blog_list =& $user->getFriendBlogList($limit, $start, &$blog_count);
	
	$pager = $this->getPageSelector(XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=blog_list', 
						$start, $limit, count($blog_list), $blog_count);
	
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
	$this->context->setAttribute('blog_list', $blog_list);
	$this->context->setAttribute('pager', $pager);
}

}
?>
