<?php

// abstract class for Attachfile plugins
class AttachfilePluginAbstract {

var $attachfile_dirname = '' ;
var $attachfile_trustdirname = '' ;
var $target_dirname = '' ;
var $target_trustdirname = '' ;
var $target_id = '' ;
var $parentObj = null ; // parent object

function AttachfilePluginAbstract( $parentObj )
{
	$this->parentObj = & $parentObj;
}

function attachfile_check_upload_permission_plugin( $target_id )
{
	return true;
}

function attachfile_check_download_permission_plugin( $target_id )
{
	return true;
}

}

?>