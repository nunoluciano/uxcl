<?php
class Xsns_Del_View extends Xsns_Index_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_index_del.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('index.css');
	$this->assignFormHeader('form_commu_del', 'post', 'index', 'del_exec', false, 
		array('cid' => $commu['id']), 'COMMUNITY_DELETE');
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => _MD_XSNS_TITLE_INDEX_DEL),
	);
	
	$this->tpl->assign(array(
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
