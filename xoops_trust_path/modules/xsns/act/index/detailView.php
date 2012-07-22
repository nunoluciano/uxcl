<?php
class Xsns_Detail_View extends Xsns_Index_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_index_detail.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('index.css');
	
	$commu = $this->context->getAttribute('commu');
	
	$url = array(
		'all_topic' => XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=list&cid='.$commu['id'],
		'add_topic' => XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=add&cid='.$commu['id'],
		'commu_config' => XSNS_URL_COMMU.'?'.XSNS_ACTION_ARG.'=edit&cid='.$commu['id'],
		'all_member' => XSNS_URL_MEMBER.'&cid='.$commu['id'],
		'member_config' => XSNS_URL_MEMBER.'&'.XSNS_ACTION_ARG.'=edit&cid='.$commu['id'],
		'commu_join' => XSNS_URL_COMMU.'?'.XSNS_ACTION_ARG.'=join&cid='.$commu['id'],
		'commu_leave' => XSNS_URL_COMMU.'?'.XSNS_ACTION_ARG.'=leave&cid='.$commu['id'],
	);
	
	$breadcrumbs = array(
		array('name' => $commu['name']),
	);
	
	$this->tpl->assign(array(
		'commu' => $commu,
		'url' => $url,
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
