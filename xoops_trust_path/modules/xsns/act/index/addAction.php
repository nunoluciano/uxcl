<?php
class Xsns_Add_Action extends Xsns_Index_Action
{
function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$commu_temp = $sess_handler->getVar('community');
	$sess_handler->clearVars();
	$ts =& XsnsTextSanitizer::getInstance();
	
	$default = array(
		'name' => isset($commu_temp['name']) ? $ts->makeTboxData4PreviewInForm($commu_temp['name']) : '',
		'info' => isset($commu_temp['info']) ? $ts->makeTareaData4PreviewInForm($commu_temp['info']) : '',
		'cat_id' => isset($commu_temp['cat_id']) ? intval($commu_temp['cat_id']) : 0,
		'public_id' => isset($commu_temp['public_id']) ? intval($commu_temp['public_id']) : 1,
	);
	
	$image_handler =& XsnsImageHandler::getInstance();
	$image_handler->deleteImageTemp();
	
	$category_handler =& XsnsCategoryHandler::getInstance();
	$category_selector = $category_handler->getSelectorHtml('category', $default['cat_id'], _MD_XSNS_SELBOX_DEFAULT);
	
	$public_id = $default['public_id'];
	$default['public'.$public_id] = ' checked';
	
	$this->context->setAttribute('category_selector', $category_selector);
	$this->context->setAttribute('default', $default);
}
}
?>
