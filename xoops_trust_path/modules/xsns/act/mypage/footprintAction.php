<?php
class Xsns_Footprint_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser, $xoopsModuleConfig;
	if($this->isGuest() || !$xoopsModuleConfig['use_footprint']){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$limit = 30;
	
	$own_uid = $xoopsUser->getVar('uid');
	$user_handler =& XsnsUserHandler::getInstance();
	$own_user =& $user_handler->get($own_uid);
	if(!is_object($own_user)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$footprint_handler =& XsnsFootprintHandler::getInstance();
	$footprint_list_temp =& $footprint_handler->getListForUser($own_uid, $limit);
	$footprint_count = $footprint_handler->getCountForUser($own_uid);
	
	$user_ids = array();
	foreach($footprint_list_temp as $footprint){
		$user_ids[] = $footprint['uid_from'];
	}
	if(count($user_ids) > 0){
		$user_ids = array_unique($user_ids);
		
		$criteria = new Criteria('uid', '('.implode(',',$user_ids).')', 'IN');
		$user_obj_list =& $user_handler->getObjects($criteria, true);
	}
	else{
		$user_obj_list = array();
	}
	
	$footprint_list = array();
	
	foreach($footprint_list_temp as $footprint){
		$uid = $footprint['uid_from'];
		$footprint_list[] = array(
			'uname' => isset($user_obj_list[$uid]) ? $user_obj_list[$uid]->getVar('uname') : "-",
			'url' => XSNS_URL_MYPAGE.'&uid='.$uid,
			'time' => $footprint['time'],
		);
	}
	
	$this->context->setAttribute('user_menu', $own_user->getMypageMenu());
	$this->context->setAttribute('user_name', $own_user->getVar('uname'));
	$this->context->setAttribute('footprint_list', $footprint_list);
	$this->context->setAttribute('footprint_count', $footprint_count);
}

}
?>
