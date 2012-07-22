<?php
class Xsns_Add_confirm_Action extends Xsns_Topic_Action
{

function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}

	require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	$token_handler = new XoopsMultiTokenHandler();
	$token = new XoopsFormToken($token_handler->create('TOPIC_ADD'));
	// Hidden
	$token_tag = '<input type="hidden" name="'.$token->_name.'" value="'.$token->_value.'">';
	$this->context->setAttribute('token_tag', $token_tag);
	
	$cid = $this->getIntRequest('cid');
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	$sess_handler =& XsnsSessionHandler::getInstance();
	$image_handler =& XsnsImageHandler::getInstance();
	$file_handler =& XsnsFileHandler::getInstance();
	
	// コミュニティの取得
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$param = array(
		'number' => 0,
		'name' => $this->getTextRequest('name'),
		'body' => $this->getTextRequest('body'),
	);
	
	$errors = array();
	
	$this->checkParam(&$param, &$errors);
	
	$new_topic =& $topic_handler->create();
	$new_topic->setVar('name', $param['name']);
	
	$new_comment =& $comment_handler->create();
	$new_comment->setVar('body', $param['body']);
	
	$commu_vars = array('id' => $cid, 'name' => $community->getVar('name'));
	
	// 入力エラー
	if(count($errors) > 0){
		$default = array(
			'name' => $new_topic->getVar('name', 'f'),
			'body' => $new_comment->getVar('body', 'f'),
		);
		$this->context->setAttribute('commu', $commu_vars);
		$this->context->setAttribute('default', $default);
		$this->context->setAttribute('errors', $errors);
		
		return "add";	// → topic/addView.php
	}
	
	$topic_vars_temp = array(
		'name' => $param['name'],
		'body' => $param['body'],
	);
	$sess_handler->setVar('topic', $topic_vars_temp);
	
	$topic_vars = array(
		'name' => $new_topic->getVar('name', 'p'),
		'body' => $new_comment->getVar('body', 'p'),
		'images' => $image_handler->uploadImageTemp('images'),
		'files' => $file_handler->uploadFileTemp('files'),
	);
	$this->context->setAttribute('topic', $topic_vars);
	$this->context->setAttribute('commu', $commu_vars);
}
//------------------------------------------------------------------------------

}
?>
