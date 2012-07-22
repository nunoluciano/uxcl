<?php
class Xsns_Res_confirm_Action extends Xsns_Topic_Action
{
function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$tid = $this->getIntRequest('tid');
	if(!isset($tid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	$token_handler = new XoopsMultiTokenHandler();
	$token = new XoopsFormToken($token_handler->create('TOPIC_COMMENT_ADD'));
	// Hidden
	$token_tag = '<input type="hidden" name="'.$token->_name.'" value="'.$token->_value.'">';
	$this->context->setAttribute('token_tag', $token_tag);

	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	
	// トピックの取得
	$topic =& $topic_handler->get($tid);
	if(!is_object($topic) || $topic->getCommentCount() >= 1001){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$cid = $topic->getVar('c_commu_id');
	$community =& $commu_handler->get($cid);
	if(!is_object($community)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$commu_auth = $community->getAuthority();
	if($commu_auth < XSNS_AUTH_NON_MEMBER
	   || ($commu_auth < XSNS_AUTH_MEMBER && $community->getVar('public_flag')==3) ){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$errors = array();
	
	$body = $this->getTextRequest('body');
	if(empty($body)){
		$errors[] = _MD_XSNS_TOPIC_RES_BODY_NG;
	}
	
	if(count($errors) > 0){
		redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, _MD_XSNS_TOPIC_RES_BODY_NG);
	}
	
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	$new_comment =& $comment_handler->create();
	$new_comment->setVar('body', $body);
	
	$commu_vars = array('id' => $cid, 'name' => $community->getVar('name'));
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$sess_handler->setVar('comment_body', $body);
	
	$image_handler =& XsnsImageHandler::getInstance();
	$file_handler =& XsnsFileHandler::getInstance();
	
	$topic_vars = array(
		'id' => $tid,
		'name' => $topic->getVar('name'),
		'body' => preg_replace('/\[res\]([1-9]\\d*)\[\/res\]/', '>>\1', $new_comment->getVar('body', 'p')),
		'images' => $image_handler->uploadImageTemp('images'),
		'files' => $file_handler->uploadFileTemp('files'),
	);
	
	$this->context->setAttribute('topic', $topic_vars);
	$this->context->setAttribute('commu', $commu_vars);
}

}
?>
