<?php
class Xsns_Add_exec_Action extends Xsns_Topic_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('TOPIC_ADD')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$cid = $this->getIntRequest('cid');
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$topic = $sess_handler->getVar('topic');
	
	if(!is_array($topic) || !isset($topic['name']) || !isset($topic['body'])){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$r_datetime = date('Y-m-d H:i:s');
	$r_date = date('Y-m-d');
	
	$topic_handler =& XsnsTopicHandler::getInstance();
	$new_topic =& $topic_handler->create();
	
	$new_topic->setVars(array(
		'c_commu_id' => $cid,
		'name' => $topic['name'],
		'r_datetime' => $r_datetime,
		'r_date' => $r_date,
		'uid' => $own_uid,
	));
	
	if($tid = $topic_handler->insert($new_topic)){
		$comment_handler =& XsnsTopicCommentHandler::getInstance();
		$new_comment =& $comment_handler->create();
		
		$new_comment->setVars(array(
			'c_commu_topic_id' => $tid,
			'c_commu_id' => $cid,
			'uid' => $own_uid,
			'body' => $topic['body'],
			'r_datetime' => $r_datetime,
			'r_date' => $r_date,
			'number' => 0,
		));
		
		if($tcid = $comment_handler->insert($new_comment)){
			
			// トピックのコメントに対して画像を添付
			$image_handler =& XsnsImageHandler::getInstance();
			$image_ids = $image_handler->uploadImage('t', 2, $tcid);
			
			// トピックのコメントに対してファイルを添付
			$file_handler =& XsnsFileHandler::getInstance();
			$file_ids = $file_handler->uploadFile('t', 2, $tcid);
			
			// イベント通知
			if(include_once(XSNS_TRUST_PATH.'/include/notification.php')){
				$tags = array(
					'COMMU_NAME' => $community->getVar('name'),
					'TOPIC_NAME' => $new_topic->getVar('name'),
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
				xsns_main_trigger_event('topic', $cid, 'create', $tags, $c_member_ids);
			}
			
			$xoopsUser->incrementPost();
			$sess_handler->clearVars();
			
			redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, _MD_XSNS_TOPIC_ADD_OK);
		}
	}
	redirect_header(XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=add&cid='.$cid, 2, _MD_XSNS_TOPIC_ADD_NG);
}

}
?>
