<?php
class Xsns_Res_confirm_View extends Xsns_Topic_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_topic_res_confirm.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$topic = $this->context->getAttribute('topic');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('topic.css');
	$this->assignFormHeader('form_topic_res_submit', 'post', 'topic', 'res_exec', false, 
		array('tid' => $topic['id']), 'TOPIC_COMMENT_ADD');
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => $topic['name'], 'url' => XSNS_URL_TOPIC.'&tid='.$topic['id']),
		array('name' => _MD_XSNS_TITLE_TOPIC_RES_ADD),
	);
	
	$this->tpl->assign(array(
		'url_modify' => XSNS_URL_TOPIC.'&tid='.$topic['id'],
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
