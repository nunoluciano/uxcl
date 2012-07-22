<?php

eval('
class '.ucfirst($mydirname).'_Preload extends XCube_ActionFilter{
	function postFilter(){
		XsnsPostFilterFunction("'.$mydirname.'");
	}
}
');

if(!function_exists('XsnsPostFilterFunction')){

function XsnsPostFilterFunction($mydirname)
{
	$root =& XCube_Root::getSingleton();
	
	$handler =& xoops_gethandler('config');
	$module_config =& $handler->getConfigsByDirname($mydirname);
	
	if(@$module_config['mypage_use']){
		$groups = is_object($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$gperm_handler =& xoops_gethandler('groupperm');
		$module_handler =& xoops_gethandler('module');
		$criteria = new CriteriaCompo(new Criteria('dirname', $mydirname));
		$criteria->add(new Criteria('isactive', 1));
		$mids =& array_keys($module_handler->getList($criteria));
		
		if($gperm_handler->checkRight('module_read', $mids[0], $groups)){
			$file = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/kernel/xsns.class.php';
			
			// userinfo.php
			$root->mDelegateManager->add('Legacypage.Userinfo.Access', 'XsnsFunction::userinfo', XCUBE_DELEGATE_PRIORITY_NORMAL-1, $file);
			
			if($root->mContext->mUser->isInRole('Site.RegisteredUser')){
				// edituser.php
				$root->mDelegateManager->add('Legacypage.Edituser.Access', 'XsnsFunction::edituser', XCUBE_DELEGATE_PRIORITY_NORMAL-1, $file);
			}
		}
	}
	
	// Service
	require_once dirname(__FILE__).'/Service.class.php';
	$service_class = ucfirst($mydirname).'_Service';
	if(class_exists($service_class)){
		$service = new $service_class();
		if(is_object($service)){
			$service->prepare();
			$root->mServiceManager->addService(ucfirst($mydirname), $service);
		}
	}
}

}
?>