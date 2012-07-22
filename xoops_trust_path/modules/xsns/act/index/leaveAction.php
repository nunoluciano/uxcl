<?php
class Xsns_Leave_Action extends Xsns_Index_Action
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
	$perm = XSNS_AUTH_MEMBER | XSNS_AUTH_SUB_ADMIN;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority($perm)
	   || $community->getVar('uid_admin') == $own_uid){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu = array(
		'id' => $cid,
		'name' => $community->getVar('name'),
	);
	$this->context->setAttribute('commu', $commu);
}

}
?>
