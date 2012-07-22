<?php
class Xsns_Edit_exec_Action extends Xsns_Index_Action
{

function dispatch()
{
	if($this->isGuest() || !$this->validateToken('COMMUNITY_EDIT')){
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
	if(!is_object($community) || !$community->checkAuthority($perm)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 入力データのチェック
	$name = $this->getTextRequest('name');
	$info = $this->getTextRequest('info');
	$cat_id = $this->getIntRequest('category');
	$public_id = $this->getIntRequest('public');
	
	if(!$commu_handler->checkParams($cid, $name, $info, $cat_id, $public_id)){
		$errors = $commu_handler->getErrors();
		if(count($errors) > 0){
			$msg = "";
			foreach($errors as $err){
				$msg .= $err."<br>";
			}
			redirect_header(XSNS_URL_COMMU.'?'.XSNS_ACTION_ARG.'=edit&cid='.$cid, 3, $msg);
		}
	}
	
	$old_name = $community->getVar('name');
	
	// コミュニティ情報の更新
	$community->setVar('name', $name);
	$community->setVar('info', $info);
	$community->setVar('c_commu_category_id', $cat_id);
	$community->setVar('public_flag', $public_id);
	
	$category_handler =& XsnsCategoryHandler::getInstance();
	
	if(($cid = $commu_handler->insert($community)) && $category_handler->updateSelector()){
		
		// 画像のアップロード
		$image_handler =& XsnsImageHandler::getInstance();
		$image_handler->setFormLimit(1);
		if($image_handler->uploadImageTemp('image')){
			$image_handler->uploadImage('c', 1, $cid);
		}
		
		redirect_header(XSNS_URL_COMMU.'?cid='.$cid, 2, sprintf(_MD_XSNS_INDEX_EDIT_OK, $old_name));
	}
	redirect_header(XSNS_URL_COMMU.'?cid='.$cid, 2, _MD_XSNS_INDEX_EDIT_NG);
}

}
?>
