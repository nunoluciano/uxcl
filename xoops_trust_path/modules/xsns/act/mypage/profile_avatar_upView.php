<?php

class Xsns_Profile_avatar_up_View extends Xsns_Mypage_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_mypage_profile_avatar.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';
	
	$this->assignCommonVars();
	$this->assignStyleSheet();
	
	$form = $this->context->getAttribute('form');
	if(is_object($form)){
		$form->assign($this->tpl);
	}
	$form2 = $this->context->getAttribute('form2');
	if(is_object($form2)){
		$form2->assign($this->tpl);
	}
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}

}
?>
