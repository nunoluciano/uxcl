<?php
class Xsns_Leave_exec_Action extends Xsns_Index_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('COMMUNITY_LEAVE')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$cid = $this->getIntRequest('cid');
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$perm = XSNS_AUTH_MEMBER | XSNS_AUTH_SUB_ADMIN;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority($perm)
	   || $community->getVar('uid_admin') == $own_uid){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 対象コミュニティメンバーの取得
	$c_member_handler =& XsnsMemberHandler::getInstance();
	$c_member =& $c_member_handler->getOne($cid, $own_uid);
	if(!is_object($c_member)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 退会処理
	if($c_member_handler->delete($c_member)){
		if($community->getVar('uid_sub_admin') == $own_uid){
			$community->setVar('uid_sub_admin', 0);
			$commu_handler->insert($community);
		}
		redirect_header(XSNS_URL_COMMU.'?cid='.$cid, 2, sprintf(_MD_XSNS_INDEX_LEAVE_OK, $community->getVar('name')));
	}
	redirect_header(XSNS_URL_COMMU, 2, _MD_XSNS_INDEX_LEAVE_NG);
}

}
?>
