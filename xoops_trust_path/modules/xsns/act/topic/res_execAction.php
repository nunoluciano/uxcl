<?php
class Xsns_Res_exec_Action extends Xsns_Topic_Action
{
function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('TOPIC_COMMENT_ADD')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$tid = $this->getIntRequest('tid');
	if(!isset($tid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$body = $this->getTextRequest('comment_body', XSNS_REQUEST_SESSION);
	if(!isset($body)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	
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
	
	// コメントの投稿
	$new_comment =& $comment_handler->create();
	$new_comment->setVars(array(
		'c_commu_topic_id' => $tid,
		'c_commu_id' => $cid,
		'uid' => $own_uid,
		'body' => $body,
		'r_datetime' => date('Y-m-d H:i:s'),
		'r_date' => date('Y-m-d'),
		'number' => $topic->getCommentCount(),
	));
	
	if($tcid = $comment_handler->insert($new_comment)){
		
		// 画像のアップロード
		$image_handler =& XsnsImageHandler::getInstance();
		$image_handler->uploadImage('t', 2, $tcid);
		
		// ファイルのアップロード
		$file_handler =& XsnsFileHandler::getInstance();
		$file_handler->uploadFile('t', 2, $tcid);
		
		// イベント通知
		if(include_once(XSNS_TRUST_PATH.'/include/notification.php')){
			$tags = array(
				'COMMU_NAME' => $community->getVar('name'),
				'TOPIC_NAME' => $topic->getVar('name'),
				'TOPIC_BODY' => $new_comment->getVar('body', 'e'),	// disallow HTML
				'AUTHOR_NAME' => $xoopsUser->getVar('uname'),
				'TOPIC_URI' => XSNS_URL_TOPIC.'&tid='.$tid,
			);
			// コミュニティメンバー以外には送信しない
			$c_member_obj_list =& $community->getMemberObjects();
			$c_member_ids = array();
			foreach($c_member_obj_list as $c_member_obj){
				$c_member_ids[] = $c_member_obj->getVar('uid');
			}
			xsns_main_trigger_event('topic', $cid, 'post', $tags, $c_member_ids);
		}
		
		$xoopsUser->incrementPost();
		$sess_handler =& XsnsSessionHandler::getInstance();
		$sess_handler->clearVars();
		
		redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, _MD_XSNS_TOPIC_ADD_RES_OK);
	}
	
	redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, _MD_XSNS_TOPIC_ADD_RES_NG);
}

}
?>
