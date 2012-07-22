<?php

class Xsns_Friend_add_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$uid = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	$own_uid = $xoopsUser->getVar('uid');
	if(!$uid || $uid == $own_uid){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$own_user =& $user_handler->get($own_uid);
	$target_user =& $user_handler->get($uid);
	if(!is_object($own_user) || !is_object($target_user) || $own_user->isFriend($uid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$this->context->setAttribute('user', $target_user->getInfo());
	$this->context->setAttribute('user_menu', $target_user->getMypageMenu());
}

}

?>