<?php

class Xsns_Config_View extends Xsns_Mypage_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_config.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('config.css');
	$this->assignFormHeader('form_config', 'post', 'mypage', 'config_edit_exec', false, NULL, 'CONFIG_EDIT');
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
//------------------------------------------------------------------------------

}
?>
