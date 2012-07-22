<?php
class Xsns_Commu_list_View extends Xsns_Mypage_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_commu_list.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	$commu_list = $this->context->getAttribute('commu_list');
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}

}
?>
