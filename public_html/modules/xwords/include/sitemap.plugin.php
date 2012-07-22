<?php
// original	::	onego (thank you)
// FILE		::	Duplicatable xwords.php v0.01 <2005/11/02>
// AUTHOR	::	aiba <WEBMASTER @ KANPYO.NET>
// WEB		::	KANPYO <http://www.kanpyo.net>
//
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$file = basename(dirname(dirname(__FILE__)));

eval( '
	function b_sitemap_'.$file.'()
		{
		return b_sitemap_xwords_base( "'.$file.'" ) ;
		}
' ) ;

if( ! function_exists( 'b_sitemap_xwords_base' ) )
	{
	function b_sitemap_xwords_base($file)
		{
	
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();
	
		$result = $db->query("SELECT categoryID, name FROM ".$db->prefix("{$file}_cat")." order by weight");
	
		$ret = array() ;
		while(list($id, $name) = $db->fetchRow($result))
			{
			$ret["parent"][] = array(
				"id" => $id,
				"title" => $myts->makeTboxData4Show($name),
				"url" => "category.php?categoryID=$id"
				);
			}

		return $ret;
		}
	}
?>