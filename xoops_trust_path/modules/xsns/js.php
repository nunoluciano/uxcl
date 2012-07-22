<?php

$cache_limit = 3600;

$filename = preg_replace('/[^0-9a-zA-Z_.-]/', '', @$_GET['f']);

if(empty($mydirpath) || empty($mytrustdirname) || !preg_match('/\.js$/i', $filename)){
	exit;
}

$trust_path_file = dirname(__FILE__).'/js/'.$filename;

if(file_exists($trust_path_file)){
	$js_file = $trust_path_file;
}
else{
	exit;
}

if(!headers_sent()){
	session_cache_limiter('public');
	header("Expires: ".date('r',intval(time()/$cache_limit)*$cache_limit+$cache_limit));
	header("Cache-Control: public, max-age=$cache_limit");
	header("Last-Modified: ".date('r',intval(time()/$cache_limit)*$cache_limit));
	header("Content-Type: application/x-javascript");
	
	readfile($js_file);
}

exit;

?>
