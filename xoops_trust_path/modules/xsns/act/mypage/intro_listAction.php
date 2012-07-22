<?php
class Xsns_Intro_list_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	global $xoopsUser, $xoopsUserIsAdmin;
	if(!$this->checkPermissionForGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$limit = 10;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!$start){
		$start = 0;
	}
	$uid_to = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	$uid_from = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : -1;
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user_to =& $user_handler->get($uid_to);
	if(!is_object($user_to) || $user_to->getVar('level') < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$intro_list =& $user_to->getIntroList($limit, $start);
	$intro_count = $user_to->getIntroCount();
	
	$pager = $this->getPageSelector(XSNS_URL_MYPAGE_INTRO.'&uid='.$uid_to, 
						$start, $limit, count($intro_list), $intro_count);
	
	$this->context->setAttribute('intro_list', $intro_list);
	$this->context->setAttribute('intro_count', $intro_count);
	$this->context->setAttribute('pager', $pager);
	$this->context->setAttribute('user_menu', $user_to->getMypageMenu());
	$this->context->setAttribute('uid_to', $uid_to);
	$this->context->setAttribute('uid_from', $uid_from);
	$this->context->setAttribute('is_xoops_admin', $xoopsUserIsAdmin);
}
}
?>
