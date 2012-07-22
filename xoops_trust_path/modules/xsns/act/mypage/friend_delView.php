<?php

class Xsns_Friend_del_View extends Xsns_Mypage_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_friend_del.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$friend = $this->context->getAttribute('friend');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	$this->assignFormHeader('form_friend_del', 'post', 'mypage', 'friend_del_exec', false, 
		array('uid'=>$friend['uid']), 'FRIEND_DELETE');
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}

}
?>
