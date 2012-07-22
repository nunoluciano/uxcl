<?php
class Xsns_News_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	if(!$this->checkPermissionForGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : -1;
	$uid = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	if(!isset($uid)){
		$uid = $own_uid;
	}
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($uid);
	if(!is_object($user)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$is_own_page = ($own_uid==$uid && $own_uid>0) ? true : false;
	
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
	$this->context->setAttribute('module_list', $user->getModuleList());
	$this->context->setAttribute('is_own_page', $is_own_page);
}
//------------------------------------------------------------------------------

}
?>
