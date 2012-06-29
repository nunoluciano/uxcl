<?php
/**
 *
 * @package Legacy
 * @version $Id: image.php,v 1.3 2008/09/25 15:11:33 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://xoopscube.sourceforge.net/license/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class LegacyImageObject extends XoopsSimpleObject
{
	var $mImageCategory = null;
	var $_mImageCategoryLoadedFlag = false;
	var $mImageBody = null;
	var $_mImageBodyLoadedFlag = false;

	function LegacyImageObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('image_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('image_name', XOBJ_DTYPE_STRING, '', true, 30);
		$this->initVar('image_nicename', XOBJ_DTYPE_STRING, '', true, 255);
		$this->initVar('image_mimetype', XOBJ_DTYPE_STRING, '', true, 30);
		$this->initVar('image_created', XOBJ_DTYPE_INT, time(), true);
		$this->initVar('image_display', XOBJ_DTYPE_BOOL, '1', true);
		$this->initVar('image_weight', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('imgcat_id', XOBJ_DTYPE_INT, '0', true);
		$initVars=$this->mVars;
	}

	function loadImagecategory()
	{
		if ($this->_mImageCategoryLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('imagecategory', 'legacy');
			$this->mImageCategory =& $handler->get($this->get('imgcat_id'));
			$this->_mImageCategoryLoadedFlag = true;
		}
	}

	function loadImagebody()
	{
		if ($this->_mImageBodyLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('imagebody', 'legacy');
			$this->mImageBody =& $handler->get($this->get('image_id'));
			$this->_mImageBodyLoadedFlag = true;
		}
	}

	function &createImagebody()
	{
		$handler =& xoops_getmodulehandler('imagebody', 'legacy');
		$obj =& $handler->create();
		$obj->set('image_id', $this->get('image_id'));
		return $obj;
	}
}

class LegacyImageHandler extends XoopsObjectGenericHandler
{
	var $mTable = "image";
	var $mPrimary = "image_id";
	var $mClass = "LegacyImageObject";

	function insert(&$obj, $force = false)
	{
		if (parent::insert($obj, $force)) {
			if (is_object($obj->mImageBody)) {
				$obj->mImageBody->set('image_id', $obj->get('image_id'));
				$handler =& xoops_getmodulehandler('imagebody', 'legacy');
				return $handler->insert($obj->mImageBody, $force);
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * Delete object and image file.
	 *
	 * @param $obj    LegacyImageObject
	 * @param $force  boolean
	 * @return boolean
	 */	
	function delete(&$obj, $force = false)
	{
		$obj->loadImagebody();
			
		if (parent::delete($obj, $force)) {
			$filepath = XOOPS_UPLOAD_PATH . "/" . $obj->get('image_name');
			if (file_exists($filepath)) {
				@unlink($filepath);
			}
			
			if (is_object($obj->mImageBody)) {
				$handler =& xoops_getmodulehandler('imagebody', 'legacy');
				$handler->delete($obj->mImageBody, $force);
			}
			
			return true;
		}
		
		return false;
	}
}

?>
