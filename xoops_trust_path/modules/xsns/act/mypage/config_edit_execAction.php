<?php

class Xsns_Config_edit_exec_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('CONFIG_EDIT')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$own_uid = $xoopsUser->getVar('uid');
	
	$config_arr = $this->getConfigArray();
	if(!is_array($config_arr)){
		redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_CONFIG_CHANGE_NG);
	}
	
	$module_config_handler =& XsnsModuleConfigHandler::getInstance();
	$module_config =& $module_config_handler->getOne($own_uid);
	if(!is_object($module_config)){
		$module_config =& $module_config_handler->create();
		$module_config->setVar('uid', $own_uid);
	}
	$module_config->setVar('config_values', $config_arr);
	
	if($module_config_handler->insert($module_config)){
		redirect_header(XSNS_URL_MYPAGE_NEWS.'&uid='.$own_uid, 2, _MD_XSNS_CONFIG_CHANGE_OK);
	}
	redirect_header(XSNS_URL_MYPAGE, 2, _MD_XSNS_CONFIG_CHANGE_NG);
}
//------------------------------------------------------------------------------

function getConfigArray()
{
	$mid = isset($_POST['mid'])? $_POST['mid'] : NULL;
	$oid = isset($_POST['order'])? $_POST['order'] : NULL;
	$view = isset($_POST['view'])? $_POST['view'] : NULL;
	
	if(!is_array($mid) || !is_array($oid) || !is_array($view)){
		return NULL;
	}
	
	$m_count = count($mid);
	$o_count = count($oid);
	$v_count = count($view);
	
	if($m_count!=$o_count || $m_count!=$v_count){
		return NULL;
	}
	
	$temp_array = array();
	$config_array = array();
	
	for($i=0; $i<$m_count; $i++){
		$mid[$i] = intval($mid[$i]);
		$oid[$i] = intval($oid[$i]);
		$view[$i] = intval($view[$i]);
		
		if($oid[$i]<0 || $oid[$i]>100){
			$oid[$i] = 0;
		}
		if($view[$i]<0 || $view[$i]>100){
			$view[$i] = 0;
		}
		
		$order_value[$mid[$i]] = $oid[$i];
		
		$temp_array[$mid[$i]] = array($oid[$i], $view[$i]);
	}
	asort($order_value);
	
	foreach($order_value as $key => $value){
		$config_array[$key] = $temp_array[$key];
	}
	return $config_array;
}

}

?>