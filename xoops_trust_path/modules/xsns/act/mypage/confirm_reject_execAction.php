<?php
class Xsns_Confirm_reject_exec_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	global $xoopsUser;
	
	$confirm_id = $this->getIntRequest('confirm_id');
	if($confirm_id < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if($this->isGuest() || !$this->validateToken('CONFIRM_REJECT_ID'.$confirm_id)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 依頼情報の取得
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
	
	// ユーザーの取得（依頼者が存在しなくても処理を続行）
	$user_handler =& XsnsUserHandler::getInstance();
	$user_to =& $user_handler->get($uid_to);
	if(!is_object($user_to)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if($mode < 3){
		// コミュニティの取得
		$commu_handler =& XsnsCommunityHandler::getInstance();
		$community =& $commu_handler->get($cid);
		if(!is_object($community) || $community->getAuthority() < XSNS_AUTH_MEMBER){
			redirect_header(XOOPS_URL, 2, _NOPERM);
		}
	}
	
	// 依頼の削除
	if($confirm_handler->delete($confirm)){
		$url = ($confirm_handler->getCount(new Criteria('uid_to', $uid_to)) > 0) ?
			XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=confirm' : XSNS_URL_MYPAGE;
		redirect_header($url, 2, sprintf(_MD_XSNS_CONFIRM_REJECT_OK, $user_to->getVar('uname')));
	}
	redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_CONFIRM_REJECT_NG);
}

}
?>
