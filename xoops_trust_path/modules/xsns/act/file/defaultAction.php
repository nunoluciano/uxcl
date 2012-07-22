<?php
class Xsns_Default_Action extends Xsns_File_Action
{
function dispatch()
{
	$image_id = $this->getIntRequest('image_id', XSNS_REQUEST_GET);
	$file_id = $this->getIntRequest('file_id', XSNS_REQUEST_GET);
	
	if(($image_id > 0 && $file_id > 0) || !$this->checkAuthority($image_id, $file_id)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if($image_id > 0){
		$form_data = $this->getDeleteImageConfirmFormData($image_id);
		$hidden['image_id'] = $image_id;
	}
	elseif($file_id > 0){
		$form_data = $this->getDeleteFileConfirmFormData($file_id);
		$hidden['file_id'] = $file_id;
	}
	
	if(!$form_data){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$this->context->setAttribute('hidden', $hidden);
	$this->context->setAttribute('form_data', $form_data);
}
//------------------------------------------------------------------------------

// 画像の削除確認用フォームに表示するデータの取得
function getDeleteImageConfirmFormData($image_id)
{
	global $xoopsModuleConfig;
	
	$image_handler =& XsnsImageHandler::getInstance();
	$image =& $image_handler->get($image_id);
	if(!is_object($image)){
		return false;
	}
	$image_info =& $image->getInfo(2);
	
	$filename = $xoopsModuleConfig['file_upload_path']. '/'. $image_info['filename'];
	if(!file_exists($filename)){
		return false;
	}
	
	$ext_to_mime = include(XOOPS_ROOT_PATH.'/class/mimetypes.inc.php');
	
	$path_parts = @pathinfo($filename);
	$file_stat = @stat($filename);
	
	$form_data = array(
		'title' => _MD_XSNS_TITLE_IMAGE,
		'desc' => _MD_XSNS_FILE_DEL_IMAGE_DESC,
		'file_name_desc' => _MD_XSNS_FILE_IMAGE,
		'name' => "<img src='".XSNS_IMAGE_URL."?f=".$image_info['filename']."&t=2' alt=''>",
		'size' => filesize($filename),
		'type' => @$ext_to_mime[$path_parts['extension']],
		'time' => xoops_getUserTimestamp($file_stat['mtime']),
	);
	return $form_data;
}
//------------------------------------------------------------------------------

// ファイルの削除確認用フォームに表示するデータの取得
function getDeleteFileConfirmFormData($file_id)
{
	global $xoopsModuleConfig;
	
	$file_handler =& XsnsFileHandler::getInstance();
	$file =& $file_handler->get($file_id);
	if(!is_object($file)){
		return false;
	}
	$file_info =& $file->getInfo();
	
	$filename = $xoopsModuleConfig['file_upload_path']. '/'. $file_info['filename'];
	if(!file_exists($filename)){
		return false;
	}
	
	$ext_to_mime = include(XOOPS_ROOT_PATH.'/class/mimetypes.inc.php');
	
	$path_parts = @pathinfo($filename);
	$file_stat = @stat($filename);
	
	$form = array(
		'title' => _MD_XSNS_TITLE_FILE,
		'desc' => _MD_XSNS_FILE_DEL_FILE_DESC,
		'file_name_desc' => _MD_XSNS_FILE_NAME,
		'name' => $file_info['caption'],
		'size' => filesize($filename),
		'type' => @$ext_to_mime[$path_parts['extension']],
		'time' => date('Y-m-d H:i:s', $file_stat['mtime']),
	);
	return $form;
}
//------------------------------------------------------------------------------

}
?>
