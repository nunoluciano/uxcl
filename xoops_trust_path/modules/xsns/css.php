<?php

ini_set('default_charset', 'EUC-JP');

$cache_limit = 3600;

$filename = preg_replace('/[^0-9a-zA-Z_.-]/', '', @$_GET['f']);

if(empty($mydirpath) || empty($mytrustdirname) || !preg_match('/\.css$/i', $filename)){
	exit;
}

$root_path_file = realpath($mydirpath.'/css/'.$filename);
$trust_path_file = realpath(dirname(__FILE__).'/templates/'.$filename);

if(is_file($root_path_file) && file_exists($root_path_file)){
	$css_file = $root_path_file;
	$is_template = false;
}
elseif(is_file($trust_path_file) && file_exists($trust_path_file)){
	$css_file = $trust_path_file;
	$is_template = true;
}
else{
	exit;
}

// send header
if( ! headers_sent() ) {
	session_cache_limiter('public');
	header("Expires: ".date('r',intval(time()/$cache_limit)*$cache_limit+$cache_limit));
	header("Cache-Control: public, max-age=$cache_limit");
	header("Last-Modified: ".date('r',intval(time()/$cache_limit)*$cache_limit));
	header('Content-Type: text/css') ;
	
	if($is_template){
		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl = new XoopsTpl() ;
		$tpl->display('db:'.$mydirname.'_'.$filename) ;
	}
	else{
		echo file_get_contents($css_file);
	}
}

exit;

?>
