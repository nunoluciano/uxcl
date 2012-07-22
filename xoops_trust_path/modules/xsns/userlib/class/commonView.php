<?php
class XsnsCommonView extends XsnsView
{

//------------------------------------------------------------------------------

function assignCommonVars()
{
	global $xoopsModuleConfig, $mydirname;
	
	$this->tpl->assign(array(
		'mydirname' => $mydirname,
		'mod_url' => XOOPS_URL.'/modules/'.$mydirname,
		'mod_config' => $xoopsModuleConfig,
	));
}

//------------------------------------------------------------------------------

function assignStyleSheet($filename=NULL)
{
	$html = '<link rel="stylesheet" type="text/css" media="screen" href="'.XSNS_CSS_URL.'common.css" />';
	if(!is_null($filename)){
		$html.= '<link rel="stylesheet" type="text/css" media="screen" href="'.XSNS_CSS_URL.$filename.'" />';
	}
	//$this->tpl->assign('xoops_module_header', $html);
	$this->tpl->assign('xoops_module_header', $this->tpl->get_template_vars( 'xoops_module_header' ).$html);
}
//------------------------------------------------------------------------------

function assignHeader($css_file=NULL, $js_file=NULL)
{
	$html = '<script type="text/javascript" src="'.XOOPS_URL.'/include/xoops.js"></script>';
	$html .= '<link rel="stylesheet" type="text/css" media="screen" href="'.XSNS_CSS_URL.'common.css" />';
	if(!is_null($css_file)){
		if(is_array($css_file)){
			foreach($css_file as $css){
				$html.= '<link rel="stylesheet" type="text/css" media="screen" href="'.XSNS_CSS_URL.$css.'" />';
			}
		}
		else{
			$html.= '<link rel="stylesheet" type="text/css" media="screen" href="'.XSNS_CSS_URL.$css_file.'" />';
		}
	}
	
	if(!is_null($js_file)){
		if(is_array($js_file)){
			foreach($js_file as $js){
				$html.= '<script type="text/javascript" src="'.XSNS_JS_URL.$js.'"></script>';
			}
		}
		else{
			$html.= '<script type="text/javascript" src="'.XSNS_JS_URL.$js_file.'"></script>';
		}
	}
	//$this->tpl->assign('xoops_module_header', $html);
	$this->tpl->assign('xoops_module_header', $this->tpl->get_template_vars( 'xoops_module_header' ).$html);
}
//------------------------------------------------------------------------------

function assignXoopsCodeTarea($content, $textarea_id, $cols=60, $rows=15, $suffix=null, $use_smilies=true)
{
	require_once XSNS_TRUST_PATH.'/include/xoopscodes.php';
	
	$GLOBALS[$textarea_id] = $content;
	
	ob_start();
	xsns_xoops_code_tarea($textarea_id, $cols, $rows, $suffix);
	$this->tpl->assign('xoops_codes', ob_get_contents());
	ob_end_clean();
	
	unset($GLOBALS[$textarea_id]);
	
	if($use_smilies){
		ob_start();
		xsns_xoops_smilies($textarea_id);
		$this->tpl->assign('xoops_smilies', ob_get_contents());
		ob_end_clean();
	}
}
//------------------------------------------------------------------------------

function assignFormHeader($form_name, $method='post', $target='', $action='', $upload=false, $hidden_vars=NULL, $token_name=NULL)
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
	
	$this->tpl->assign($form_name, $form);
}
//------------------------------------------------------------------------------

function assignUploadFormJS($image_form_count=1, $file_form_count=1)
{
	global $xoopsModuleConfig;
	$image_form_limit = isset($xoopsModuleConfig['image_form_limit']) ? $xoopsModuleConfig['image_form_limit'] : 3;
	$file_form_limit = isset($xoopsModuleConfig['file_form_limit']) ? $xoopsModuleConfig['file_form_limit'] : 3;
	
	if($image_form_limit < 1 && $file_form_limit < 1){
		return;
	}
	
	if($image_form_count < 1){
		$image_form_count = 1;
	}
	if($file_form_count < 1){
		$file_form_count = 1;
	}
	
	$js = <<<EOD

var image_form_count = {$image_form_count};
var file_form_count = {$file_form_count};
var image_form_limit = {$image_form_limit};
var file_form_limit = {$file_form_limit};

function Xsns_addUploadForm(type)
{
	if(type==0 && image_form_limit>0){
		if(image_form_count < image_form_limit){
			image_form_count++;
			document.getElementById('image'+image_form_count).style.display='block';
		}
		if(image_form_count == image_form_limit){
			document.getElementById('image_add').style.display='none';
		}
	}
	else if(type==1 && file_form_limit>0){
		if(file_form_count < file_form_limit){
			file_form_count++;
			document.getElementById('file'+file_form_count).style.display='block';
		}
		if(file_form_count == file_form_limit){
			document.getElementById('file_add').style.display='none';
		}
	}
}

EOD;
	
	$this->tpl->assign('xoops_js', $js);
}

}
?>
