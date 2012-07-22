<?php
class Xsns_Category_Action extends Xsns_Admin_Action
{
function dispatch()
{
	$err = $this->checkPermission();
	if(!is_array($err) || count($err) > 0){
		$this->context->setAttribute('perm_error', $err);
		return "default";
	}
	
	$category_p = $category = array();
	
	$criteria = new CriteriaCompo();
	$criteria->setSort('sort_order');
	
	$category_p_handler =& XsnsCategoryParentHandler::getInstance();
	$category_p_obj_list =& $category_p_handler->getObjects($criteria);
	
	foreach($category_p_obj_list as $category_p_obj){
		if(is_object($category_p_obj)){
			$category_p[] = $category_p_obj->getVarsArray();
		}
	}
	unset($criteria);
	
	$criteria = new CriteriaCompo();
	$criteria->setSort('c_commu_category_parent_id,sort_order');
	
	$category_handler =& XsnsCategoryHandler::getInstance();
	$category_obj_list =& $category_handler->getObjects($criteria);
	
	foreach($category_obj_list as $category_obj){
		if(is_object($category_obj)){
			$pid = $category_obj->getVar('c_commu_category_parent_id');
			$category[$pid][] = $category_obj->getVarsArray();
		}
	}
	
	$this->context->setAttribute('category_p', $category_p);
	$this->context->setAttribute('category', $category);
}

}
?>
