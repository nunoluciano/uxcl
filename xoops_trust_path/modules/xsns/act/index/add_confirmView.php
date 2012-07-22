<?php
class Xsns_Add_confirm_View extends Xsns_Index_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_index_add_confirm.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('index.css');
	$this->assignFormHeader('form_commu_add_submit', 'post', 'index', 'add_exec', false, NULL, 'COMMUNITY_ADD');
	
	$breadcrumbs = array(
		array('name' => _MD_XSNS_TITLE_INDEX_ADD),
	);
	
	$this->tpl->assign(array(
		'url_modify' => XSNS_URL_COMMU.'?'.XSNS_ACTION_ARG.'=add',
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
