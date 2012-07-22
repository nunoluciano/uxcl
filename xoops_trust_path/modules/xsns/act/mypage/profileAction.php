<?php
// $Id: edituser.php,v 1.5 2006/05/01 02:37:26 onokazu Exp $
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


class Xsns_Profile_Action extends Xsns_Mypage_Action
{

function dispatch()
{
	global $xoopsUser, $xoopsConfig;
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
	require_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
	
	$config_handler =& xoops_gethandler('config');
	if(defined('XOOPS_CUBE_LEGACY')){
		$xoopsConfigUser =& $config_handler->getConfigsByDirname('user');
		$user_config =& $xoopsConfigUser;
	}
	else{
		$xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
		$user_config =& $xoopsConfig;
	}
	
	require_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/notification.php';
	require_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
	
	$elements = array();
	
	$token_handler = new XoopsMultiTokenHandler();
	$token = new XoopsFormToken($token_handler->create('edituser'));
	
	// Hidden
	$elements['hiddens'] = array(
		array('html' => '<input type="hidden" name="'.XSNS_PAGE_ARG.'" value="mypage">'),
		array('html' => '<input type="hidden" name="'.XSNS_ACTION_ARG.'" value="profile_edit_exec">'),
		array('html' => '<input type="hidden" name="uid" value="'.$xoopsUser->getVar('uid').'">'),
		array('html' => '<input type="hidden" name="'.$token->_name.'" value="'.$token->_value.'">'),
	);
	
	// Avatar
	$elements['avatar'] = array(
		'name' => 'user_avatar',
		'value' => $xoopsUser->getVar('user_avatar'),
		'html' => '<img src="'.XOOPS_UPLOAD_URL.'/'.$xoopsUser->getVar('user_avatar').'" alt="'.$xoopsUser->getVar('uname').'" /><br>[<a href="'.XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=profile_avatar_up'.'">'._MD_XSNS_PROFILE_AVATAR_EDIT.'</a>]',
	);
	
	// E-mail
	if(@$xoopsConfigUser['allow_chgmail']){
		$email_text = '<input type="text" name="email" size="30" value="'.$xoopsUser->getVar('email', 'e').'">';
	}
	else{
		$email_text = $xoopsUser->getVar('email');
	}
	
	$elements['email'] = array(
		'name' => 'email',
		'value' => $xoopsUser->getVar('email'),
		'html' => $email_text.'<br><input type="checkbox" name="user_viewemail" value="1"'.($xoopsUser->getVar('user_viewemail') ? ' checked' : '') .'>'._US_ALLOWVIEWEMAIL,
	);
	
	// Real name
	$elements['realname'] = array(
		'name' => 'name',
		'value' => $xoopsUser->getVar('name', 'e'),
	);
	
	// Web site URL
	$elements['url'] = array(
		'name' => 'url',
		'value' => $xoopsUser->getVar('url', 'e'),
	);
	
	// ICQ
	$elements['icq'] = array(
		'name' => 'user_icq',
		'value' => $xoopsUser->getVar('user_icq', 'e'),
	);
	
	// AIM
	$elements['aim'] = array(
		'name' => 'user_aim',
		'value' => $xoopsUser->getVar('user_aim', 'e'),
	);
	
	// YIM
	$elements['yim'] = array(
		'name' => 'user_yim',
		'value' => $xoopsUser->getVar('user_yim', 'e'),
	);
	
	// MSNM
	$elements['msnm'] = array(
		'name' => 'user_msnm',
		'value' => $xoopsUser->getVar('user_msnm', 'e'),
	);
	
	// Location
	$elements['location'] = array(
		'name' => 'user_from',
		'value' => $xoopsUser->getVar('user_from', 'e'),
	);
	
	// Occupation
	$elements['occupation'] = array(
		'name' => 'user_occ',
		'value' => $xoopsUser->getVar('user_occ', 'e'),
	);
	
	// Interest
	$elements['interest'] = array(
		'name' => 'user_intrest',
		'value' => $xoopsUser->getVar('user_intrest', 'e'),
	);
	
	// Extra info
	$elements['extra'] = array(
		'name' => 'bio',
		'value' => $xoopsUser->getVar('bio', 'e'),
	);
	
	// Signature
	$sig = $xoopsUser->getVar('user_sig', 'e');
	$this->setXoopsCodeTarea('sig_xoops_codes', $sig, 'user_sig', 50, 5, null, 'sig_xoops_smilies');
	$elements['sig'] = array(
		'name' => 'user_sig',
		'value' => $sig,
	);
	
	$elements['attachsig'] = array(
		'name' => 'attachsig',
		'value' => $xoopsUser->getVar('attachsig') ? 'checked' : '',
	);
	
	// Time zone
	$timezone_offset = $xoopsUser->getVar('timezone_offset');
	$timezone_select = new XoopsFormSelectTimezone(_US_TIMEZONE, 'timezone_offset', $timezone_offset);
	$elements['timezone'] = array(
		'name' => 'timezone_offset',
		'value' => $timezone_offset,
		'html' => XsnsUtils::getSelectBoxHtml('timezone_offset', $timezone_select->_options, $timezone_offset),
	);
	
	// Event notify method
	$not_method = $xoopsUser->getVar('notify_method');
	$not_method_arr = array(
		XOOPS_NOTIFICATION_METHOD_DISABLE => _NOT_METHOD_DISABLE,
		XOOPS_NOTIFICATION_METHOD_PM => _NOT_METHOD_PM,
		XOOPS_NOTIFICATION_METHOD_EMAIL => _NOT_METHOD_EMAIL,
	);
	$elements['notify_method'] = array(
		'name' => 'notify_method',
		'value' => $not_method,
		'html' => XsnsUtils::getSelectBoxHtml('notify_method', $not_method_arr, $not_method),
	);
	
	// Event notify mode
	$not_mode = $xoopsUser->getVar('notify_mode');
	$not_mode_arr = array(
		XOOPS_NOTIFICATION_MODE_SENDALWAYS => _NOT_MODE_SENDALWAYS,
		XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE => _NOT_MODE_SENDONCE,
		XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT => _NOT_MODE_SENDONCEPERLOGIN,
	);
	$elements['notify_mode'] = array(
		'name' => 'notify_mode',
		'value' => $not_mode,
		'html' => XsnsUtils::getSelectBoxHtml('notify_mode', $not_mode_arr, $not_mode),
	);
	
	// Password
	$elements['password'] = array(
		'name' => 'password',
		'html' => '<input type="password" name="password" size="15" maxlength="32">&nbsp;&nbsp;<input type="password" name="vpass" size="15" maxlength="32">',
	);
	
	// Comment mode
	$umode = $xoopsUser->getVar('umode');
	$umode_arr = array(
		'nest' => _NESTED,
		'flat' => _FLAT,
		'thread' => _THREADED,
	);
	$elements['umode'] = array(
		'name' => 'umode',
		'value' => $umode,
		'html' => XsnsUtils::getSelectBoxHtml('umode', $umode_arr, $umode),
	);
	
	// Comment order
	$uorder = $xoopsUser->getVar('uorder');
	$uorder_arr = array(
		XOOPS_COMMENT_OLD1ST => _OLDESTFIRST,
		XOOPS_COMMENT_NEW1ST => _NEWESTFIRST,
	);
	$elements['uorder'] = array(
		'name' => 'uorder',
		'value' => $uorder,
		'html' => XsnsUtils::getSelectBoxHtml('uorder', $uorder_arr, $uorder),
	);
	
	// user cookie
	$usercookie = empty($_COOKIE[@$user_config['usercookie']]) ? 0 : 1;
	$usercookie_arr = array(1 => _YES, 0 => _NO);
	$elements['usercookie'] = array(
		'name' => 'usercookie',
		'value' => $usercookie,
		'html' => XsnsUtils::getRadioHtml('usercookie', $usercookie_arr, $usercookie),
	);
	
	// user mail ok
	$mailok = $xoopsUser->getVar('user_mailok');
	$mailok_arr = array(1 => _YES, 0 => _NO);
	$elements['mailok'] = array(
		'name' => 'user_mailok',
		'value' => $mailok,
		'html' => XsnsUtils::getRadioHtml('user_mailok', $mailok_arr, $mailok),
	);
	
	$this->context->setAttribute('user_menu', $user->getMypageMenu());
	$this->context->setAttribute('elements', $elements);
	$this->context->setAttribute('allow_self_delete', @$xoopsConfigUser['self_delete']);
}

}

?>