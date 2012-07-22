<?php

class Xsns_Profile_View extends Xsns_Mypage_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_profile.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet();
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}

?>
