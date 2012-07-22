<?php
class Xsns_Edit_View extends Xsns_Index_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_index_edit.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$public_flag = $this->context->getAttribute('public_flag');
	$commu = $this->context->getAttribute('commu');
	$hidden = array('cid' => $commu['id']);
	
	$this->assignCommonVars();
	$this->assignHeader('index.css');
	
	$this->assignFormHeader('form_commu_edit', 'post', 'index', 'edit_exec', true, $hidden, 'COMMUNITY_EDIT');
	$this->assignFormHeader('form_commu_del', 'get', 'index', 'del', false, $hidden);
	
	$this->assignXoopsCodeTarea($commu['info'], 'info', 60, 15);
	
	$this->context->assignAttributes();
	
	$public = array(
		'checked'.$public_flag => 'checked',
	);
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => _MD_XSNS_TITLE_INDEX_EDIT),
	);
	
	$this->tpl->assign(array(
		'public' => $public,
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
