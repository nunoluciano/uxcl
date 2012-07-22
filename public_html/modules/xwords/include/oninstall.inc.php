<?php
# XOOPS2 - Xwords 0.42
# WEBMASTER @ KANPYO.NET, 2005.

if( ! defined( "XOOPS_ROOT_PATH" ) ) exit ;


$sqlfilename = XOOPS_ROOT_PATH . "/modules/{$mydirname}/sql/mysql.sql";
if (is_writable($sqlfilename))
	{
	$lines = file($sqlfilename);
	$fp = fopen ($sqlfilename , "w") or die($sqlfilename);
	for($i = 0; $i < count($lines); $i++)
		{
		$lines[$i] = str_replace("xwords_cat", "{$mydirname}_cat", $lines[$i]);
		$lines[$i] = str_replace("xwords_ent", "{$mydirname}_ent", $lines[$i]);
		fputs($fp, $lines[$i]);
		}
	fclose ($fp);
	}

include_once XOOPS_ROOT_PATH."/class/xoopslists.php";

$templates_array = array();
$templates_array = XoopsLists::getHtmlListAsArray(XOOPS_ROOT_PATH."/modules/{$mydirname}/templates/");
foreach($templates_array as $key)
	{
//	echo $templates_array[$key];
	if ( preg_match('/^xwords/',$templates_array[$key]) )
		{
		$renamefilename = preg_replace('/^xwords(.+)/', "$mydirname$1", $templates_array[$key]);
		rename( XOOPS_ROOT_PATH . "/modules/{$mydirname}/templates/".$templates_array[$key], XOOPS_ROOT_PATH . "/modules/{$mydirname}/templates/{$renamefilename}" );
		}
	}

$b_templates_array = array();
$b_templates_array = XoopsLists::getHtmlListAsArray(XOOPS_ROOT_PATH."/modules/{$mydirname}/templates/blocks/");
foreach($b_templates_array as $key)
	{
//	echo $b_templates_array[$key];
	if ( preg_match('/^entries/',$b_templates_array[$key]) )
		{
		$renamefilename = preg_replace('/^entries(.+)/', "$mydirname$1", $b_templates_array[$key]);
		rename( XOOPS_ROOT_PATH . "/modules/{$mydirname}/templates/blocks/".$b_templates_array[$key], XOOPS_ROOT_PATH . "/modules/{$mydirname}/templates/blocks/{$renamefilename}" );
		}
	}

?>