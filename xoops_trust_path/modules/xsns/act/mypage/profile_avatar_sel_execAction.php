<?php
// $Id: edituser.php,v 1.5 2006/05/01 02:37:26 onokazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //


class Xsns_Profile_avatar_sel_exec_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	require XSNS_FRAMEWORK_DIR.'/global.php';
	require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';

	//if (!$this->validateToken('choose') || !is_object($xoopsUser) || !isset($_POST['avatar_id']) || !is_array($_POST['avatar_id']) || count($_POST['avatar_id'])>1) {
	if (!$this->validateToken('choose') || !is_object($xoopsUser) || !isset($_POST['avatar_id']) || count($_POST['avatar_id'])>1) { //naao
		redirect_header(XSNS_URL_MYPAGE_PROFILE, 3, _US_NOEDITRIGHT);
	}
	
	// Check is K-TAI?
	if (defined('HYP_K_TAI_RENDER') && HYP_K_TAI_RENDER) {
		$avatar_id = $_POST['avatar_id'] ;
	} else {
		global $xoopsTpl;
		if ($xoopsTpl->_tpl_vars['wizmobile_ismobile']) {
			$avatar_id = $_POST['avatar_id'] ;
		} else {
			foreach($_POST['avatar_id'] as $id => $value){
				$avatar_id = $id;
				break;
			}
		}
	}
	
	$avt_handler =& xoops_gethandler('avatar');
	if($avatar_id > 0){
		$criteria = new CriteriaCompo(new Criteria('a.avatar_id', $avatar_id));
		$criteria->add(new Criteria('a.avatar_type', 'S'));
		$avatars =& $avt_handler->getObjects($criteria);
		if (!is_array($avatars) || !is_object($avatars[0])) {
			redirect_header(XSNS_URL_MYPAGE_PROFILE, 3, _US_NOEDITRIGHT);
		}
		$user_avatar_object =& $avatars[0];
		$user_avatar = $avatars[0]->getVar('avatar_file');
	}
	else{
		$user_avatar_object = false;
		$user_avatar = 'blank.gif';
	}
	$user_avatarpath = str_replace("\\", "/", realpath(XOOPS_UPLOAD_PATH.'/'.$user_avatar));
	
	if (0 === strpos($user_avatarpath, XOOPS_UPLOAD_PATH) && is_file($user_avatarpath)) {
		$oldavatar = $xoopsUser->getVar('user_avatar');
		$xoopsUser->setVar('user_avatar', $user_avatar);
		$member_handler =& xoops_gethandler('member');
		if (!$member_handler->insertUser($xoopsUser)) {
			require_once XOOPS_ROOT_PATH.'/header.php';
			echo $xoopsUser->getHtmlErrors();
			require_once XOOPS_ROOT_PATH.'/footer.php';
		}
		if ($oldavatar && $oldavatar != 'blank.gif' && preg_match("/^cavt/", strtolower($oldavatar))) {
			$ts =& MyTextSanitizer::getInstance();
			$criteria = new CriteriaCompo(new Criteria('avatar_file', $ts->addSlashes($oldavatar)));
			$criteria->add(new Criteria('avatar_type', 'C'));
			$avatars =& $avt_handler->getObjects($criteria);
			if (is_object($avatars[0])) {
				$avt_handler->delete($avatars[0]);
			}
			$oldavatar_path = str_replace("\\", "/", realpath(XOOPS_UPLOAD_PATH.'/'.$oldavatar));
			if (0 === strpos($oldavatar_path, XOOPS_UPLOAD_PATH) && is_file($oldavatar_path)) {
				unlink($oldavatar_path);
			}
		}
		if (is_object($user_avatar_object)) {
			$avt_handler->addUser($user_avatar_object->getVar('avatar_id'), $xoopsUser->getVar('uid'));
		}
	}
	redirect_header(XSNS_URL_MYPAGE_PROFILE, 2, _US_PROFUPDATED);
}

}

?>