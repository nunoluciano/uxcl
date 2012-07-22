<?php
class Xsns_Del_Action extends Xsns_Topic_Action
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
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	$user_handler =& XsnsUserHandler::getInstance();
	
	// コメントの取得
	$comment =& $comment_handler->get($tcid);
	if(!is_object($comment)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$tid = $comment->getVar('c_commu_topic_id');
	$num = $comment->getNumber();
	
	// トピックの取得
	$topic =& $topic_handler->get($tid);
	if(!is_object($topic)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$topic_uid = $topic->getVar('uid');
	
	// コミュニティの取得
	$cid = $topic->getVar('c_commu_id');
	$community =& $commu_handler->get($cid);
	if(!is_object($community)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$commu_auth = $community->getAuthority();
	if($commu_auth < XSNS_AUTH_MEMBER){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$comment_uid = $comment->getVar('uid');
	if($comment_uid < 1 || ($commu_auth < XSNS_AUTH_SUB_ADMIN && $own_uid != $comment_uid && $own_uid != $topic_uid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$author =& $user_handler->get($comment->getVar('uid'));
	$author_info = is_object($author) ? $author->getInfo() : array('name'=>'', 'page_url'=>'');
	
	$target_topic = array(
		'tcid' => $tcid,
		'tid' => $tid,
		'number' => $num,
		'title' => $topic->getVar('name'),
		'lang_title' => ($num>0) ? _MD_XSNS_TITLE_TOPIC_RES_DEL : _MD_XSNS_TITLE_TOPIC_DEL,
		'body' => preg_replace('/\[res\]([1-9]\\d*)\[\/res\]/', '>>\1', $comment->getVar('body', 'p')),
		'author_name' => $author_info['name'],
		'author_url' => $author_info['page_url'],
	);

	$commu = array('id' => $cid, 'name' => $community->getVar('name'));
	$message = ($num==0)? _MD_XSNS_TOPIC_DEL_CONFIRM : _MD_XSNS_TOPIC_RES_DEL_CONFIRM;
	
	$this->context->setAttribute('topic', $target_topic);
	$this->context->setAttribute('commu', $commu);
	$this->context->setAttribute('message', $message);
}
}
?>
