<?php

class Xsns_Friend_add_exec_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('FRIEND_ADD')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$uid = $this->getIntRequest('uid');
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
	
	$message = $this->getTextRequest('message');
	
	$confirm_handler =& XsnsConfirmHandler::getInstance();
	$confirm =& $confirm_handler->getOne(0, $own_uid, $uid, 3);
	if(!is_object($confirm)){
		$confirm =& $confirm_handler->create();
	}
	$confirm->setVars(array(
		'uid_from' => $own_uid,
		'uid_to' => $uid,
		'mode' => 3,
		'r_datetime' => date('Y-m-d H:i:s'),
		'message' => $message,
	));
	
	if($confirm_handler->insert($confirm)){
		redirect_header(XSNS_URL_MYPAGE, 2, 
						sprintf(_MD_XSNS_FRIEND_ADD_OK, $target_user->getVar('uname')));
	}
	redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_FRIEND_ADD_NG);
}
//------------------------------------------------------------------------------

}

?>