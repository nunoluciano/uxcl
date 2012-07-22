<?php

require_once 'root.class.php';

define('XSNS_MOD_CONFIG_ORDER', 0);
define('XSNS_MOD_CONFIG_VIEW', 1);

//******************************************************************************

class XsnsModuleConfig extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsModuleConfig()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('config_id', XOBJ_DTYPE_INT);
		$this->initVar('uid', XOBJ_DTYPE_INT);
		$this->initVar('config_values', XOBJ_DTYPE_ARRAY);
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsModuleConfigHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsModuleConfigHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsModuleConfig";
		$this->table_name = "c_mypage_config";
		$this->primary_key = "config_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsModuleConfigHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getOne($uid)
	{
		$ret = NULL;
		$obj_list =& $this->getObjects(new Criteria('uid', $uid));
		if(is_array($obj_list) && isset($obj_list[0]) && is_object($obj_list[0])){
			$ret =& $obj_list[0];
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getList($uid, $view_mode=true)
	{
		global $xoopsUser;
		
		$ret = array();
		
		$ts =& XsnsTextSanitizer::getInstance();
		$gperm_handler =& xoops_gethandler('groupperm');
		$module_handler =& xoops_gethandler('module');
		$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		
		// モジュール表示順設定の取得
		$module_config =& $this->getOne($uid);
		if(is_object($module_config)){
			$config_arr = $module_config->getVar('config_values');
			if(!is_array($config_arr)){
				$config_arr = array();
			}
		}
		else{
			$config_arr = array();
		}
		
		$default_image = XOOPS_URL.'/images/icons/posticon2.gif';
		
		$order_max = 1;
		
		$criteria = new CriteriaCompo(new Criteria('hassearch', 1));
		$criteria->add(new Criteria('isactive', 1));
		$mids =& array_keys($module_handler->getList($criteria));
		$checked = array();
		
		// DBに登録されている設定順でモジュールを表示
		foreach($config_arr as $mid => $config){
			if(!isset($config[XSNS_MOD_CONFIG_ORDER]) || !isset($config[XSNS_MOD_CONFIG_VIEW])){
				continue;
			}
			
			$checked[$mid] = true;
			
			if($view_mode && ($config[XSNS_MOD_CONFIG_VIEW] < 1)){
				continue;
			}
			$module =& $module_handler->get($mid);
			if(!$module || !in_array($mid, $mids) || !$gperm_handler->checkRight('module_read', $mid, $groups)){
				continue;
			}
			
			$module_dir = $module->getVar('dirname');
			$module_url = XOOPS_URL.'/modules/'.$module_dir.'/';
			$results =& $module->search('', '', $config[XSNS_MOD_CONFIG_VIEW], 0, $uid);
			$count = is_array($results)? count($results) : 0;
			
			if(($view_mode && $count>0) || !$view_mode){
				for ($i = 0; $i < $count; $i++) {
					if (isset($results[$i]['image']) && $results[$i]['image'] != '') {
						$results[$i]['image'] = $module_url. $results[$i]['image'];
					}
					else {
						$results[$i]['image'] = $default_image;
					}
					$results[$i]['link'] = $module_url. $results[$i]['link'];
					$results[$i]['title'] = $ts->makeTboxData4Show($results[$i]['title']);
					$results[$i]['time'] = $results[$i]['time'] ? date("Y-m-d H:i:s", $results[$i]['time']) : '';
				}
				$ret[$mid] = array(
					'id' => $mid,
					'order' => intval($config[XSNS_MOD_CONFIG_ORDER]),
					'view' => intval($config[XSNS_MOD_CONFIG_VIEW]),
					'name' => $module->getVar('name'),
					'url' => $module_url,
					'results' => $results,
				);
				$order_max = intval($config[XSNS_MOD_CONFIG_ORDER]);
			}
			unset($module, $results);
		}
		
		// DBに未登録のモジュールを追加表示
		foreach($mids as $mid) {
			if(isset($checked[$mid]) || !$gperm_handler->checkRight('module_read', $mid, $groups)) {
				continue;
			}
			
			$module =& $module_handler->get($mid);
			if(!$module){
				continue;
			}
			
			$module_dir = $module->getVar('dirname');
			$module_url = XOOPS_URL.'/modules/'.$module_dir.'/';
			
			$results =& $module->search('', '', 5, 0, $uid);
			$count = is_array($results)? count($results) : 0;
			
			if(($view_mode && $count > 0) || !$view_mode){
				for ($i = 0; $i < $count; $i++) {
					if (isset($results[$i]['image']) && $results[$i]['image'] != '') {
						$results[$i]['image'] = $module_url. $results[$i]['image'];
					}
					else {
						$results[$i]['image'] = $default_image;
					}
					$results[$i]['link'] = $module_url. $results[$i]['link'];
					$results[$i]['title'] = $ts->makeTboxData4Show($results[$i]['title']);
					$results[$i]['time'] = $results[$i]['time'] ? date("Y-m-d H:i:s", $results[$i]['time']) : '';
				}
				$ret[$mid] = array(
					'id' => $mid,
					'order' => $order_max,
					'view' => 5,
					'name' => $module->getVar('name'),
					'url' => $module_url,
					'results' => $results,
				);
			}
			unset($module, $results);
		}
		return $ret;
	}
	
}

//******************************************************************************

?>
