<?php
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename(dirname(dirname(__FILE__)));

eval( '

function b_waiting_'.$mydirname.'()
	{
	return b_waiting_xwords_base("'.$mydirname.'") ;
	}

' ) ;


if( ! function_exists( 'b_waiting_xwords_base' ) )
	{

	function b_waiting_xwords_base($mydirname)
		{

//		$mydirname = basename(dirname(dirname(__FILE__)));
		$MYDIRNAME = strtoupper($mydirname);

		$xoopsDB =& Database::getInstance();
		$block = array();

		// xwords
		$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("{$mydirname}_ent")." WHERE request = '1' OR submit = '1'");
		if ( $result )
			{
			$block['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/submissions.php" ;
			list($block['pendingnum']) = $xoopsDB->fetchRow($result);
			$block['lang_linkname'] = constant("_MB_WAITING_{$MYDIRNAME}") ;
			}
		return $block;
		}
	}
?>