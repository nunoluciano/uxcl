<?php
class Xsns_Del_View extends Xsns_Topic_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_topic_del.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$topic = $this->context->getAttribute('topic');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('topic.css');
	$this->assignFormHeader('form_topic_del', 'post', 'topic', 'del_exec', false,
		array('tcid' => $topic['tcid']), 'TOPIC_DELETE');
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => $topic['title'], 'url' => XSNS_URL_TOPIC.'&tid='.$topic['tid']),
		array('name' => $topic['lang_title']),
	);
	
	$this->tpl->assign(array(
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
