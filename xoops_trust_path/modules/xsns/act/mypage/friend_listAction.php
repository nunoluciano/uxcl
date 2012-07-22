<?php
class Xsns_Friend_list_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	global $xoopsUser;
	if(!$this->checkPermissionForGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
	
	$limit = 10;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$uid = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	if(!$uid){
		$uid = ($this->isXoopsUser()) ? $xoopsUser->getVar('uid') : -1;
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($uid);
	if(!is_object($user) || $user->getVar('level') < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$is_own_page = ($own_uid == $uid)? true : false;
	
	$friend_list_temp =& $user->getFriendList($limit, $start);
	$friend_count = $user->getFriendCount();
	
	$pager = $this->getPageSelector(XSNS_URL_MYPAGE_FRIEND.'&uid='.$uid, 
						$start, $limit, count($friend_list_temp), $user->getFriendCount());
	
	$i = 0;
	$friend_list = array();
	foreach($friend_list_temp as $friend){
		if($own_uid==$uid){
			$friend_user =& $user_handler->get($friend['uid']);
			if(is_object($friend_user) && $friend_user->isFriend($own_uid)){
				$edit_menu = "<li><a href='".XSNS_URL_MYPAGE."&".XSNS_ACTION_ARG."=intro_add&uid=".$friend['uid']."'>"._MD_XSNS_TITLE_MYPAGE_INTRO."</a></li>";
			}
			else{
				$edit_menu = "";
			}
			$edit_menu = "<ul>".$edit_menu."<li><a href='".XSNS_URL_MYPAGE."&".XSNS_ACTION_ARG."=friend_del&uid=".$friend['uid']."'>"._MD_XSNS_FRIEND_DELETE."</a></li></ul>";
		}
		else{
			$edit_menu = "";
		}
		
		$friend_list[$i] = $friend;
		$friend_list[$i]['edit_menu'] = $edit_menu;
		$i++;
	}
	
	$this->context->setAttribute('user_name', $user->getVar('uname'));
	$this->context->setAttribute('friend_list', $friend_list);
	$this->context->setAttribute('pager', $pager);
	$this->context->setAttribute('is_own_page', $is_own_page);
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
}
}
?>
