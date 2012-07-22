<?php
class Xsns_Edit_Action extends Xsns_Index_Action
{

function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php'; 
	$token_handler = new XoopsMultiTokenHandler();
	$token = new XoopsFormToken($token_handler->create('COMMUNITY_EDIT')); 
	// Hidden 
	$token_tag = '<input type="hidden" name="'.$token->_name.'" value="'.$token->_value.'">';
	$this->context->setAttribute('token_tag', $token_tag); 

	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$perm = XSNS_AUTH_XOOPS_ADMIN | XSNS_AUTH_ADMIN;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority($perm)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_data = array(
		'id' => $cid,
		'name' => $community->getVar('name', 'e'),
		'info' => $community->getVar('info', 'e'),
		'del_enabled' => ($community->getTopicCount()==0)? true : false,
		'image' => $community->getImage(XSNS_IMAGE_SIZE_S),
	);
	
	$category_handler =& XsnsCategoryHandler::getInstance();
	$category_selector = $category_handler->getSelectorHtml('category', $community->getVar('c_commu_category_id'));
	
	$this->context->setAttribute('commu', $commu_data);
	$this->context->setAttribute('public_flag', $community->getVar('public_flag'));
	$this->context->setAttribute('category_selector', $category_selector);
}
}
?>
