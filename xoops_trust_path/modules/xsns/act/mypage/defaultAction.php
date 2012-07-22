<?php
// $Id: userinfo.php,v 1.3 2006/05/01 02:37:26 onokazu Exp $
//	------------------------------------------------------------------------ //
//				  XOOPS - PHP Content Management System 					 //
//					  Copyright (c) 2000 XOOPS.org							 //
//						 <http://www.xoops.org/>							 //
//	------------------------------------------------------------------------ //
//	This program is free software; you can redistribute it and/or modify	 //
//	it under the terms of the GNU General Public License as published by	 //
//	the Free Software Foundation; either version 2 of the License, or		 //
//	(at your option) any later version. 									 //
//																			 //
//	You may not change or alter any portion of this comment or credits		 //
//	of supporting developers from this source code or any supporting		 //
//	source code which is considered copyrighted (c) material of the 		 //
//	original comment or credit authors. 									 //
//																			 //
//	This program is distributed in the hope that it will be useful, 		 //
//	but WITHOUT ANY WARRANTY; without even the implied warranty of			 //
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 //
//	GNU General Public License for more details.							 //
//																			 //
//	You should have received a copy of the GNU General Public License		 //
//	along with this program; if not, write to the Free Software 			 //
//	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//	------------------------------------------------------------------------ //


class Xsns_Default_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	$blog_limit = 10;
	$topic_limit = 5;
	$intro_limit = 5;
	
	global $xoopsUser, $xoopsModuleConfig;
	if(!$this->checkPermissionForGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$own_uid = $this->isGuest() ? 0 : $xoopsUser->getVar('uid');
	
	$uid = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	if(!$uid){
		$uid = $own_uid;
	}
	
	$user_handler =& XsnsUserHandler::getInstance();
	$user =& $user_handler->get($uid);
	if(!is_object($user) || $user->getVar('level') < 1){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	if($uid == $own_uid){
		$is_own_page = true;
		$is_friend_page = false;
		
		// Information List
		$info_list =& $user->getInformationList();
	}
	else{
		$is_own_page = false;
		$own =& $user_handler->get($own_uid);
		if(is_object($own)){
			$is_friend_page = $own->isFriend($uid);
			
			// Add Footprint
			if($xoopsModuleConfig['use_footprint']){
				$footprint_handler =& XsnsFootprintHandler::getInstance();
				$footprint_handler->add($uid, $own_uid);
			}
		}
		else{
			$is_friend_page = false;
		}
		$info_list = NULL;
	}
	
	if($is_own_page || $is_friend_page){
		if($is_own_page){
			// Topic List
			$topic_list =& $user->getTopicList($topic_limit, 0);
			$topic_count_all = $user->getTopicCount();
			
			// Friend's Blog List
			$blog_list =& $user->getFriendBlogList($blog_limit, 0, &$blog_count_all);
		}
		else{
			$topic_list = array();
			$topic_count_all = 0;
			
			// My Blog List
			$blog_list =& $user->getMyBlogList($blog_limit, 0, &$blog_count_all);
		}
	}
	else{
		$friend_list = $topic_list = $blog_list = array();
		$topic_count_all = $blog_count_all = 0;
	}
	
	// Friend List
	$friend_list =& $user->getFriendList(9, 0, true);
	$friend_count = count($friend_list);
	if($friend_count%3 > 0){
		for($i=0; $i<(3-$friend_count%3); $i++){
			$friend_list[] = array();
		}
	}
	$friend_count_all = $user->getFriendCount();
	
	// Community List
	$commu_list =& $user->getCommunityList(9, 0, true);
	$commu_count = count($commu_list);
	if($commu_count%3 > 0){
		for($i=0; $i<(3-$commu_count%3); $i++){
			$commu_list[] = array();
		}
	}
	$commu_count_all = $user->getCommunityCount();
	
	// Introduction List
	$intro_list =& $user->getIntroList($intro_limit, 0, true);
	$intro_count_all = $user->getIntroCount();
	
	// Output
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
	$this->context->setAttribute('user_info', $this->getUserInfo($uid));
	
	$this->context->setAttribute('info_list', $info_list);
	$this->context->setAttribute('friend_list', $friend_list);
	$this->context->setAttribute('commu_list', $commu_list);
	$this->context->setAttribute('topic_list', $topic_list);
	$this->context->setAttribute('blog_list', $blog_list);
	$this->context->setAttribute('intro_list', $intro_list);
	
	$this->context->setAttribute('friend_count', $friend_count_all);
	$this->context->setAttribute('commu_count', $commu_count_all);
	$this->context->setAttribute('topic_count', $topic_count_all);
	$this->context->setAttribute('blog_count', $blog_count_all);
	$this->context->setAttribute('intro_count', $intro_count_all);
	
	$this->context->setAttribute('is_own_page', $is_own_page);
	$this->context->setAttribute('is_friend_page', $is_friend_page);

}
//------------------------------------------------------------------------------

function getUserInfo($uid)
{
	global $xoopsUser, $xoopsConfig, $xoopsUserIsAdmin;
	require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';
	
	$user_handler =& xoops_gethandler('user');
	$user =& $user_handler->get($uid);
	
	if($xoopsUserIsAdmin
	   || (is_object($xoopsUser) && $uid==$xoopsUser->getVar('uid'))
	   || (is_object($user) && $user->getVar('user_viewemail'))){
		$email = $user->getVar('email');
	}
	else{
		$email = NULL;
	}
	
	if (is_object($xoopsUser)) {
		$pmlink = "<a href=\"javascript:openWithSelfMain('".XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$uid."', 'pmlite', 450, 380);\"><img src=\"".XOOPS_URL."/images/icons/pm.gif\" alt=\"".sprintf(_SENDPMTO,$user->getVar('uname'))."\" /></a>";
	}
	else {
		$pmlink = NULL;
	}
	
	$userrank =& $user->rank();
	if ($userrank['image']) {
		$ranktitle = $userrank['title'];
		$rankimage = '<img src="'.XOOPS_UPLOAD_URL.'/'.$userrank['image'].'" alt="" />';
	}
	else{
		$ranktitle = $rankimage = NULL;
	}
	$websiteurl = $user->getVar('url');
	$uname = $user->getVar('uname');
	
	$user_info = array(
		'id' => $uid,
		'avatarurl' => '<img src="'.XOOPS_URL.'/uploads/'.$user->getVar('user_avatar').'" alt="'.$uname.'" />',
		'name' => $uname,
		'realname' => $user->getVar('name'),
		'rank' => $rankimage,
		'ranktitle' => $ranktitle,
		'posts' => $user->getVar('posts'),
		'websiteurl' => !empty($websiteurl)? '<a href="'.$user->getVar('url').'" target="_blank">'.$websiteurl.'</a>' : NULL,
		'last_login' => $user->getVar('last_login'),
		'reg_date' => $user->getVar('user_regdate'),
		'email' => $email,
		'pmlink' => $pmlink,
		'icq' => $user->getVar('user_icq'),
		'aim' => $user->getVar('user_aim'),
		'yim' => $user->getVar('user_yim'),
		'msnm' => $user->getVar('user_msnm'),
		'location' => $user->getVar('user_from'),
		'occupation' => $user->getVar('user_occ'),
		'interest' => $user->getVar('user_intrest'),
		'signature' => $user->getVar('user_sig'),
		'extrainfo' => $user->getVar('bio'),
	);
	return $user_info;
}
//------------------------------------------------------------------------------
}
?>
