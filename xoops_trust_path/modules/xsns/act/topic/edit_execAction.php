<?php
class Xsns_Edit_exec_Action extends Xsns_Topic_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('TOPIC_EDIT')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$tcid = $this->getIntRequest('tcid');
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	$image_handler =& XsnsImageHandler::getInstance();
	$file_handler =& XsnsFileHandler::getInstance();
	
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
	$community =& $commu_handler->get($topic->getVar('c_commu_id'));
	if(!is_object($community)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$commu_auth = $community->getAuthority();
	if($commu_auth < XSNS_AUTH_MEMBER){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$param = array(
		'number' => $comment->getNumber(),
		'name' => $this->getTextRequest('name'),
		'body' => $this->getTextRequest('body'),
	);
	
	$errors = array();
	
	$this->checkParam(&$param, &$errors);
	
	$temp_topic =& $topic_handler->create();
	$temp_topic->setVars(array(
		'name' => $param['name'],
	));
	
	$temp_comment =& $comment_handler->create();
	$temp_comment->setVar('body', $param['body']);
	
	if(count($errors) > 0){
		$topic_name = $temp_topic->getVar('name', 'e');
		$topic_vars = array(
			'id' => $tid,
			'tcid' => $tcid,
			'name' => empty($topic_name) ? $topic->getVar('name', 'e') : $topic_name,
		);
		
		$comment_body = $temp_comment->getVar('body', 'e');
		$comment_vars = array(
			'number' => $param['number'],
			'body' => empty($comment_body) ? $comment->getVar('body', 'e') : $comment_body,
			'images' => $comment->getImageList(2, XSNS_IMAGE_SIZE_S),
			'files' => $comment->getFileList(2),
		);
		
		$commu_vars = array(
			'id' => $cid,
			'name' => $community->getVar('name'),
		);
		
		$this->context->setAttribute('topic', $topic_vars);
		$this->context->setAttribute('commu', $commu_vars);
		$this->context->setAttribute('comment', $comment_vars);
		$this->context->setAttribute('errors', $errors);
		return "edit";	// → topic/editView.php
	}
	
	$topic_uid = $topic->getVar('uid');
	$comment_uid = $comment->getVar('uid');
	
	if($comment_uid > 0
	   && ($own_uid == $topic_uid || $own_uid == $comment_uid || $commu_auth >= XSNS_AUTH_SUB_ADMIN)){
		
		$r_datetime = date('Y-m-d H:i:s');
//		$r_date = date('Y-m-d');
		
		$topic->setVars(array(
			'name' => $param['name'],
		//	'r_datetime' => $r_datetime, // naao 編集時に、トピ日時を更新しない
//			'r_date' => $r_date,
		));
		
		if($topic_handler->insert($topic)){
			$tcid = $comment->getVar('c_commu_topic_comment_id');
			
			if($image_handler->uploadImageTemp('images')){
				$image_handler->uploadImage('t', 2, $tcid);
			}
			
			if($file_handler->uploadFileTemp('files')){
				$file_handler->uploadFile('t', 2, $tcid);
			}
			
			$comment->setVars(array(
				'body' => $param['body'],
				'number' => $param['number'],
		//		'r_datetime' => $r_datetime, // naao 編集時に、トピ日時を更新しない
//				'r_date' => $r_date,
			));
			
			if($comment_handler->insert($comment)){
				$msg = ($param['number']==0)? _MD_XSNS_TOPIC_EDIT_OK : _MD_XSNS_TOPIC_EDIT_RES_OK;
			}
			else{
				$msg = ($param['number']==0)? _MD_XSNS_TOPIC_EDIT_NG : _MD_XSNS_TOPIC_EDIT_RES_NG;
			}
		}
		else{
			$msg = _MD_XSNS_TOPIC_EDIT_NG;
		}
		redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, $msg);
	}
	redirect_header(XOOPS_URL, 2, _NOPERM);
}

}
?>
