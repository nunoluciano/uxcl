<?php
class Xsns_Join_View extends Xsns_Index_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_index_join.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$hidden = array('cid' => $commu['id']);
	
	$this->assignCommonVars();
	$this->assignStyleSheet('index.css');
	$this->assignFormHeader('form_commu_join', 'post', 'index', 'join_exec', false, $hidden, 'COMMUNITY_JOIN');
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => _MD_XSNS_TITLE_INDEX_JOIN),
	);
	
	$this->tpl->assign(array(
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
