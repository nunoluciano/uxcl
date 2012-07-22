<?php
class Xsns_Default_Action extends Xsns_Admin_Action
{

//------------------------------------------------------------------------------

function dispatch()
{
	$err = $this->checkPermission();
	if(!is_array($err) || count($err) > 0){
		$this->context->setAttribute('perm_error', $err);
	}
	
	$gd_err = $this->checkGD();
	if(is_array($gd_err) && count($gd_err) > 0){
		$this->context->setAttribute('gd_error', $gd_err);
	}
	
	$notice = array();
	if(!$this->checkFileUploadPath()){
		$notice[] = _AM_XSNS_NOTICE_FILE_PATH;
	}
	if(!$this->replaceMypage()){
		$notice[] = _AM_XSNS_NOTICE_MYPAGE;
	}
	$this->context->setAttribute('notice', $notice);
}
//------------------------------------------------------------------------------

// マイページ ⇔ アカウント情報ページのファイル置き換え
function replaceMypage()
{
	if(defined('XOOPS_CUBE_LEGACY')){
		return true;
	}
	
	global $xoopsModuleConfig, $mydirname;
	
	$userinfo_file = XOOPS_ROOT_PATH.'/userinfo.php';
	$edituser_file = XOOPS_ROOT_PATH.'/edituser.php';
	$userinfo_file_r = XSNS_TRUST_PATH.'/x20/userinfo.php';
	$edituser_file_r = XSNS_TRUST_PATH.'/x20/edituser.php';
	$userinfo_file_b = XSNS_TRUST_PATH.'/x20/bak_userinfo.php';
	$edituser_file_b = XSNS_TRUST_PATH.'/x20/bak_edituser.php';
	
	if(file_exists($userinfo_file) && file_exists($edituser_file)){
		if($xoopsModuleConfig['mypage_use']
		   && file_exists($userinfo_file_r)
		   && file_exists($edituser_file_r)
		   && md5_file($userinfo_file) != md5_file($userinfo_file_r)
		   && md5_file($edituser_file) != md5_file($edituser_file_r)){
			
			// アカウント情報ページをバックアップ ⇒ マイページに置き換え
			@copy($userinfo_file, $userinfo_file_b);
			@copy($edituser_file, $edituser_file_b);
			@copy($userinfo_file_r, $userinfo_file);
			@copy($edituser_file_r, $edituser_file);
			
			if($handle = @fopen(XSNS_TRUST_PATH.'/x20/dirname.dat', 'w')){
				fwrite($handle, $mydirname);
				fclose($handle);
			}
			else{
				return false;
			}
		}
		elseif(!$xoopsModuleConfig['mypage_use']
			   && file_exists($userinfo_file_b)
			   && file_exists($edituser_file_b)
			   && md5_file($userinfo_file) == md5_file($userinfo_file_r)
			   && md5_file($edituser_file) == md5_file($edituser_file_r)){
			
			// 元の状態（アカウント情報ページ）に戻す
			@copy($userinfo_file_b, $userinfo_file);
			@copy($edituser_file_b, $edituser_file);
		}
		return true;
	}
	return false;
}
//------------------------------------------------------------------------------

function checkFileUploadPath()
{
	global $xoopsModuleConfig;
	if(isset($xoopsModuleConfig['file_upload_path'])){
		$file_path = str_replace('\\', '/', $xoopsModuleConfig['file_upload_path']);
		if(strstr($file_path, $_SERVER['DOCUMENT_ROOT']) === FALSE){
			return true;
		}
	}
	return false;
}
//------------------------------------------------------------------------------

function checkGD()
{
	$errors = array();
	
	if(!function_exists('gd_info')){
		$errors[] = _AM_XSNS_GD_ERR_NONE;
		return $errors;
	}
	
	$gdinfo = gd_info();
	
	if(isset($gdinfo['GD Version']) && preg_match('/\d+\.\d+\.\d+/', $gdinfo['GD Version'], $matches)){
		$gd_ver = " (GD Version ".$matches[0].")";
	}
	else{
		$gd_ver = "";
	}
	
	if(!isset($gdinfo['GIF Read Support']) || !$gdinfo['GIF Read Support'] || !function_exists('imagegif')
	   || !isset($gdinfo['GIF Create Support']) || !$gdinfo['GIF Create Support'] || !function_exists('imagecreatefromgif')){
		$errors[] = _AM_XSNS_GD_ERR_GIF. $gd_ver;
	}
	if(!isset($gdinfo['JPG Support']) || !$gdinfo['JPG Support'] || !function_exists('imagejpeg') || !function_exists('imagecreatefromjpeg')){
		$errors[] = _AM_XSNS_GD_ERR_JPG. $gd_ver;
	}
	if(!isset($gdinfo['PNG Support']) || !$gdinfo['PNG Support'] || !function_exists('imagepng') || !function_exists('imagecreatefrompng')){
		$errors[] = _AM_XSNS_GD_ERR_PNG. $gd_ver;
	}
	
	return $errors;
}

//------------------------------------------------------------------------------

}

?>
