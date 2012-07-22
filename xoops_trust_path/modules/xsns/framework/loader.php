<?php

$_requires = array(
	XSNS_FRAMEWORK_CLASS_DIR.'/Controller.php',
	XSNS_FRAMEWORK_CLASS_DIR.'/Context.php',
	XSNS_FRAMEWORK_CLASS_DIR.'/ActionManager.php',
	XSNS_FRAMEWORK_CLASS_DIR.'/ViewManager.php',
	XSNS_FRAMEWORK_CLASS_DIR.'/Action.php',
	XSNS_FRAMEWORK_CLASS_DIR.'/View.php',
	
	XSNS_USERLIB_DIR.'/loader.php',
	XSNS_USERLIB_CLASS_DIR.'/commonView.php',
	XSNS_USERLIB_CLASS_DIR.'/commonAction.php',
	XSNS_USERLIB_CLASS_DIR.'/'.$page_name.'Action.php',
	XSNS_USERLIB_CLASS_DIR.'/'.$page_name.'View.php',
);

foreach ($_requires as $_require) {
	if (is_readable($_require) && is_file($_require)) {
		require_once($_require);
	}
	else {
		if($GLOBAL['xoopsUserIsAdmin']){
			die("ERROR: {$_require} NOT FOUND.");
		}
		else{
			exit();
		}
	}
}

?>