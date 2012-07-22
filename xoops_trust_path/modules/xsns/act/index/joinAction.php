<?php
class Xsns_Join_Action extends Xsns_Index_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
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
	
	if($public_flag > 1){
		$is_public = false;
		
		// 依頼送信済みかどうかの確認
		$uid_admin = $community->getVar('uid_admin');
		$confirm_handler =& XsnsConfirmHandler::getInstance();
		if($confirm_handler->getOne($cid, $own_uid, $uid_admin, 0)){
			redirect_header(XSNS_URL_COMMU.'?cid='.$cid, 2, _MD_XSNS_INDEX_JOIN_REQ_NG_ALREADY);
		}
	}
	
	$commu = array(
		'id' => $cid, 
		'name' => $community->getVar('name'), 
		'is_public' => $is_public,
	);
	$this->context->setAttribute('commu', $commu);
}
}
?>
