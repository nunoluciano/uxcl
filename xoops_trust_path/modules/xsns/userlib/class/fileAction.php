<?php
class Xsns_File_Action extends XsnsCommonAction
{

//------------------------------------------------------------------------------

function checkAuthority($image_id, $file_id)
{
	global $xoopsUser, $xoopsUserIsAdmin;
	
	if($xoopsUserIsAdmin){
		return true;
	}
	
	if($this->isGuest()){
		return false;
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	if($image_id > 0){
		$image_handler =& XsnsImageHandler::getInstance();
		$data =& $image_handler->get($image_id);
	}
	elseif($file_id > 0){
		$file_handler =& XsnsFileHandler::getInstance();
		$data =& $file_handler->get($file_id);
	}
	else{
		return false;
	}
	
	if(!is_object($data)){
		return false;
	}
	
	$target = $data->getVar('target');
	$target_id = $data->getVar('target_id');
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$c_member_handler =& XsnsMemberHandler::getInstance();
	
	if($target == 1){
		// for community
		$community =& $commu_handler->get($target_id);
		if(!is_object($community)){
			return false;
		}
		
		$c_member =& $c_member_handler->getOne($target_id, $own_uid);
		if(!is_object($c_member)){
			return false;
		}
		
		if($own_uid == $community->getVar('uid_admin')){	// admin only
			return true;
		}
	}
	elseif($target == 2){
		// for topic/comment
		$comment_handler =& XsnsTopicCommentHandler::getInstance();
		$comment =& $comment_handler->get($target_id);
		if(!is_object($comment)){
			return false;
		}
		
		$tid = $comment->getVar('c_commu_topic_id');
		$topic_handler =& XsnsTopicHandler::getInstance();
		$topic =& $topic_handler->get($tid);
		if(!is_object($topic)){
			return false;
		}
		
		$cid = $comment->getVar('c_commu_id');
		$community =& $commu_handler->get($cid);
		if(!is_object($community)){
			return false;
		}
		
		$c_member =& $c_member_handler->getOne($cid, $own_uid);
		if(!is_object($c_member)){
			return false;
		}
		
		if($own_uid == $comment->getVar('uid')
		   || $own_uid == $topic->getVar('uid')
		   || $own_uid == $community->getVar('uid_admin')
		   || $own_uid == $community->getVar('uid_sub_admin')){
			return true;
		}
	}
	return false;
}

//------------------------------------------------------------------------------

}
?>
