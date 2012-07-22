<?php
class Xsns_Category_edit_exec_Action extends Xsns_Admin_Action
{

function dispatch()
{
	$cat_handler =& XsnsCategoryHandler::getInstance();
	$cat_parent_handler =& XsnsCategoryParentHandler::getInstance();
	
	if($this->getTextRequest('delete')){
		$action = 'delete';
		$msg_ok = _AM_XSNS_CATEGORY_DEL_OK;
		$msg_ng = _AM_XSNS_CATEGORY_DEL_NG;
	}
	else{
		$action = 'edit';
		$msg_ok = _AM_XSNS_CATEGORY_EDIT_OK;
		$msg_ng = _AM_XSNS_CATEGORY_EDIT_NG;
	}
	
	$mode = $this->getTextRequest('mode');
	
	$id = ($mode=='parent') ? $this->getIntRequest('pid') : $this->getIntRequest('id');
	
	$title = $this->getTextRequest('title'.$id);
	if(empty($title)){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, _AM_XSNS_CATEGORY_NAME_NG);
	}
	
	$order = $this->getIntRequest('order'.$id);
	if($order < 0){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, _AM_XSNS_CATEGORY_ORDER_NG);
	}
	
	if($mode=='parent'){
		$cat_parent =& $cat_parent_handler->get($id);
		if(!is_object($cat_parent)){
			redirect_header(XSNS_URL_ADMIN, 2, _NOPERM);
		}
		
		if($action=='edit'){
			// 中カテゴリの編集
			$cat_parent->setVar('name', $title);
			$cat_parent->setVar('sort_order', $order);
			$ret = $cat_parent_handler->insert($cat_parent);
		}
		else{
			// 中カテゴリの削除
			$criteria = new Criteria('c_commu_category_parent_id', $id);
			$cat_obj_list =& $cat_handler->getObjects($criteria);
			foreach($cat_obj_list as $cat_obj){
				$cat_handler->delete($cat_obj);
			}
			$ret = $cat_parent_handler->delete($cat_parent);
		}
	}
	else{
		$cat =& $cat_handler->get($id);
		if(!is_object($cat)){
			redirect_header(XSNS_URL_ADMIN, 2, _NOPERM);
		}
		
		if($action=='edit'){
			// 小カテゴリの編集
			$cat->setVar('name', $title);
			$cat->setVar('sort_order', $order);
			$ret = $cat_handler->insert($cat);
		}
		else{
			// 小カテゴリの削除
			$ret = $cat_handler->delete($cat);
		}
	}
	
	if($ret && $cat_handler->updateSelector()){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, $msg_ok);
	}
	redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, $msg_ng);
}
//------------------------------------------------------------------------------

}
?>
