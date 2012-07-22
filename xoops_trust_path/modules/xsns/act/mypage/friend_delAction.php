<?php

class Xsns_Friend_del_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$uid = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	if(!$uid){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$friend =& $user_handler->get($uid);
	$user =& $user_handler->get($xoopsUser->getVar('uid'));
	
	if(!is_object($user) || !is_object($friend)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$this->context->setAttribute('friend', $friend->getInfo());
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
}

}

?>