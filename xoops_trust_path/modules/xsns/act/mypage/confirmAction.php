<?php
class Xsns_Confirm_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser;
	
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$own_uid = $xoopsUser->getVar('uid');
	
	$confirm_handler =& XsnsConfirmHandler::getInstance();
	$user_handler =& XsnsUserHandler::getInstance();
	$commu_handler =& XsnsCommunityHandler::getInstance();
	
	$own_user =& $user_handler->get($own_uid);
	if(!is_object($own_user)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$criteria = new CriteriaCompo(new Criteria('uid_to', $own_uid));
	$criteria->setSort('r_datetime');
	$criteria->setOrder('DESC');
	
	$confirm_obj_list =& $confirm_handler->getObjects($criteria);
	
	$confirm_list_all = array();
	
	if(count($confirm_obj_list) > 0){
		$confirm_format = array(
			0 => array(
				'title' => _MD_XSNS_CONFIRM_JOIN_TITLE,
				'desc' => _MD_XSNS_CONFIRM_JOIN_DESC,
				'show_commu' => true,
				'show_message' => true,
				'accept_only' => false,
				),
			1 => array(
				'title' => _MD_XSNS_CONFIRM_ADMIN_TITLE,
				'desc' => _MD_XSNS_CONFIRM_ADMIN_DESC,
				'show_commu' => true,
				'show_message' => true,
				'accept_only' => false,
				),
			2 => array(
				'title' => _MD_XSNS_CONFIRM_SUB_ADMIN_TITLE,
				'desc' => _MD_XSNS_CONFIRM_SUB_ADMIN_DESC,
				'show_commu' => true,
				'show_message' => true,
				'accept_only' => false,
				),
			3 => array(
				'title' => _MD_XSNS_CONFIRM_FRIEND_TITLE,
				'desc' => _MD_XSNS_CONFIRM_FRIEND_DESC,
				'show_commu' => false,
				'show_message' => true,
				'accept_only' => false,
				),
			4 => array(
				'title' => _MD_XSNS_CONFIRM_FRIEND_DEL_TITLE,
				'desc' => _MD_XSNS_CONFIRM_FRIEND_DEL_DESC,
				'show_commu' => false,
				'show_message' => false,
				'accept_only' => true,
				),
		);
		$confirm_format_count = count($confirm_format);
		
		$user_info = $commu_info = array();
		
		foreach($confirm_obj_list as $confirm_obj){
			$rows = 2;
			$id = $confirm_obj->getVar('c_commu_confirm_id');
			$uid_from = $confirm_obj->getVar('uid_from');
			$mode = $confirm_obj->getVar('mode');
			
			if(!isset($user_info[$uid_from])){
				$user =& $user_handler->get($uid_from);
				if(is_object($user)){
					$user_info[$uid_from] =& $user->getInfo();
				}
				unset($user);
			}
			
			$cid = $confirm_obj->getVar('c_commu_id');
			if($cid > 0 && !isset($commu_info[$cid])){
				$community =& $commu_handler->get($cid);
				if(is_object($community)){
					$commu_info[$cid] =& $community->getInfo();
					$commu_info[$cid]['url'] = XSNS_URL_COMMU.'?cid='.$cid;
				}
				unset($community);
			}
			
			$form_vars = array('confirm_id' => $id);
			$form_accept = $this->getFormHeader('post', 'mypage', 'confirm_accept_exec', false, $form_vars, 'CONFIRM_ACCEPT_ID'.$id);
			$form_reject = !$confirm_format[$mode]['accept_only'] ? $this->getFormHeader('post', 'mypage', 'confirm_reject_exec', false, $form_vars, 'CONFIRM_REJECT_ID'.$id) : NULL;
			
			if($confirm_format[$mode]['show_commu']){
				$rows++;
			}
			if($confirm_format[$mode]['show_message']){
				$rows++;
			}
			
			$confirm_list[$mode][$id] = array(
				'member' => $user_info[$uid_from],
				'commu' => ($cid>0)? $commu_info[$cid] : NULL,
				'req_mode' => $mode,
				'time' => $confirm_obj->getVar('r_datetime'),
				'message' => $confirm_obj->getVar('message'),
				'show_commu' => $confirm_format[$mode]['show_commu'],
				'show_message' => $confirm_format[$mode]['show_message'],
				'accept_only' => $confirm_format[$mode]['accept_only'],
				'rows' => $rows,
				'form_accept' => $form_accept,
				'form_reject' => $form_reject,
			);
		}
		
		for($i=0; $i<$confirm_format_count; $i++){
			$req_count = isset($confirm_list[$i])? count($confirm_list[$i]) : 0;
			$confirm_list_all[$i] = array(
				'lang_title' => $confirm_format[$i]['title'],
				'lang_desc' => $confirm_format[$i]['desc'],
				'request_count' => $req_count,
				'confirm_list' => ($req_count>0)? $confirm_list[$i] : NULL,
			);
		}
	
	}
	$this->context->setAttribute('user_menu', $own_user->getMypageMenu());
	$this->context->setAttribute('confirm_list_all', $confirm_list_all);
}
}
?>
