<?php
class Xsns_Join_exec_Action extends Xsns_Index_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('COMMUNITY_JOIN')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$cid = $this->getIntRequest('cid');
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$perm = XSNS_AUTH_NON_MEMBER;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority($perm)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$public_flag = $community->getVar('public_flag');
	$is_public = true;
	$name = $community->getVar('name');
	$redirect_url = XSNS_URL_COMMU.'?cid='.$cid;
	
	if($public_flag > 1){
		// 参加の際に管理者の承認が必要なコミュニティ
		
		// 依頼送信済みかどうかの確認
		$uid_admin = $community->getVar('uid_admin');
		$confirm_handler =& XsnsConfirmHandler::getInstance();
		if($confirm_handler->getOne($cid, $own_uid, $uid_admin, 0)){
			redirect_header($redirect_url, 2, _MD_XSNS_INDEX_JOIN_REQ_NG_ALREADY);
		}
		
		// 依頼の送信
		$new_confirm =& $confirm_handler->create();
		$new_confirm->setVars(array(
			'c_commu_id' => $cid,
			'uid_from' => $own_uid,
			'uid_to' => $uid_admin,
			'mode' => 0,	// コミュニティ参加
			'r_datetime' => date('Y-m-d H:i:s'),
			'message' => $this->getTextRequest('message'),
		));
		
		if($confirm_handler->insert($new_confirm)){
			redirect_header($redirect_url, 2, sprintf(_MD_XSNS_INDEX_JOIN_REQ_OK, $name));
		}
		redirect_header($redirect_url, 2, _MD_XSNS_INDEX_JOIN_REQ_NG);
	}
	else{
		// 誰でも参加可能なコミュニティ
		
		$c_member_handler =& XsnsMemberHandler::getInstance();
		$new_member =& $c_member_handler->create();
		$new_member->setVars(array(
			'uid' => $own_uid,
			'c_commu_id' => $cid,
			'r_datetime' => date('Y-m-d H:i:s'),
		));
		
		if($c_member_handler->insert($new_member)){
			redirect_header($redirect_url, 2, sprintf(_MD_XSNS_INDEX_JOIN_OK, $name));
		}
		redirect_header($redirect_url, 2, _MD_XSNS_INDEX_JOIN_NG);
	}
}

}
?>
