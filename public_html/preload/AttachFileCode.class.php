<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class AttachFileCode extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mTextFilter->mMakeXCodeConvertTable->add(array(&$this, 'addAttachFileCode'), XCUBE_DELEGATE_PRIORITY_FINAL);
	}

	function addAttachFileCode( &$patterns, &$replacements )
	{
		// for attachfile image
		$patterns[] = "/\[attach_img=(['\"]?)([0-9]*)\\1](.*)\[\/attach_img\]/sU";
		$replacements[0][] = '<a href="'.XOOPS_URL.'/modules/attachfile/index.php?mode=download&attach_id=\\2">\\3</a>';
		$replacements[1][] = '<img src="'.XOOPS_URL.'/modules/attachfile/index.php?mode=download&attach_id=\\2" alt="\\3" />';
		// for attachfile
		$patterns[] = "/\[attach=(['\"]?)([0-9]*)\\1](.*)\[\/attach\]/sU";
		$replacements[0][] = $replacements[1][] = '<a href="'.XOOPS_URL.'/modules/attachfile/index.php?mode=download&attach_id=\\2">\\3</a>';
	}
}
?>
