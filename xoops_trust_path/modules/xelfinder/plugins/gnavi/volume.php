<?php
/*
 * Created on 2012/01/20 by nao-pon http://xoops.hypweb.net/
 */

if (is_dir(XOOPS_ROOT_PATH . $path)) {

	require_once dirname(__FILE__) . '/driver.class.php';
	
	$module_handler = xoops_gethandler('module');
	$gnaviModule = $module_handler->getByDirname($mydirname);
	$config_handler = xoops_gethandler('config');
	$myConfig = $config_handler->getConfigsByCat(0, $gnaviModule->mid());
	
	$path = '/' . trim($myConfig['gnavi_photospath'], '/') . '/';

	$volumeOptions = array(
		'driver'    => 'XoopsGnavi',
		'mydirname' => $mydirname,
		'path'      => '_',
		'filePath'  => XOOPS_ROOT_PATH . $path,
		'URL'       => _MD_XELFINDER_SITEURL . $path,
		'alias'     => $title,
		'smallImg'  => $myConfig['gnavi_thumbspath']
	);

}
