<?php
class Xsns_Add_exec_Action extends Xsns_Index_Action
{
function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest() || !$this->validateToken('COMMUNITY_ADD')){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $xoopsUser->getVar('uid');
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$commu = $sess_handler->getVar('community');
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	if(!$commu_handler->checkParams(0, $commu['name'], $commu['info'], $commu['cat_id'], $commu['public_id'])){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$new_community =& $commu_handler->create();
	$new_community->setVars(array(
		'name' => $commu['name'],
		'uid_admin' => $own_uid,
		'uid_sub_admin' => 0,
		'info' => $commu['info'],
		'c_commu_category_id' => $commu['cat_id'],
		'r_datetime' => date('Y-m-d H:i:s'),
		'r_date' => date('Y-m-d'),
		'public_flag' => $commu['public_id'],
	));
	
	$category_handler =& XsnsCategoryHandler::getInstance();
	
	if(($cid = $commu_handler->insert($new_community)) && $category_handler->updateSelector()){
		
		// 作成したコミュニティに対して画像を追加
		$image_handler =& XsnsImageHandler::getInstance();
		$image_handler->setFormLimit(1);
		$image_handler->uploadImage('c', 1, $cid);
		
		// コミュニティの作成者をメンバーに追加
		$c_member_handler =& XsnsMemberHandler::getInstance();
		$new_member =& $c_member_handler->create();
		$new_member->setVars(array(
			'uid' => $own_uid,
			'c_commu_id' => $cid,
			'r_datetime' => date('Y-m-d H:i:s'),
		));
		
		if($c_member_handler->insert($new_member)){
			$sess_handler->clearVars();
			redirect_header(XSNS_URL_COMMU.'?cid='.$cid, 2, _MD_XSNS_INDEX_ADD_OK);
		}
	}
	redirect_header(XSNS_URL_COMMU.'?'.XSNS_ACTION_ARG.'=add', 2, _MD_XSNS_INDEX_ADD_NG);
}

}
?>
