<?php

require_once XOOPS_ROOT_PATH.'/class/uploader.php';


class XsnsImageUploader extends XoopsMediaUploader
{

	//--------------------------------------------------------------------------

	function getExt()
	{
		return $this->ext;
	}
	//--------------------------------------------------------------------------

	/**
	 * Is the picture the right width?
	 *
	 * @return	bool
	 **/
	function checkMaxWidth()
	{
		if (!isset($this->maxWidth)) {
			return true;
		}
		if (!function_exists('getimagesize')){
			return false;
		}
		if (false !== $dimension = getimagesize($this->mediaTmpName)) {
			if ($dimension[0] > $this->maxWidth) {
				return false;
			}
		}
		return true;
	}
	//--------------------------------------------------------------------------

	/**
	 * Is the picture the right height?
	 *
	 * @return	bool
	 **/
	function checkMaxHeight()
	{
		if (!isset($this->maxHeight)) {
			return true;
		}
		if (!function_exists('getimagesize')){
			return false;
		}
		if (false !== $dimension = getimagesize($this->mediaTmpName)) {
			if ($dimension[1] > $this->maxHeight) {
				return false;
			}
		}
		return true;
	}
	//--------------------------------------------------------------------------

	function checkFileNameLength($filename)
	{
		if(strlen($filename) > 255){
			return false;
		}
		return true;
	}
	
	//--------------------------------------------------------------------------
	
}

?>
