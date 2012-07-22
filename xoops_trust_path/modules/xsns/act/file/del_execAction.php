<?php
class Xsns_Del_exec_Action extends Xsns_File_Action
{

function dispatch()
{
	if(!$this->validateToken('FILE_DELETE')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}

	$image_id = $this->getIntRequest('image_id');
	$file_id = $this->getIntRequest('file_id');
	
	if(($image_id > 0 && $file_id > 0) || !$this->checkAuthority($image_id, $file_id)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$url = XSNS_URL_COMMU;
	
	if($image_id > 0){
		$image_handler =& XsnsImageHandler::getInstance();
		$image =& $image_handler->get($image_id);
		
		if(is_object($image) && $image_handler->delete($image)){
			$msg = _MD_XSNS_FILE_DEL_IMAGE_OK;
			$url = $this->getRedirectURL($image->getVar('target'), $image->getVar('target_id'));
		}
		else{
			$msg = _MD_XSNS_FILE_DEL_IMAGE_NG;
		}
	}
	elseif($file_id > 0){
		$file_handler =& XsnsFileHandler::getInstance();
		$file =& $file_handler->get($file_id);
		
		if(is_object($file) && $file_handler->delete($file)){
			$msg = _MD_XSNS_FILE_DEL_FILE_OK;
			$url = $this->getRedirectURL($file->getVar('target'), $file->getVar('target_id'));
		}
		else{
			$msg = _MD_XSNS_FILE_DEL_FILE_NG;
		}
	}
	else{
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if(empty($url)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	redirect_header($url, 2, $msg);
}

//------------------------------------------------------------------------------

function getRedirectURL($target, $target_id)
{
	if($target == 1){
		// for community
		return XSNS_URL_COMMU.'?'.XSNS_ACTION_ARG.'=edit&cid='.$target_id;
	}
	elseif($target == 2){
		// for topic
		$comment_handler =& XsnsTopicCommentHandler::getInstance();
		$comment =& $comment_handler->get($target_id);
		if(is_object($comment)){
			return XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=edit&tcid='.$target_id;
		}
	}
	return NULL;
}

//------------------------------------------------------------------------------

}
?>
