<?php
class XsnsCommonAction extends XsnsAction
{

//------------------------------------------------------------------------------

function getIntRequest($key, $req_type=XSNS_REQUEST_POST)
{
	$value = $this->getRequestVar($key, $req_type);
	if(!isset($value)){
		return NULL;
	}
	return intval($value);
}
//------------------------------------------------------------------------------

function getTextRequest($key, $req_type=XSNS_REQUEST_POST, $sanitize_mode=NULL)
{
	$value = $this->getRequestVar($key, $req_type);
	if(!isset($value)){
		return NULL;
	}
	
	$ts =& XsnsTextSanitizer::getInstance();
	switch($sanitize_mode){
		case XOBJ_DTYPE_STRING:
		case XOBJ_DTYPE_TXTBOX:
			$value = $ts->makeTboxData4PreviewInForm($value);
			break;
		
		case XOBJ_DTYPE_TEXT:
		case XOBJ_DTYPE_TXTAREA:
			$value = $ts->makeTareaData4PreviewInForm($value);
			break;
		
		default:
			break;
	}
	
	return $value;
}
//------------------------------------------------------------------------------

function getRequestVar($key, $req_type=XSNS_REQUEST_POST)
{
	if($req_type==XSNS_REQUEST_POST){
		$value = isset($_POST[$key]) ? $_POST[$key] : NULL;
	}
	elseif($req_type==XSNS_REQUEST_GET){
		$value = isset($_GET[$key]) ? $_GET[$key] : NULL;
	}
	elseif($req_type==XSNS_REQUEST_SESSION){
		$sess_handler =& XsnsSessionHandler::getInstance();
		$value = $sess_handler->getVar($key);
	}
	else{
		return NULL;
	}
	return $value;
}
//------------------------------------------------------------------------------

function isXoopsUser()
{
	global $xoopsUser;
	if(is_object($xoopsUser) && strtolower(get_class($xoopsUser)) == 'xoopsuser'){
		return true;
	}
	return false;
}
//------------------------------------------------------------------------------

function isGuest()
{
	if($this->isXoopsUser()){
		global $xoopsUser;
		return in_array(XOOPS_GROUP_ANONYMOUS, $xoopsUser->getGroups());
	}
	return true;
}
//------------------------------------------------------------------------------

function getFormHeader($method='post', $target='', $action='', $upload=false, $hidden_vars=NULL, $token_name=NULL)
{
	$page_html = (empty($target))? 
		"" : "<input type=\"hidden\" name=\"".XSNS_PAGE_ARG."\" value=\"".$target."\">\n";
	$action_html = (empty($action))? 
		"" : "<input type=\"hidden\" name=\"".XSNS_ACTION_ARG."\" value=\"".$action."\">\n";
	$upload_html = ($upload)? " enctype=\"multipart/form-data\"" : "";
	
	$form = "<form action=\"index.php\" method=\"".$method."\"".$upload_html.">\n".
			$page_html. $action_html;
	
	if(is_array($hidden_vars)){
		foreach($hidden_vars as $key => $value){
			$form .= "<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\">\n";
		}
	}
	if(!is_null($token_name)){
		$token_handler = new XoopsMultiTokenHandler();
		$token =& $token_handler->create($token_name);
		$form .= $token->getHtml();
	}
	
	return $form;
}
//------------------------------------------------------------------------------

function setXoopsCodeTarea($code_id, $content, $textarea_id, $cols=60, $rows=15, $suffix=null, $smilies_id=null)
{
	if(empty($code_id)){
		return;
	}
	require_once XSNS_TRUST_PATH.'/include/xoopscodes.php';
	
	$GLOBALS[$textarea_id] = $content;
	
	ob_start();
	xsns_xoops_code_tarea($textarea_id, $cols, $rows, $suffix);
	$this->context->setAttribute($code_id, ob_get_contents());
	ob_end_clean();
	
	unset($GLOBALS[$textarea_id]);
	
	if(!empty($smilies_id)){
		ob_start();
		xsns_xoops_smilies($textarea_id);
		$this->context->setAttribute($smilies_id, ob_get_contents());
		ob_end_clean();
	}
}
//------------------------------------------------------------------------------

function getPageSelector($base_url, $start, $limit, $data_count, $total, $color=NULL)
{
	global $xoopsConfig;
	
	if($start < 0 || $limit < 1 || $total < 1 || $data_count < 1){
		return NULL;
	}
	
	$page_id = intval($start/$limit);
	$page_count = 1 + intval(($total-1)/$limit);
	if($page_id > $page_count-1){
		return NULL;
	}
	
	if($page_count > 10){
		$page_start = $page_id - 4;
		$page_end =   $page_id + 6;
		if($page_start < 0){
			$page_start = 0;
			$page_end = 10;
		}
		if($page_end > $page_count){
			$page_end = $page_count;
			$page_start = $page_end - 10;
		}
	}
	else{
		$page_start = 0;
		$page_end = $page_count;
	}
	
	$pages = array();
	
	$style = is_null($color) ? " class=\"selectedPage\"" : " style=\"background-color:".$color."\";";
	$html = "|";
	for($i=$page_start; $i<$page_end; $i++){
		if($page_id == $i){
			$html.= "<span ".$style."> ".($i+1)." </span>|";
			$selected = true;
		}
		else{
			$url = $base_url."&s=".($i*$limit);
			$html.= "<a href=\"".$url."\"> ".($i+1)." </a>|";
			$selected = false;
		}
		$pages[] = array(
			'number' => $i,
			'url' => str_replace("?&", "?", $base_url."&s=".($i*$limit)),
			'selected' => $selected,
		);
	}
	
	$pager = array(
		'pages' => $pages,
		'number' => $page_id,
		'start' => 1 + $start,
		'end' => $start + $data_count,
		'total' => $total,
		'html' => str_replace("?&", "?", $html),
	);
	
	$this->context->setAttribute('_pager', $pager);
	
	if(defined('_MD_XSNS_PAGE_SELECT_DESC')){
		if(@$xoopsConfig['language']=='english'){
			$description = sprintf(_MD_XSNS_PAGE_SELECT_DESC, 1+$start, $start+$data_count, $total);
		}
		else{
			$description = sprintf(_MD_XSNS_PAGE_SELECT_DESC, $total, 1+$start, $start+$data_count);
		}
	}
	elseif(defined('_AM_XSNS_PAGE_SELECT_DESC')){
		if(@$xoopsConfig['language']=='english'){
			$description = sprintf(_AM_XSNS_PAGE_SELECT_DESC, 1+$start, $start+$data_count, $total);
		}
		else{
			$description = sprintf(_AM_XSNS_PAGE_SELECT_DESC, $total, 1+$start, $start+$data_count);
		}
	}
	else{
		$description = "";
	}
	return array('selector' => str_replace("?&", "?", $html), 'description' => $description);
}
//------------------------------------------------------------------------------

function validateToken($name, $clearIfValid=true)
{
	$token_handler = new XoopsMultiTokenHandler();
	return $token_handler->autoValidate($name, $clearIfValid);
}
//------------------------------------------------------------------------------

}
?>
