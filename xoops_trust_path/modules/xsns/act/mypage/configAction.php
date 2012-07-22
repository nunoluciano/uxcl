<?php

class Xsns_Config_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($xoopsUser->getVar('uid'));
	if(!is_object($user)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
	$this->context->setAttribute('module_list', $user->getModuleList(false));
}

}

?>