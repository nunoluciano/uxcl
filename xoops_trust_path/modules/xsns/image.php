<?php
// $Id: common.php,v 1.8 2005/10/24 11:44:16 onokazu Exp $
//	------------------------------------------------------------------------ //
//				  XOOPS - PHP Content Management System 					 //
//					  Copyright (c) 2000 XOOPS.org							 //
//						 <http://www.xoops.org/>							 //
//	------------------------------------------------------------------------ //
//	This program is free software; you can redistribute it and/or modify	 //
//	it under the terms of the GNU General Public License as published by	 //
//	the Free Software Foundation; either version 2 of the License, or		 //
//	(at your option) any later version. 									 //
//																			 //
//	You may not change or alter any portion of this comment or credits		 //
//	of supporting developers from this source code or any supporting		 //
//	source code which is considered copyrighted (c) material of the 		 //
//	original comment or credit authors. 									 //
//																			 //
//	This program is distributed in the hope that it will be useful, 		 //
//	but WITHOUT ANY WARRANTY; without even the implied warranty of			 //
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 //
//	GNU General Public License for more details.							 //
//																			 //
//	You should have received a copy of the GNU General Public License		 //
//	along with this program; if not, write to the Free Software 			 //
//	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//	------------------------------------------------------------------------ //

//if(strpos(@$_SERVER['HTTP_REFERER'], XOOPS_URL)!==false && isset($_GET['f'])){//if(isset($_GET['f'])){

global $xoopsTpl;

if (((HYP_K_TAI_RENDER || $xoopsTpl->_tpl_vars['wizmobile_ismobile']) && isset($_GET['f'])) || (strpos(@$_SERVER['HTTP_REFERER'], XOOPS_URL)!==false && isset($_GET['f']))) {
	$cache_limit = 3600;
	
	if(!preg_match('/[0-9a-z]{13}/i', $_GET['f'])){
		exit();
	}
	
	// XOOPS_ROOT_PATH/include/common.php --------------------------------------
	
	define('XOOPS_DB_PROXY', 1);
	include_once XOOPS_ROOT_PATH.'/class/logger.php';
	include_once XOOPS_ROOT_PATH.'/include/functions.php';
	include_once XOOPS_ROOT_PATH.'/class/database/databasefactory.php';
	include_once XOOPS_ROOT_PATH.'/kernel/object.php';
	include_once XOOPS_ROOT_PATH.'/class/criteria.php';
	$xoopsDB =& XoopsDatabaseFactory::getDatabaseConnection();
	
	$url_arr = explode('/',strstr($_SERVER['REQUEST_URI'],'/modules/'));
	$module_handler =& xoops_gethandler('module');
	$xoopsModule =& $module_handler->getByDirname($url_arr[2]);
	unset($url_arr);
	if (!$xoopsModule || !$xoopsModule->getVar('isactive') || !$xoopsModule->getVar('hasconfig')){
		exit();
	}
	$config_handler =& xoops_gethandler('config');
	$xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
	
	// -------------------------------------------------------------------------
	
	if(!isset($xoopsModuleConfig['file_upload_path'])){
		exit();
	}
	
	$image = NULL;
	$thumb_dir = (isset($_GET['t']))? '/thumbnail'.intval($_GET['t']).'/' : '/';
	$filename = $xoopsModuleConfig['file_upload_path']. $thumb_dir. preg_replace('/\//', '', $_GET['f']);
	
	if(!file_exists($filename)){
		exit();
	}
	
	if(preg_match('/\.gif$/i', $filename)){
		$content_type = 'image/gif';
	}
	elseif(preg_match('/\.(jpg|jpeg)$/i', $filename)){
		$content_type = 'image/jpeg';
	}
	elseif(preg_match('/\.png$/i', $filename)){
		$content_type = 'image/png';
	}
	else{
		exit();
	}
	
	if(!headers_sent()){
		session_cache_limiter('public');
		header("Expires: ".date('r',intval(time()/$cache_limit)*$cache_limit+$cache_limit));
		header("Cache-Control: public, max-age=$cache_limit");
		header("Last-Modified: ".date('r',intval(time()/$cache_limit)*$cache_limit));
		header("Content-Type: ".$content_type);
		
		readfile($filename);
	}
}
exit();

?>
