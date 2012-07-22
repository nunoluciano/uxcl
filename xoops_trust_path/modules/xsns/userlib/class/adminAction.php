<?php
class Xsns_Admin_Action extends XsnsCommonAction
{

// ディレクトリの権限をチェック
function checkPermission()
{
	global $xoopsModuleConfig;
	if(!isset($xoopsModuleConfig['file_upload_path'])){
		return false;
	}
	
	$status = array();
	$upload_dir = array(
		$xoopsModuleConfig['file_upload_path'],
		$xoopsModuleConfig['file_upload_path'].'/thumbnail1',
		$xoopsModuleConfig['file_upload_path'].'/thumbnail2',
		$xoopsModuleConfig['file_upload_path'].'/thumbnail3',
	);
	
	foreach($upload_dir as $dir){
		if(!is_writable($dir)){
			$status[] = $dir;
		}
	}
	return $status;
}

}
?>
