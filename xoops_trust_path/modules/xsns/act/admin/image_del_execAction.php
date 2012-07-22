<?php
class Xsns_Image_del_exec_Action extends Xsns_Admin_Action
{
function dispatch()
{
	if(!$this->validateToken('IMAGE_DELETE')){
		redirect_header(XSNS_URL_ADMIN, 2, _NOPERM);
	}
	
	$del_id = isset($_POST['delete']) ? $_POST['delete'] : NULL;
	if(is_null($del_id) || !is_array($del_id)){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=image', 2, _AM_XSNS_IMAGE_SELECT_NG);
	}
	
	$image_handler =& XsnsImageHandler::getInstance();
	
	foreach($del_id as $id){
		$image =& $image_handler->get($id);
		$image_handler->delete($image);
	}
	redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=image', 2, _AM_XSNS_IMAGE_DELETE_OK);
}
}
?>
