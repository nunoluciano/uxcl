<?php
class Xsns_Intro_del_View extends Xsns_Mypage_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_intro_del.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	
	$uid_to = $this->context->getAttribute('uid_to');
	$uid_from = $this->context->getAttribute('uid_from');
	
	$this->assignFormHeader('form_intro_del', 'post', 'mypage', 'intro_del_exec', false, 
		array('uid_to'=>$uid_to, 'uid_from'=>$uid_from), 'INTRO_DELETE');
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
