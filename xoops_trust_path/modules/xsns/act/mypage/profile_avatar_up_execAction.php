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


class Xsns_Profile_avatar_up_exec_Action extends Xsns_Mypage_Action
{
function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	require XSNS_FRAMEWORK_DIR.'/global.php';
	require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';
	
	if (!$this->validateToken('upload')) {
		redirect_header(XSNS_URL_MYPAGE_PROFILE, 3, _US_NOEDITRIGHT);
	}
	$config_handler =& xoops_gethandler('config');
	if(defined('XOOPS_CUBE_LEGACY')){
		$xoopsConfigUser =& $config_handler->getConfigsByDirname('user');
	}
	else{
		$xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
	}
	
	$xoops_upload_file = array();
	$uid = 0;
	if (!empty($_POST['xoops_upload_file']) && is_array($_POST['xoops_upload_file'])){
		$xoops_upload_file = $_POST['xoops_upload_file'];
	}
	if (!empty($_POST['uid'])) {
		$uid = intval($_POST['uid']);
	}
	if (empty($uid) || $xoopsUser->getVar('uid') != $uid ) {
		redirect_header(XSNS_URL_MYPAGE_PROFILE, 3, _US_NOEDITRIGHT);
	}
	if ($xoopsConfigUser['avatar_allow_upload'] == 1 && $xoopsUser->getVar('posts') >= $xoopsConfigUser['avatar_minposts']) {
		require_once XOOPS_ROOT_PATH.'/class/uploader.php';
		$uploader = new XoopsMediaUploader(XOOPS_UPLOAD_PATH, array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'), $xoopsConfigUser['avatar_maxsize'], $xoopsConfigUser['avatar_width'], $xoopsConfigUser['avatar_height']);
		$uploader->setAllowedExtensions(array('gif', 'jpeg', 'jpg', 'png'));
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			$uploader->setPrefix('cavt');
			if ($uploader->upload()) {
				$avt_handler =& xoops_gethandler('avatar');
				$avatar =& $avt_handler->create();
				$avatar->setVar('avatar_file', $uploader->getSavedFileName());
				$avatar->setVar('avatar_name', $xoopsUser->getVar('uname'));
				$avatar->setVar('avatar_mimetype', $uploader->getMediaType());
				$avatar->setVar('avatar_display', 1);
				$avatar->setVar('avatar_type', 'C');
				if (!$avt_handler->insert($avatar)) {
					@unlink($uploader->getSavedDestination());
				}
				else {
					$oldavatar = $xoopsUser->getVar('user_avatar');
					if (!empty($oldavatar) && $oldavatar != 'blank.gif' && !preg_match("/^savt/", strtolower($oldavatar))) {
						$avatars =& $avt_handler->getObjects(new Criteria('avatar_file', $oldavatar));
						$avt_handler->delete($avatars[0]);
						$oldavatar_path = str_replace("\\", "/", realpath(XOOPS_UPLOAD_PATH.'/'.$oldavatar));
						if (0 === strpos($oldavatar_path, XOOPS_UPLOAD_PATH) && is_file($oldavatar_path)) {
							unlink($oldavatar_path);
						}
					}
					$sql = sprintf("UPDATE %s SET user_avatar = %s WHERE uid = %u", $this->db->prefix('users'), $this->db->quoteString($uploader->getSavedFileName()), $xoopsUser->getVar('uid'));
					$this->db->query($sql);
					$avt_handler->addUser($avatar->getVar('avatar_id'), $xoopsUser->getVar('uid'));
					redirect_header(XSNS_URL_MYPAGE_PROFILE, 2, _US_PROFUPDATED);
				}
			}
		}
		redirect_header(XSNS_URL_MYPAGE_PROFILE, 2, _MD_XSNS_PROFILE_AVATAR_UPLOAD_NG);
	}
	redirect_header(XSNS_URL_MYPAGE_PROFILE, 2, _MD_XSNS_PROFILE_AVATAR_UPLOAD_NG);
}

}

?>