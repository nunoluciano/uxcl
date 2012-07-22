<?php
class Xsns_Intro_del_exec_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	global $xoopsUser, $xoopsUserIsAdmin;
	if($this->isGuest() || !$this->validateToken('INTRO_DELETE')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$own_uid = $xoopsUser->getVar('uid');
	$uid_to = $this->getIntRequest('uid_to');
	$uid_from = $this->getIntRequest('uid_from');
	
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
	
	if($intro_handler->delete($intro_obj_list[0])){
		redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_MYPAGE_INTRO_DEL_OK);
	}
	redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_MYPAGE_INTRO_DEL_NG);
}
}
?>
