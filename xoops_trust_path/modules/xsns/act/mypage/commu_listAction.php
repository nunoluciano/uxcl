<?php
class Xsns_Commu_list_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	global $xoopsUser;
	
	if(!$this->checkPermissionForGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$limit = 10;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$uid = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	if(!isset($uid) || $uid < 0){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 対象ユーザーの取得
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($uid);
	if(!is_object($user) || $user->getVar('level') < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_list_temp = $user->getCommunityList($limit, $start);
	
	$commu_count = count($commu_list_temp);
	$commu_count_mod = 5 - $commu_count % 5;
	$count = ($commu_count_mod < 5) ? $commu_count + $commu_count_mod : $commu_count;
	
	$commu_list = array();
	for($i=0; $i<$count; $i++){
		$commu_list[] = isset($commu_list_temp[$i]) ? $commu_list_temp[$i] : array('exists' => false);
	}
	
	$pager = $this->getPageSelector(XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=commu_list&uid='.$uid, 
						$start, $limit, $commu_count, $user->getCommunityCount());
	
	$this->context->setAttribute('pager', $pager);
	$this->context->setAttribute('user_name', $user->getVar('uname'));
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
	$this->context->setAttribute('commu_list', $commu_list);
}
//------------------------------------------------------------------------------

}
?>
