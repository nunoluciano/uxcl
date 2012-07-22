<?php
class Xsns_Intro_add_View extends Xsns_Mypage_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_intro.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$uid_to = $this->context->getAttribute('uid_to');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	$this->assignFormHeader('form_intro_add', 'post', 'mypage', 'intro_add_exec', false, 
		array('uid_to'=>$uid_to), 'INTRO_ADD');
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}

}
?>
