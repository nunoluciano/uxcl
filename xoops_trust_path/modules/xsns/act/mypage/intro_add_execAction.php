<?php
class Xsns_Intro_add_exec_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	if($this->isGuest() || !$this->validateToken('INTRO_ADD')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$uid_from = $xoopsUser->getVar('uid');
	$uid_to = $this->getIntRequest('uid_to');
	$body = $this->getTextRequest('body');
	
	if(!$body){
		redirect_header(XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=intro_add&uid='.$uid_to, 2, _MD_XSNS_MYPAGE_INTRO_ADD_BODY_NG);
	}
	
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
		$intro =& $intro_obj_list[0];
	}
	else{
		$intro =& $intro_handler->create();
	}
	
	$intro->setVars(array(
		'uid_to' => $uid_to,
		'uid_from' => $uid_from,
		'body' => $body,
		'r_datetime' => date("Y-m-d H:i:s"),
	));
	if($intro_handler->insert($intro)){
		redirect_header(XSNS_URL_MYPAGE.'&uid='.$uid_to, 2, _MD_XSNS_MYPAGE_INTRO_ADD_OK);
	}
	redirect_header(XSNS_URL_MYPAGE.'&uid='.$uid_to, 2, _MD_XSNS_MYPAGE_INTRO_ADD_NG);
}

}
?>
