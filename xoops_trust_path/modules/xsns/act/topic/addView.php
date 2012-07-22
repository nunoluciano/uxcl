<?php
class Xsns_Add_View extends Xsns_Topic_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_topic_add.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$default = $this->context->getAttribute('default');
	
	$this->assignCommonVars();
	$this->assignHeader('topic.css');
	$this->assignXoopsCodeTarea($default['body'], 'body', 60, 10);
	$this->assignUploadFormJS();
	$this->assignFormHeader('form_topic_add', 'post', 'topic', 'add_confirm', 
		true, array('cid'=>$commu['id']));
	
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => _MD_XSNS_TITLE_TOPIC_ADD),
	);
	
	$this->tpl->assign(array(
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}

}
?>
