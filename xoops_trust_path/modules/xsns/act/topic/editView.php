<?php
class Xsns_Edit_View extends Xsns_Topic_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_topic_edit.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$topic = $this->context->getAttribute('topic');
	$comment = $this->context->getAttribute('comment');
	
	$this->assignCommonVars();
	$this->assignHeader('topic.css');
	$this->assignFormHeader('form_topic_edit', 'post', 'topic', 'edit_exec', true,
		array('tcid' => $topic['tcid']), 'TOPIC_EDIT');
	$this->assignFormHeader('form_topic_del', 'get', 'topic', 'del', false,
		array('tcid' => $topic['tcid']));
	$this->assignUploadFormJS(count($comment['images']), count($comment['files']));
	$this->assignXoopsCodeTarea($comment['body'], 'body', 60, 10);
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => $topic['name'], 'url' => XSNS_URL_TOPIC.'&tid='.$topic['id']),
		array('name' => $topic['lang_page_title']),
	);
	
	$this->tpl->assign(array(
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
