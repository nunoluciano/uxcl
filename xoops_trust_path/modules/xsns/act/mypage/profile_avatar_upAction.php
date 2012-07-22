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


class Xsns_Profile_avatar_up_Action extends Xsns_Mypage_Action
{

	function dispatch()
	{
		require XSNS_FRAMEWORK_DIR.'/global.php';
		
		if($this->isGuest()){
			redirect_header(XOOPS_URL, 2, _NOPERM);
		}
		
		$user_handler =& XsnsUserHandler::getInstance();
		$user =& $user_handler->get($xoopsUser->getVar('uid'));
		if(!is_object($user)){
			redirect_header(XOOPS_URL, 2, _NOPERM);
		}
		
		require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/user.php';
		
		$config_handler =& xoops_gethandler('config');
		if(defined('XOOPS_CUBE_LEGACY')){
			$xoopsConfigUser =& $config_handler->getConfigsByDirname('user');
		}
		else{
			$xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
		}
		
		$token_handler = new XoopsMultiTokenHandler();
		
		if ($xoopsConfigUser['avatar_allow_upload'] == 1 && $xoopsUser->getVar('posts') >= $xoopsConfigUser['avatar_minposts']) {
			$form = new XoopsThemeForm(_MD_XSNS_PROFILE_AVATAR_EDIT, 'avatarform', XSNS_URL_MYPAGE_PROFILE);
			$form->setExtra('enctype="multipart/form-data"');
			$form->addElement(new XoopsFormLabel(_US_MAXPIXEL, $xoopsConfigUser['avatar_width'].' x '.$xoopsConfigUser['avatar_height'].' (px)'));
			$form->addElement(new XoopsFormLabel(_US_MAXIMGSZ, number_format($xoopsConfigUser['avatar_maxsize']).' (bytes)'));
			$form->addElement(new XoopsFormFile(_US_SELFILE, 'avatarfile', $xoopsConfigUser['avatar_maxsize']), true);
			$form->addElement(new XoopsFormHidden(XSNS_ACTION_ARG, 'profile_avatar_up_exec'));
			$form->addElement(new XoopsFormToken($token_handler->create('upload')));
			$form->addElement(new XoopsFormHidden('uid', $xoopsUser->getVar('uid')));
			$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
			$this->context->setAttribute('form', $form);
		}
		
		require_once XSNS_USERLIB_DIR.'/avatar.class.php';
		$avatar_handler =& XsnsAvatarHandler::getInstance();
		$avatar_list_temp =& $avatar_handler->getList('S');
		
		foreach($avatar_list_temp as $avatar_temp){
			$avatar_list[] = array(
				'id' => $avatar_temp['id'],
				'name' => $avatar_temp['name'],
				'file' => XOOPS_UPLOAD_URL.'/'.$avatar_temp['file'],
			);
		}
		$mod = count($avatar_list)%4;
		if($mod){
			for($i=0; $i<4-$mod; $i++){
				$avatar_list[] = array();
			}
		}
		
		if(is_array($avatar_list)){
			$form2 = new XoopsThemeForm(_US_CHOOSEAVT, 'uploadavatar', XSNS_URL_MYPAGE);
			$form2->addElement(new XoopsFormHidden(XSNS_ACTION_ARG, 'profile_avatar_sel_exec'));
			$form2->addElement(new XoopsFormToken($token_handler->create('choose')));
			
			$this->context->setAttribute('avatar_list', $avatar_list);
			$this->context->setAttribute('form2', $form2);
		}
		
		$avatar_file = $xoopsUser->getVar('user_avatar');
		if($avatar_file != 'blank.gif'){
			$this->context->setAttribute('old_avatar', XOOPS_UPLOAD_URL.'/'.$avatar_file);
		}
		$this->context->setAttribute('user_menu', $user->getMypageMenu());
	}

}

?>