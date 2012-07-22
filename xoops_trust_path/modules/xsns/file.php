<?php
// $Id: common.php,v 1.8 2005/10/24 11:44:16 onokazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //


if(strstr(@$_SERVER['HTTP_REFERER'], XOOPS_URL) === false
   || !isset($_GET['id']) || !isset($_SERVER['HTTP_USER_AGENT'])){
	header("Location: ".XOOPS_URL);
	exit();
}

$id = intval($_GET['id']);
if($id < 1){
	header("Location: ".XOOPS_URL);
	exit();
}

$sql = "SELECT filename,org_filename,target,target_id FROM ".$xoopsDB->prefix($mydirname.'_c_file').
		" WHERE c_file_id='".$id."'";
$rs = $xoopsDB->query($sql);

if(!$rs || $xoopsDB->getRowsNum($rs)!=1){
	header("Location: ".XOOPS_URL);
	exit();
}

list($filename, $org_filename, $target, $target_id) = $xoopsDB->fetchRow($rs);

if(!checkPermission($target, $target_id)){
	header("Location: ".XOOPS_URL);
	exit();
}

$path_file = $xoopsModuleConfig['file_upload_path']. '/'. $filename;

if(!checkFile($path_file)){
	header("Location: ".XOOPS_URL);
	exit();
}

$saved_filename = rawurldecode($org_filename);

$ua = $_SERVER['HTTP_USER_AGENT'];

if(strstr($ua, "MSIE") && !strstr($ua, 'Opera')){
	$saved_filename = mb_convert_encoding($saved_filename, 'SJIS', 'EUC-JP');
}
else{
	$saved_filename = mb_convert_encoding($saved_filename, 'UTF-8', 'EUC-JP');
}

ini_set('include_path', XOOPS_TRUST_PATH.'/PEAR');
if(include_once('HTTP/Download.php')){
	$download = new HTTP_Download();
	$download->setFile($path_file);
	$download->setCache(false);
	$download->setContentDisposition(HTTP_DOWNLOAD_ATTACHMENT, $saved_filename);
	$download->setContentType('application/octet-stream');
	$download->send();
}
else{
	header("Location: ".XOOPS_URL);
}
exit();

//------------------------------------------------------------------------------

function checkPermission($target, $target_id)
{
	global $xoopsUserIsAdmin;
	if($xoopsUserIsAdmin){
		return true;
	}
	
	include_once dirname(__FILE__).'/config.php';
	include_once XSNS_USERLIB_DIR.'/config.php';
	include_once XSNS_USERLIB_DIR.'/loader.php';
	
	$commu_handler = XsnsCommunityHandler::getInstance();
	$comment_handler = XsnsTopicCommentHandler::getInstance();
	
	if($target==1){
		$commu_id = $target_id;
	}
	elseif($target==2){
		$comment = $comment_handler->get($target_id);
		if(!is_object($comment)){
			return false;
		}
		$commu_id = $comment->getVar('c_commu_id');
	}
	else{
		return false;
	}
	
	$community = $commu_handler->get($commu_id);
	if(!is_object($community)
	  || ($community->getVar('public_flag')==3 && $community->getAuthority() < XSNS_AUTH_MEMBER)){
		return false;
	}
	return true;
}
//------------------------------------------------------------------------------

function checkFile($filename)
{
	if(!file_exists($filename)){
		return false;
	}
	
	if(!($fp = fopen($filename, "rb"))){
		return false;
	}
	fclose($fp);

	if(filesize($filename) == 0){
		return false;
	}
	
	return true;
}

//------------------------------------------------------------------------------


?>

