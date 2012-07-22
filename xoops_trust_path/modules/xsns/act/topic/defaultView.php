<?php
class Xsns_Default_View extends Xsns_Topic_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_topic.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$topic = $this->context->getAttribute('topic');
	
	$this->assignCommonVars();
	$this->assignHeader(
		array('topic.css', 'respopup.css'), 
		array('respopup.js')
	);
	$this->assignFormHeader('form_res_add', 'post', 'topic', 'res_confirm', true, 
		array('tid' => $topic['id']));

	$this->assignUploadFormJS();
	
	$default = $this->context->getAttribute('default');
	$this->assignXoopsCodeTarea($default['body'], 'body', 60, 8);
	
	$this->context->assignAttributes();
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => $topic['name']),
	);
	
	$this->tpl->assign(array(
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
