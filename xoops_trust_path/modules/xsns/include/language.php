<?php

function xsns_load_language($file)
{
	global $xoopsConfig, $mydirpath;
	$trustdirpath = dirname(dirname(__FILE__));
	
	$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
	if(file_exists($langmanpath)){
		require_once $langmanpath;
		$langman =& D3LanguageManager::getInstance();
		if(is_object($langman)){
			$langman->read($file, basename($mydirpath), basename($trustdirpath));
			return true;
		}
	}
	
	$language = empty($xoopsConfig['language']) ? 'japanese' : $xoopsConfig['language'];
	if(file_exists($mydirpath.'/language/'.$language.'/'.$file)){
		include_once $mydirpath.'/language/'.$language.'/'.$file;
		return true;
	}
	elseif(file_exists($trustdirpath.'/language/'.$language.'/'.$file)){
		include_once $trustdirpath.'/language/'.$language.'/'.$file;
		return true;
	}
	elseif(file_exists($trustdirpath.'/language/japanese/'.$file)){
		include_once $trustdirpath.'/language/japanese/'.$file;
		return true;
	}
	else{
		return false;
	}
}

?>