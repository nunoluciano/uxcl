<?php
class Xsns_Del_exec_Action extends Xsns_Index_Action
{
function dispatch()
{
	if($this->isGuest() || !$this->validateToken('COMMUNITY_DELETE')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$cid = $this->getIntRequest('cid');
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$perm = XSNS_AUTH_XOOPS_ADMIN | XSNS_AUTH_ADMIN;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority($perm) || $community->getTopicCount() > 0){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$old_name = $community->getVar('name');
	
	if($commu_handler->delete($community)){
		
		$category_handler =& XsnsCategoryHandler::getInstance();
		if($category_handler->updateSelector()){
			
			$criteria = new Criteria('c_commu_id', $cid);
			
			// 所属メンバーデータの削除
			$c_member_handler =& XsnsMemberHandler::getInstance();
			$c_member_handler->deleteObjects($criteria);
			
			// 依頼データの削除
			$confirm_handler =& XsnsConfirmHandler::getInstance();
			$confirm_handler->deleteObjects($criteria);
			
			// アクセスログの削除
			$access_log_handler =& XsnsAccessLogHandler::getInstance();
			$access_log_handler->deleteObjects($criteria);
			
			// 画像の削除
			$image_criteria = new CriteriaCompo(new Criteria('target', 1));
			$image_criteria->add(new Criteria('target_id', $cid));
			$image_handler =& XsnsImageHandler::getInstance();
			$image_handler->deleteObjects($image_criteria);
			
			redirect_header(XSNS_URL_COMMU, 2, sprintf(_MD_XSNS_INDEX_DEL_OK, $old_name));
		}
	}
	redirect_header(XSNS_URL_COMMU, 2, _MD_XSNS_INDEX_DEL_NG);
}
}
?>
