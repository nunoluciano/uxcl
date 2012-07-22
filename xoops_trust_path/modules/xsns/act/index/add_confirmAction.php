<?php
class Xsns_Add_confirm_Action extends Xsns_Index_Action
{
function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	$token_handler = new XoopsMultiTokenHandler();
	$token = new XoopsFormToken($token_handler->create('COMMUNITY_ADD'));
	// Hidden
	$token_tag = '<input type="hidden" name="'.$token->_name.'" value="'.$token->_value.'">';
	$this->context->setAttribute('token_tag', $token_tag);

	$name = $this->getTextRequest('name');
	$cat_id = $this->getIntRequest('category');
	$public_id = $this->getIntRequest('public');
	$info = $this->getTextRequest('info');
	
	$errors = array();
	$commu_handler =& XsnsCommunityHandler::getInstance();
	if(!$commu_handler->checkParams(0, $name, $info, $cat_id, $public_id)){
		$errors = $commu_handler->getErrors();
	}
	
	if($public_id < 1 || $public_id > 3){
		$public_id = 1;
	}
	
	$new_community =& $commu_handler->create();
	$new_community->setVars(array(
		'name' => $name,
		'info' => $info,
	));
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$commu_vars_temp = array(
		'name' => $name,
		'cat_id' => $cat_id,
		'public_id' => $public_id,
		'info' => $info,
	);
	$sess_handler->setVar('community', $commu_vars_temp);
	
	$category_handler =& XsnsCategoryHandler::getInstance();
	
	// check input : NG
	if(count($errors) > 0){
		$default = array(
			'name' => $new_community->getVar('name', 'f'),
			'info' => $new_community->getVar('info', 'f'),
			'public'.$public_id => ' checked',
		);
		$category_selector = $category_handler->getSelectorHtml('category', $cat_id, _MD_XSNS_SELBOX_DEFAULT);
		$this->context->setAttribute('category_selector', $category_selector);
		$this->context->setAttribute('default', $default);
		$this->context->setAttribute('errors', $errors);
		return "add";	// ¨ index/addView.php
	}
	
	// check input : OK
	$image_handler =& XsnsImageHandler::getInstance();
	$image_handler->setFormLimit(1);
	
	$public_desc = array(
		'1' => _MD_XSNS_INDEX_PUBLIC_L1,
		'2' => _MD_XSNS_INDEX_PUBLIC_L2,
		'3' => _MD_XSNS_INDEX_PUBLIC_L3,
	);
	
	$category =& $category_handler->get($cat_id);
	
	$commu_vars = array(
		'name' => $new_community->getVar('name', 'p'),
		'category_id' => $cat_id,
		'category' => $category->getVar('name', 'p'),
		'public_id' => $public_id,
		'public' => $public_desc[$public_id],
		'info' => $new_community->getVar('info', 'p'),
		'image' => $image_handler->uploadImageTemp('image'),
	);
	
	$this->context->setAttribute('commu', $commu_vars);
}
//------------------------------------------------------------------------------

}
?>
