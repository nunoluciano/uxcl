<?php
class Xsns_List_Action extends Xsns_Topic_Action
{

function dispatch()
{
	$limit = 10;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_auth = $community->getAuthority();
	if($community->getVar('public_flag') == 3 && $commu_auth < XSNS_AUTH_MEMBER){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 新着トピック一覧の取得
	$topic_list =& $community->getTopicList($limit, $start, true);
	
	$pager = $this->getPageSelector(XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=list&cid='.$cid, 
				$start, $limit, count($topic_list), $community->getTopicCount());
	
	$commu_vars = array('id' => $cid, 'name' => $community->getVar('name'));
	
	$this->context->setAttribute('commu', $commu_vars);
	$this->context->setAttribute('topic_list', $topic_list);
	$this->context->setAttribute('pager', $pager);
}

}
?>
