<?php
class Xsns_Intro_add_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$uid_from = $xoopsUser->getVar('uid');
	$uid_to = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	$user_handler =& XsnsUserHandler::getInstance();
	$user_to =& $user_handler->get($uid_to);
	if(!is_object($user_to) || !$user_to->isFriend($uid_from)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$criteria = new CriteriaCompo(new Criteria('uid_to', $uid_to));
	$criteria->add(new Criteria('uid_from', $uid_from));
	$intro_handler =& XsnsIntroductionHandler::getInstance();
	$intro_obj_list =& $intro_handler->getObjects($criteria);
	if(is_array($intro_obj_list) && count($intro_obj_list)>0){
		$body = $intro_obj_list[0]->getVar('body', 'e');
	}
	else{
		$body = "";
	}
	
	$this->context->setAttribute('uid_to', $uid_to);
	$this->context->setAttribute('body', $body);
	$this->context->setAttribute('user_menu', $user_to->getMypageMenu());
	$this->context->setAttribute('user_name', $user_to->getVar('uname'));
}

}
?>
