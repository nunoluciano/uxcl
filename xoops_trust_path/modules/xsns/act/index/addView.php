<?php
class Xsns_Add_View extends Xsns_Index_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_index_add.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignHeader('index.css');
	$this->assignFormHeader('form_commu_add', 'post', 'index', 'add_confirm', true);
	
	$default = $this->context->getAttribute('default');
	$this->assignXoopsCodeTarea($default['info'], 'info', 60, 15);
	
	$breadcrumbs = array(
		array('name' => _MD_XSNS_TITLE_INDEX_ADD),
	);
	
	$this->tpl->assign(array(
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
