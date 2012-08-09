<?php
/**
 *
 * @package Legacy
 * @version $Id: ActionFrame.class.php,v 1.3 2008/09/25 15:11:25 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://xoopscube.sourceforge.net/license/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

define ("LEGACY_FRAME_PERFORM_SUCCESS", 1);
define ("LEGACY_FRAME_PERFORM_FAIL", 2);
define ("LEGACY_FRAME_INIT_SUCCESS", 3);

define ("LEGACY_FRAME_VIEW_NONE", 1);
define ("LEGACY_FRAME_VIEW_SUCCESS", 2);
define ("LEGACY_FRAME_VIEW_ERROR", 3);
define ("LEGACY_FRAME_VIEW_INDEX", 4);
define ("LEGACY_FRAME_VIEW_INPUT", 5);
define ("LEGACY_FRAME_VIEW_PREVIEW", 6);
define ("LEGACY_FRAME_VIEW_CANCEL", 7);

//
// Constatns for the mode of the frame.
//
define ("LEGACY_FRAME_MODE_MISC", "Misc");
define ("LEGACY_FRAME_MODE_NOTIFY", "Notify");
define ("LEGACY_FRAME_MODE_IMAGE", "Image");
define ("LEGACY_FRAME_MODE_SEARCH", "Search");

class Legacy_ActionFrame
{
	var $mActionName = null;
	var $mAction = null;
	var $mAdminFlag = null;

	/**
	 * Mode. The rule refers this property to load a file and create an
	 * instance in execute().
	 * 
	 * @var string
	 */	
	var $mMode = null;

	/**
	 * @var XCube_Delegate
	 */
	var $mCreateAction = null;
	
	function Legacy_ActionFrame($admin)
	{
		$this->mAdminFlag = $admin;
		$this->mCreateAction =new XCube_Delegate();
		$this->mCreateAction->register('Legacy_ActionFrame.CreateAction');
		$this->mCreateAction->add(array(&$this, '_createAction'));
	}

	function setActionName($name)
	{
		$this->mActionName = $name;
		
		//
		// Temp FIXME!
		//
		$root =& XCube_Root::getSingleton();
		$root->mContext->setAttribute('actionName', $name);
		$root->mContext->mModule->setAttribute('actionName', $name);
	}
	
	/**
	 * Set mode.
	 * 
	 * @param string $mode   Use constants (LEGACY_FRAME_MODE_MISC and more...)
	 */
	function setMode($mode)
	{
		$this->mMode = $mode;
	}

	function _createAction(&$actionFrame)
	{
		if (is_object($actionFrame->mAction)) {
			return;
		}
		
		//
		// Create action object by mActionName
		//
		$className = "Legacy_" . ucfirst($actionFrame->mActionName) . "Action";
		$fileName = ucfirst($actionFrame->mActionName) . "Action";
		if ($actionFrame->mAdminFlag) {
			$fileName = XOOPS_MODULE_PATH . "/legacy/admin/actions/${fileName}.class.php";
		}
		else {
			$fileName = XOOPS_MODULE_PATH . "/legacy/actions/${fileName}.class.php";
		}
	
		if (!file_exists($fileName)) {
			die();
		}
	
		require_once $fileName;
	
		if (XC_CLASS_EXISTS($className)) {
			$actionFrame->mAction =new $className($actionFrame->mAdminFlag);
		}
	}
	
	function execute(&$controller)
	{
		if (strlen($this->mActionName) > 0 && !preg_match("/^\w+$/", $this->mActionName)) {
			die();
		}

		//
		// Actions of the public side in this module are hook type. So it's
		// necessary to load catalog here.
		//		
		if (!$this->mAdminFlag) {
			$controller->mRoot->mLanguageManager->loadModuleMessageCatalog('legacy');
		}
		
		//
		// Add mode.
		//
		$this->setActionName($this->mMode . $this->mActionName);
	
		//
		// Create action object by mActionName
		//
		$this->mCreateAction->call(new XCube_Ref($this));
	
		if (!(is_object($this->mAction) && is_a($this->mAction, 'Legacy_Action'))) {
			die();	//< TODO
		}
		
		if ($this->mAction->prepare($controller, $controller->mRoot->mContext->mXoopsUser) === false) {
			die();	//< TODO
		}
	
		if (!$this->mAction->hasPermission($controller, $controller->mRoot->mContext->mXoopsUser)) {
			if ($this->mAdminFlag) {
				$controller->executeForward(XOOPS_URL . "/admin.php");
			}
			else {
				$controller->executeForward(XOOPS_URL);
			}
		}
	
		if (xoops_getenv("REQUEST_METHOD") == "POST") {
			$viewStatus = $this->mAction->execute($controller, $controller->mRoot->mContext->mXoopsUser);
		}
		else {
			$viewStatus = $this->mAction->getDefaultView($controller, $controller->mRoot->mContext->mXoopsUser);
		}
	
		switch($viewStatus) {
			case LEGACY_FRAME_VIEW_SUCCESS:
				$this->mAction->executeViewSuccess($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		
			case LEGACY_FRAME_VIEW_ERROR:
				$this->mAction->executeViewError($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		
			case LEGACY_FRAME_VIEW_INDEX:
				$this->mAction->executeViewIndex($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		
			case LEGACY_FRAME_VIEW_INPUT:
				$this->mAction->executeViewInput($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;

			case LEGACY_FRAME_VIEW_PREVIEW:
				$this->mAction->executeViewPreview($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;

			case LEGACY_FRAME_VIEW_CANCEL:
				$this->mAction->executeViewCancel($controller, $controller->mRoot->mContext->mXoopsUser, $controller->mRoot->mContext->mModule->getRenderTarget());
				break;
		}
	}
}

class Legacy_Action
{
	/**
	 * @access private
	 */
	var $_mAdminFlag = false;
	
	function Legacy_Action($adminFlag = false)
	{
		$this->_mAdminFlag = $adminFlag;
	}

	function hasPermission(&$controller, &$xoopsUser)
	{
		if ($this->_mAdminFlag) {
			return $controller->mRoot->mContext->mUser->isInRole('Module.legacy.Admin');
		}
		else {
			//
			// TODO Really?
			//
			return true;
		}
	}
	
	function prepare(&$controller, &$xoopsUser)
	{
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		return LEGACY_FRAME_VIEW_NONE;
	}

	function execute(&$controller, &$xoopsUser)
	{
		return LEGACY_FRAME_VIEW_NONE;
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewPreview(&$controller, &$xoopsUser, &$render)
	{
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
	}
}

?>
