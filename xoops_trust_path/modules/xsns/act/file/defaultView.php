<?php
class Xsns_Default_View extends Xsns_File_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_file.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$hidden = $this->context->getAttribute('hidden');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('file.css');
	$this->assignFormHeader('form_del', 'post', 'file', 'del_exec', false, $hidden, 'FILE_DELETE');
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
