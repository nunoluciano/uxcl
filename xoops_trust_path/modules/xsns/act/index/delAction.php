<?php
class Xsns_Del_Action extends Xsns_Index_Action
{
function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$perm = XSNS_AUTH_XOOPS_ADMIN | XSNS_AUTH_ADMIN;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority($perm) || $community->getTopicCount() > 0){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_data = array(
		'id' => $cid,
		'name' => $community->getVar('name'),
		'info' => $community->getVar('info'),
	);
	$this->context->setAttribute('commu', $commu_data);
}
}
?>
