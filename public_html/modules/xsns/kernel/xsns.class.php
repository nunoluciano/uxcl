<?php

if(!class_exists('XsnsFunction')){

class XsnsFunction
{
	function userinfo()
	{
		$mydirpath = dirname(dirname(__FILE__));
		
		// redirect to mypage top
		if(@include_once($mydirpath.'/config.php')){
			$page_name = 'mypage';
			if(@include_once(XSNS_FRAMEWORK_DIR.'/loader.php')){
				$uid_str = isset($_GET['uid'])? "&uid=".intval($_GET['uid']) : "";
				header("Location: ".XSNS_URL_MYPAGE.$uid_str);
				exit;
			}
		}
	}
	
	function edituser()
	{
		$mydirpath = dirname(dirname(__FILE__));
		
		// redirect to mypage profile
		if(@include_once($mydirpath.'/config.php')){
			$page_name = 'mypage';
			if(@include_once(XSNS_FRAMEWORK_DIR.'/loader.php')){
				header("Location: ".XSNS_URL_MYPAGE."&".XSNS_ACTION_ARG."=profile");
				exit;
			}
		}
	}
}

}

?>
