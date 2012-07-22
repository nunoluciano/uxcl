<?php
class Xsns_Edit_Action extends Xsns_Topic_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$tcid = $this->getIntRequest('tcid', XSNS_REQUEST_GET);
	if(!isset($tcid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	$token_handler = new XoopsMultiTokenHandler();
	$token = new XoopsFormToken($token_handler->create('TOPIC_EDIT'));
	// Hidden
	$token_tag = '<input type="hidden" name="'.$token->_name.'" value="'.$token->_value.'">';
	$this->context->setAttribute('token_tag', $token_tag);
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	
	// コメントの取得
	$comment =& $comment_handler->get($tcid);
	if(!is_object($comment)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$tid = $comment->getVar('c_commu_topic_id');
	
	// トピックの取得
	$topic =& $topic_handler->get($tid);
	if(!is_object($topic)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$cid = $topic->getVar('c_commu_id');
	
	// コミュニティの取得
	$community =& $commu_handler->get($cid);
	if(!is_object($community)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$commu_auth = $community->getAuthority();
	if($commu_auth < XSNS_AUTH_MEMBER){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$topic_uid = $topic->getVar('uid');
	$comment_uid = $comment->getVar('uid');
	$comment_number = $comment->getNumber();
	
	if($comment_uid > 0
	   && ($own_uid == $topic_uid || $own_uid == $comment_uid || $commu_auth >= XSNS_AUTH_SUB_ADMIN)){
		
		$topic_vars = array(
			'id' => $tid,
			'tcid' => $tcid,
			'name' => $topic->getVar('name', 'e'),
			'lang_page_title' => ($comment_number > 0) ? _MD_XSNS_TITLE_TOPIC_RES_EDIT : _MD_XSNS_TITLE_TOPIC_EDIT,
		);
		
		$comment_vars = array(
			'number' => $comment_number,
			'body' => $comment->getVar('body', 'e'),
			'images' => $comment->getImageList(2, XSNS_IMAGE_SIZE_S),
			'files' => $comment->getFileList(2),
		);
		
		$commu_vars = array('id' => $cid, 'name' => $community->getVar('name'));
		
		$this->context->setAttribute('commu', $commu_vars);
		$this->context->setAttribute('topic', $topic_vars);
		$this->context->setAttribute('comment', $comment_vars);
	}
	else{
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
}
}
?>
