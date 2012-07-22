<?php
class Xsns_Mypage_Action extends XsnsCommonAction
{

function checkPermissionForGuest()
{
	global $xoopsModuleConfig;
	if(isset($xoopsModuleConfig['show_mypage_for_guest']) && $xoopsModuleConfig['show_mypage_for_guest']){
		return true;
	}
	else{
		return !$this->isGuest();
	}
}

}
?>
