<?php
if (! defined('XOOPS_MODULE_PATH')) define('XOOPS_MODULE_PATH', XOOPS_ROOT_PATH . '/modules');
if (! defined('XOOPS_MODULE_URL')) define('XOOPS_MODULE_URL', XOOPS_URL . '/modules');

$check_dir = array(
	XOOPS_MODULE_PATH .'/'.$mydirname.'/cache',
	XOOPS_MODULE_PATH .'/'.$mydirname.'/cache/tmb',
		XOOPS_TRUST_PATH.'/uploads/xelfinder'
);

$dir_res = array();

foreach($check_dir as $dir){
	$dir = rtrim($dir, '/');
	if (is_writable($dir)) {
		$dir .= ' (<span style="color:green;font-weight:bold;">OK</span>)';
	} else {
		$dir .= ' (<span style="color:red;font-weight:bold;">NG</span>)';
	}
	$dir_res[] = $dir;
}

$dir_res = '<ul><li>'.join('</li><li>', $dir_res).'</li></ul>';

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;

echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;
echo '<h4>Writable check results</h4>';
echo $dir_res;

xoops_cp_footer();

?>