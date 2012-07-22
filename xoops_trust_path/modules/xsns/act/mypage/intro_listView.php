<?php
class Xsns_Intro_list_View extends Xsns_Mypage_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_intro_list.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$uid_to = $this->context->getAttribute('uid_to');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	
	$url = array(
		'intro_delete' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=intro_del&uid_to='.$uid_to.'&uid_from=',
	);
	
	$this->tpl->assign(array(
		'url' => $url,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
