<?php
class Xsns_Default_View extends Xsns_Mypage_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	
	$user_info = $this->context->getAttribute('user_info');
	
	$url = array(
		'friend_list_all' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=friend_list&uid='.$user_info['id'],
		'commu_list_all' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=commu_list&uid='.$user_info['id'],
		'topic_list_all' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=topic_list',
		'blog_list_all' => XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=blog_list',
		'intro_list_all' => XSNS_URL_MYPAGE_INTRO.'&uid='.$user_info['id'],
	);
	
	$this->tpl->assign(array(
		'url' => $url,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
//------------------------------------------------------------------------------

}
?>
