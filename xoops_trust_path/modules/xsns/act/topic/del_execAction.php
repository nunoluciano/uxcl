<?php
class Xsns_Del_exec_Action extends Xsns_Topic_Action
{

function dispatch()
{
	global $xoopsUser;
	if($this->isGuest() || !$this->validateToken('TOPIC_DELETE')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$tcid = $this->getIntRequest('tcid');
	if(!isset($tcid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	
	// �����Ȥμ���
	$comment =& $comment_handler->get($tcid);
	if(!is_object($comment)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$tid = $comment->getVar('c_commu_topic_id');
	$num = $comment->getNumber();
	
	// �ȥԥå��μ���
	$topic =& $topic_handler->get($tid);
	if(!is_object($topic)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$topic_uid = $topic->getVar('uid');
	
	// ���ߥ�˥ƥ��μ���
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
	
	if($num > 0){
		// �����Ȥκ�� ������ ��Ƽԡ���ʸ�ǡ����Τߺ������
		$comment->setVar('uid', 0);
		$comment->setVar('body', '');
		
		if($comment_handler->insert($comment)){
			// �����Ȥ�ź�դ��줿�������ե��������
			$criteria = new CriteriaCompo(new Criteria('target', 2));
			$criteria->add(new Criteria('target_id', $tcid));
			$image_handler =& XsnsImageHandler::getInstance();
			$image_handler->deleteObjects($criteria);
			$file_handler =& XsnsFileHandler::getInstance();
			$file_handler->deleteObjects($criteria);
			
			redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, _MD_XSNS_TOPIC_DEL_RES_OK);
		}
		redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, _MD_XSNS_TOPIC_DEL_RES_NG);
	}
	else{
		// �ȥԥå��κ�� ������ �ȥԥå�����ӥ����Ȥ����˺������
		if($topic->deleteCommentsAll() && $topic_handler->delete($topic)){
			redirect_header(XSNS_URL_COMMU.'?cid='.$cid, 2, _MD_XSNS_TOPIC_DEL_OK);
		}
		redirect_header(XSNS_URL_TOPIC.'&tid='.$tid, 2, _MD_XSNS_TOPIC_DEL_NG);
	}
}
}
?>
