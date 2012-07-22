<?php

// pical_mini_calendar.php
// displaying monthly calendar as a block (Only for ccblock :-)
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)

if( ! defined( 'PICAL_BLOCK_MONTHLY_CALENDAR_INCLUDED' ) ) {

define( 'PICAL_BLOCK_MONTHLY_CALENDAR_INCLUDED' , 1 ) ;

function pical_monthly_calendar_show( $options )
{
	global $xoopsConfig , $xoopsDB ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;

	// setting physical & virtual paths
	$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
	$mod_url = XOOPS_URL."/modules/$mydirname" ;

	// defining class of piCal
	if( ! class_exists( 'piCal_xoops' ) ) {
		require_once( "$mod_path/class/piCal.php" ) ;
		require_once( "$mod_path/class/piCal_xoops.php" ) ;
	}

	// creating an instance of piCal 
	$cal = new piCal_xoops( "" , $xoopsConfig['language'] , true ) ;

	// ignoring cid from GET
	$cal->now_cid = 0 ;

	// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->base_url = $mod_url ;
	$cal->base_path = $mod_path ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;

	$original_level = error_reporting( E_ALL ^ E_NOTICE ) ;
	require_once( "$mod_path/include/patTemplate.php" ) ;
	$tmpl = new PatTemplate() ;
	$tmpl->readTemplatesFromFile( "$cal->images_path/block_monthly.tmpl.html" ) ;

	// setting skin folder
	$tmpl->addVar( "WholeBoard" , "SKINPATH" , $cal->images_url ) ;

	// setting language
	$tmpl->addVar( "WholeBoard" , "LANG_PREV_MONTH" , _MB_PICAL_PREV_MONTH ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_NEXT_MONTH" , _MB_PICAL_NEXT_MONTH ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_YEAR" , _MB_PICAL_YEAR ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_MONTH" , _MB_PICAL_MONTH ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_JUMP" , _MB_PICAL_JUMP ) ;

	// Static parameter for the request
	$tmpl->addVar( "WholeBoard" , "GET_TARGET" , "$mod_url/index.php" ) ;
	$tmpl->addVar( "WholeBoard" , "QUERY_STRING" , '' ) ;

	// Variables required in header part etc.
	$tmpl->addVars( "WholeBoard" , $cal->get_calendar_information( 'M' ) ) ;

	// BODY of the calendar
	$tmpl->addVar( "WholeBoard" , "CALENDAR_BODY" , $cal->get_monthly_html( "$mod_url/index.php" ) ) ;

	// legends of long events
	foreach( $cal->long_event_legends as $bit => $legend ) {
		$tmpl->addVar( "LongEventLegends" , "BIT_MASK" , 1 << ( $bit - 1 ) ) ;
		$tmpl->addVar( "LongEventLegends" , "LEGEND_ALT" , _PICAL_MB_ALLDAY_EVENT . " $bit" ) ;
		$tmpl->addVar( "LongEventLegends" , "LEGEND" , $legend ) ;
		$tmpl->addVar( "LongEventLegends" , "SKINPATH" , $cal->images_url ) ;
		$tmpl->parseTemplate( "LongEventLegends" , "a" ) ;
	}

	// content generated from patTemplate
	$block['content'] = $tmpl->getParsedTemplate( "WholeBoard" ) ;

	error_reporting( $original_level ) ;

	return $block ;
}



function pical_monthly_calendar_edit( $options )
{
	return '' ;
}

}

?>