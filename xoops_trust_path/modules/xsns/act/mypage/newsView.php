<?php
class Xsns_News_View extends Xsns_Mypage_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_news.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet('mypage.css');
	
	$url = array(
		'module_config' => XSNS_URL_MYPAGE_CONFIG,
	);
	
	$this->tpl->assign(array(
		'url' => $url,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}

}
?>
