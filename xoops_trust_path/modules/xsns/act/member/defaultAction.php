<?php
class Xsns_Default_Action extends Xsns_Member_Action
{
function dispatch()
{
	$limit = 10;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
	if(!$cid){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティメンバー一覧の取得
	$c_member_obj_list =& $community->getMemberObjects($limit, $start);
	$c_member_list = array();
	foreach($c_member_obj_list as $c_member_obj){
		$c_member_list[] =& $c_member_obj->getInfo();
	}
	
	$pager = $this->getPageSelector(XSNS_URL_MEMBER.'&cid='.$cid, 
				$start, $limit, count($c_member_list), $community->getMemberCount());
	
	$commu_vars = array('id' => $cid, 'name' => $community->getVar('name'));
	
	$this->context->setAttribute('commu', $commu_vars);
	$this->context->setAttribute('member_list', $c_member_list);
	$this->context->setAttribute('pager', $pager);
}
}
?>
