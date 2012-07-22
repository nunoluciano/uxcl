<?php
class Xsns_Friend_add_View extends Xsns_Mypage_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_friend_add.html';
	require_once XOOPS_ROOT_PATH.'/header.php';

	$user = $this->context->getAttribute('user');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('member.css');
	$this->assignFormHeader('form_friend_add_submit', 'post', 'mypage', 'friend_add_exec', false, 
					array('uid'=>$user['uid']), 'FRIEND_ADD');

	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
