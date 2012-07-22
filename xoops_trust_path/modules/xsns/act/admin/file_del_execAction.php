<?php
class Xsns_File_del_exec_Action extends Xsns_Admin_Action
{
function dispatch()
{
	if(!$this->validateToken('FILE_DELETE')){
		redirect_header(XSNS_URL_ADMIN, 2, _NOPERM);
	}
	
	$del_id = isset($_POST['delete']) ? $_POST['delete'] : NULL;
	if(is_null($del_id) || !is_array($del_id)){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=file', 2, _AM_XSNS_FILE_SELECT_NG);
	}
	
	$file_handler =& XsnsFileHandler::getInstance();
	
	foreach($del_id as $id){
		$file =& $file_handler->get($id);
		$file_handler->delete($file);
	}
	redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=file', 2, _AM_XSNS_FILE_DELETE_OK);
}
}
?>
