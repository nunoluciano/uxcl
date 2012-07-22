<?php
class Xsns_Confirm_accept_exec_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	global $xoopsUser;
	
	$confirm_id = $this->getIntRequest('confirm_id');
	if($confirm_id < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if($this->isGuest() || !$this->validateToken('CONFIRM_ACCEPT_ID'.$confirm_id)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// �������μ���
	$confirm_handler =& XsnsConfirmHandler::getInstance();
	$confirm =& $confirm_handler->get($confirm_id);
	if(!is_object($confirm)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$cid = $confirm->getVar('c_commu_id');
	$uid_from = $confirm->getVar('uid_from');
	$uid_to = $confirm->getVar('uid_to');
	$mode = $confirm->getVar('mode');
	
	if($uid_to != $xoopsUser->getVar('uid')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// �桼�����μ���
	$user_handler =& XsnsUserHandler::getInstance();
	$user_from =& $user_handler->get($uid_from);	// ����ԡ�¾�͡�
	$user_to =& $user_handler->get($uid_to);		// ��ʬ
	if(!is_object($user_from) || !is_object($user_to)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if($mode < 3){
		// ���ߥ�˥ƥ��μ���
		$commu_handler =& XsnsCommunityHandler::getInstance();
		$community =& $commu_handler->get($cid);
		if(!is_object($community) || $community->getAuthority() < XSNS_AUTH_MEMBER){
			redirect_header(XOOPS_URL, 2, _NOPERM);
		}
	}
	
	switch($mode){
		case 0:	// ���ߥ�˥ƥ�����
			$ret = $user_from->joinCommunity($cid);
			$msg = _MD_XSNS_CONFIRM_JOIN;
			break;
		
		case 1:	// �����Ը���
			$ret = $user_to->setCommunityAdmin($cid);
			$msg = _MD_XSNS_CONFIRM_ADMIN;
			break;
		
		case 2:	// �������Խ�Ǥ
			$ret = $user_to->setCommunitySubAdmin($cid);
			$msg = _MD_XSNS_CONFIRM_SUB_ADMIN;
			break;
		
		case 3:	// ͧã�ꥹ����Ͽ
			$ret1 = $user_to->setFriend($uid_from);
			$ret2 = $user_from->setFriend($uid_to);
			$ret = $ret1 | $ret2;
			$msg = _MD_XSNS_CONFIRM_FRIEND;
			break;
		
		case 4:	// ͧã�ꥹ����Ͽ����ʳ�ǧ�Τߡ�
			if($confirm_handler->delete($confirm)){
				header("Location: ".XSNS_URL_MYPAGE);
				exit;
			}
			redirect_header(XOOPS_URL, 2, _NOPERM);
			break;
			
		default:
			redirect_header(XOOPS_URL, 2, _NOPERM);
			break;
	}
	
	if($ret && $confirm_handler->delete($confirm)){
		$url = ($confirm_handler->getCount(new Criteria('uid_to', $uid_to)) > 0) ?
			XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=confirm' : XSNS_URL_MYPAGE;
		redirect_header($url, 2, sprintf(_MD_XSNS_CONFIRM_ACCEPT_OK. $msg, $user_from->getVar('uname')));
	}
	redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_CONFIRM_ACCEPT_NG);
}

}
?>
