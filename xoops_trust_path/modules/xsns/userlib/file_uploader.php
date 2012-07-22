<?php

require_once XOOPS_ROOT_PATH.'/class/uploader.php';


class XsnsFileUploader extends XoopsMediaUploader
{
	
	//--------------------------------------------------------------------------

	function XsnsFileUploader($uploadDir, $allowedMimeTypes, $maxFileSize=0)
	{
		@$this->extensionToMime = include( XOOPS_ROOT_PATH . '/class/mimetypes.inc.php' );
		if ( !is_array( $this->extensionToMime ) ) {
			$this->extensionToMime = array();
			return false;
		}
		if (is_array($allowedMimeTypes)) {
			$this->allowedMimeTypes =& $allowedMimeTypes;
		}
		$this->uploadDir = $uploadDir;
		$this->maxFileSize = intval($maxFileSize);
	}

	function getExt()
	{
		return $this->ext;
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
