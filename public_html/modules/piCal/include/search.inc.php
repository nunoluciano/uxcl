<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) die ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

eval( '

function pical'.$mydirnumber.'_search( $keywords , $andor , $limit , $offset , $uid )
{
	return pical_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $uid ) ;
}

' ) ;

if( ! function_exists( 'pical_search_base' ) ) {

function pical_search_base( $mydirname , $keywords , $andor , $limit , $offset , $uid )
{
	global $xoopsConfig , $xoopsDB , $xoopsUser ;

	// setting physical & virtual paths
	$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
	$mod_url = XOOPS_URL."/modules/$mydirname" ;

	// defining class of piCal
	if( ! class_exists( 'piCal_xoops' ) ) {
		require_once( "$mod_path/class/piCal.php" ) ;
		require_once( "$mod_path/class/piCal_xoops.php" ) ;
	}

	// creating an instance of piCal 
	$cal = new piCal_xoops( "" , $xoopsConfig["language"] , true ) ;
	$cal->use_server_TZ = true ;

	// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;

	$ret = $cal->get_xoops_search_result( $keywords , $andor , $limit , $offset , $uid ) ;

	return $ret ;
}

}

?>
