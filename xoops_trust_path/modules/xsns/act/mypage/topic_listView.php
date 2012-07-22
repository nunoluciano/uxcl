<?php
class Xsns_Topic_list_View extends Xsns_Mypage_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_topic_list.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}

}
?>
