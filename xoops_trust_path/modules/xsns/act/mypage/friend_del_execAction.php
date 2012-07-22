<?php

class Xsns_Friend_del_exec_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('FRIEND_DELETE')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$uid = $this->getIntRequest('uid');
	if(!$uid){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($own_uid);
	$friend =& $user_handler->get($uid);
	$friend_name = is_object($friend) ? $friend->getVar('uname') : "";
	
	if(is_object($user) && is_object($friend) && $user->unsetFriend($uid)){
		
		// 猴近した惠を流慨
		$confirm_handler =& XsnsConfirmHandler::getInstance();
		$new_confirm =& $confirm_handler->create();
		$new_confirm->setVars(array(
			'uid_from' => $own_uid,
			'uid_to' => $uid,
			'mode' => 4,
			'r_datetime' => date('Y-m-d H:i:s'),
		));
		$confirm_handler->insert($new_confirm);
		
		// 高いの疽拆矢を猴近
		$intro_handler =& XsnsIntroductionHandler::getInstance();
		$criteria1 = new CriteriaCompo(new Criteria('uid_to', $own_uid));
		$criteria1->add(new Criteria('uid_from', $uid));
		$criteria2 = new CriteriaCompo(new Criteria('uid_to', $uid));
		$criteria2->add(new Criteria('uid_from', $own_uid));
		$criteria1->add($criteria2, 'OR');
		$intro_handler->deleteObjects($criteria1);
		
		redirect_header(XSNS_URL_MYPAGE, 2, sprintf(_MD_XSNS_FRIEND_DELETE_OK, $friend_name));
	}
	redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_FRIEND_DELETE_NG);
}

}

?>