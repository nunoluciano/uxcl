<?php
class Xsns_Category_add_exec_Action extends Xsns_Admin_Action
{
function dispatch()
{
	$cat_handler =& XsnsCategoryHandler::getInstance();
	$cat_parent_handler =& XsnsCategoryParentHandler::getInstance();
	
	$title = $this->getTextRequest('title');
	if(empty($title)){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, _AM_XSNS_CATEGORY_NAME_NG);
	}
	
	$order = $this->getIntRequest('order');
	if($order < 0){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, _AM_XSNS_CATEGORY_ORDER_NG);
	}
	
	$mode = $this->getTextRequest('mode');
	
	if($mode=='parent'){
		// 中カテゴリの作成
		$cat_parent =& $cat_parent_handler->create();
		$cat_parent->setVars(array(
			'name' => $title,
			'sort_order' => $order,
			'selector' => '<span></span>'	// NOT NULL
		));
		$ret = $cat_parent_handler->insert($cat_parent);
	}
	else{
		$pid = $this->getIntRequest('pid');
		if($pid < 0){
			redirect_header(XSNS_URL_ADMIN, 2, _AM_XSNS_CATEGORY_ADD_NG);
		}
		// 小カテゴリの作成
		$cat =& $cat_handler->create();
		$cat->setVars(array(
			'name' => $title,
			'sort_order' => $order,
			'c_commu_category_parent_id' => $pid,
		));
		$ret = $cat_handler->insert($cat);
	}
	
	if($ret && $cat_handler->updateSelector()){
		redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, _AM_XSNS_CATEGORY_ADD_OK);
	}
	redirect_header(XSNS_URL_ADMIN.'?'.XSNS_ACTION_ARG.'=category', 2, _AM_XSNS_CATEGORY_ADD_NG);
}
}
?>
