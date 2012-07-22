<?php
require_once XOOPS_TRUST_PATH.'/modules/attachfile/class/AttachfilePluginAbstract.class.php' ;

// a class for attachfile plugin
class bulletinAttachfilePlugin extends AttachfilePluginAbstract{

function bulletinAttachfilePlugin( $parentObj )
{
	$this->parentObj = & $parentObj;
}


// ===========================================================================
// The permission file is necessary in each module.
// If target module is "D3 module", the permission file is necessary
// in each directory in XOOPS_TRUST_PATH (not XOOPS_ROOT_PATH).
//
// -- argument --
// 
// $target_id			: target mosule's contents id (target to attach)
// 
// -- return value --
// 
// true					: allow access
// false				: deny access
// ===========================================================================

function attachfile_check_upload_permission_plugin( $target_id )
{
	return true;
}

function attachfile_check_download_permission_plugin( $target_id )
{
	return true;
}
} // end class

?>
