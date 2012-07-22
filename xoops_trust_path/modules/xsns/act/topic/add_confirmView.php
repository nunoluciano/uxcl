<?php
class Xsns_Add_confirm_View extends Xsns_Topic_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_topic_add_confirm.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$topic = $this->context->getAttribute('topic');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('topic.css');
	$this->assignFormHeader('form_topic_add_submit', 'post', 'topic', 'add_exec', false, 
		array('cid' => $commu['id']), 'TOPIC_ADD');
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => _MD_XSNS_TITLE_TOPIC_ADD),
	);
	
	$this->tpl->assign(array(
		'url_modify' => XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=add&cid='.$commu['id'],
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
