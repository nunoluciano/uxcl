<?php
class Xsns_Intro_del_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	global $xoopsUser, $xoopsUserIsAdmin;
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$own_uid = $xoopsUser->getVar('uid');
	$uid_to = $this->getIntRequest('uid_to', XSNS_REQUEST_GET);
	$uid_from = $this->getIntRequest('uid_from', XSNS_REQUEST_GET);
	
	if(!$uid_to || !$uid_from){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if(!$xoopsUserIsAdmin && $own_uid!=$uid_to && $own_uid!=$uid_from){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user_to =& $user_handler->get($uid_to);
	$user_from =& $user_handler->get($uid_from);
	if(!is_object($user_to) || !is_object($user_from)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$criteria = new CriteriaCompo(new Criteria('uid_to', $uid_to));
	$criteria->add(new Criteria('uid_from', $uid_from));
	$intro_handler =& XsnsIntroductionHandler::getInstance();
	$intro_obj_list =& $intro_handler->getObjects($criteria);
	if(!is_array($intro_obj_list) || count($intro_obj_list)!=1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$intro = array(
		'user_from' => $user_from->getInfo(),
		'body' => $intro_obj_list[0]->getVar('body'),
	);
	
	$this->context->setAttribute('intro', $intro);
	$this->context->setAttribute('user_menu', $user_to->getMypageMenu());
	$this->context->setAttribute('uid_to', $uid_to);
	$this->context->setAttribute('uid_from', $uid_from);
}
}
?>
