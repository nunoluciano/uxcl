<?php
class Xsns_Request_Action extends Xsns_Member_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$cid = $this->getIntRequest('cid');
	$uid = $this->getIntRequest('uid');
	$mode = $this->getIntRequest('mode');
	if(!$cid || !$uid || $mode < 0 || $mode > 2 || $uid == $own_uid){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$perm = XSNS_AUTH_XOOPS_ADMIN | XSNS_AUTH_ADMIN;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority($perm)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 対象コミュニティメンバーの取得
	$c_member_handler =& XsnsMemberHandler::getInstance();
	$c_member =& $c_member_handler->getOne($cid, $uid);
	if(!is_object($c_member)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_vars = array('id' => $cid, 'name' => $community->getVar('name'));
	
	$this->context->setAttribute('commu', $commu_vars);
	$this->context->setAttribute('member', $c_member->getInfo());
	$this->context->setAttribute('mode', $mode);
}

}
?>
