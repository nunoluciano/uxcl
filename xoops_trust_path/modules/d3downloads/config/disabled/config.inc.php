<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

// submenu on-off 1 or 0
$submenu_option = array(
	'categories'  => 1 , 
	'topten_hit'  => 1 , 
	'topten_rate' => 1 , 
	'mylink'      => 1 , 
	'filelist'    => 1 , 
);

// these are added to $xoopsModuleConfig and act as if they are module config
// change these as you like 1 or 0
$option_config = array(
	'use_lightbox'               => 1 , // Use lightdox function(with JavaScript) for open a image. 
	'broken_message_from_sender' => 1 , // Message form on/off for brokenfile. 
);

// config for link check
$broken_check_config = array(
	'proxy_host'   =>  '' , // Hostname of proxy server for link check.
	'proxy_port'   =>  '' , // Port of proxy server for link check.
	'proxy_user'   =>  '' , // Username for proxy server for link check.
	'proxy_pass'   =>  '' , // Password for proxy server for link check.
	'maxredirect'  =>   0 , // Max redirections for link check.
	'read_timeout' =>  20 , // Timeout for link check.
);

?>