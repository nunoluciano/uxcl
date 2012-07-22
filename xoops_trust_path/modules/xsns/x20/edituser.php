<?php

// for XOOPS 2.0.x

require_once 'mainfile.php';

$mytrustdirname = 'xsns';

$dirname_file = XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/x20/dirname.dat';
if(!file_exists($dirname_file)){
	header('Location: '.XOOPS_URL);
	exit();
}

$handle = fopen($dirname_file, 'r');
if(!$handle){
	header('Location: '.XOOPS_URL);
	exit();
}

$mydirname = preg_replace('/[^a-zA-Z0-9_-]/', '', fgets($handle));
fclose($handle);

$config_file = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/config.php';
if(!file_exists($config_file)){
	header('Location: '.XOOPS_URL);
	exit();
}

require_once $config_file;
require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';

if (!is_object($xoopsUser)) {
	redirect_header(XOOPS_URL, 3, _US_NOEDITRIGHT);
	exit();
}

header('Location: '.XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=mypage&'.XSNS_ACTION_ARG.'=profile');
exit();

?>
