<?php
/**
 * @file
 * @package myckeditor
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Myckeditor_TextArea extends XCube_ActionFilter
{
	/**
	 * @public
	 */
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->reset('Site.TextareaEditor.HTML.Show');
		$this->mRoot->mDelegateManager->add('Site.TextareaEditor.HTML.Show',array(&$this, 'render'));
	}

	/**
	 *	@public
	*/
	public function render(&$html, $params)
	{
		$root =& XCube_Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);

		$renderTarget =& $renderSystem->createRenderTarget('main');

		$renderTarget->setAttribute('legacy_module', 'myckeditor');
		$renderTarget->setTemplateName("myckeditor_textarea.html");
		$renderTarget->setAttribute("element", $params);

		$renderSystem->render($renderTarget);

		$html = $renderTarget->getResult();

		$this->_addScript($params);
	}

	protected function _addScript(/*** string[] ***/ $params)
	{
		$root = XCube_Root::getSingleton();
		$jQuery = $root->mContext->getAttribute('headerScript');
		$jQuery->addScript('var ckconfig_'.$params['id'].' = {
		    toolbar:[
		    ["Source", "-", "Bold", "Italic", "-", "NumberedList", "BulletedList", "-", "Link"],
		    ["Format","FontSize"],
		    ["UIColor"],
		    ["JustifyLeft","JustifyCenter","JustifyRight"],
		    ["Image"],
		    ["Maximize", "ShowBlocks"],
			["Source","-","Save","NewPage","DocProps","Preview","Print","-","Templates"],
			["Form", "Checkbox", "Radio", "TextField", "Textarea", "Select", "Button", "ImageButton", "HiddenField"]
		    ]
		};');
		
		// This is actually the default value.
/*$jQuery->addScript('var ckconfig_'.$params['id'].' = {
	toolbar_Full :
[
    { name: "document",    items : [ "Source","-","Save","NewPage","DocProps","Preview","Print","-","Templates" ] },
    { name: "clipboard",   items : [ "Cut","Copy","Paste","PasteText","PasteFromWord","-","Undo","Redo" ] },
    { name: "editing",     items : [ "Find","Replace","-","SelectAll","-","SpellChecker", "Scayt" ] },
    { name: "forms",       items : [ "Form", "Checkbox", "Radio", "TextField", "Textarea", "Select", "Button", "ImageButton", "HiddenField" ] },
    "/",
    { name: "basicstyles", items : [ "Bold","Italic","Underline","Strike","Subscript","Superscript","-","RemoveFormat" ] },
    { name: "paragraph",   items : [ "NumberedList","BulletedList","-","Outdent","Indent","-","Blockquote","CreateDiv","-","JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock","-","BidiLtr","BidiRtl" ] },
    { name: "links",       items : [ "Link","Unlink","Anchor" ] },
    { name: "insert",      items : [ "Image","Flash","Table","HorizontalRule","Smiley","SpecialChar","PageBreak" ] },
    "/",
    { name: "styles",      items : [ "Styles","Format","Font","FontSize" ] },
    { name: "colors",      items : [ "TextColor","BGColor" ] },
    { name: "tools",       items : [ "Maximize", "ShowBlocks","-","About" ] }
];
	};');*/
		$jQuery->addScript('$("textarea#'.$params['id'].'").ckeditor(ckconfig_'.$params['id'].');');
		//$jQuery->addScript('CKEDITOR.replace("ckeditor");');
        $jQuery->addLibrary('/modules/myckeditor/ckeditor/ckeditor.js');
		$jQuery->addLibrary('/modules/myckeditor/ckeditor/adapters/jquery.js');
	}
}

?>
