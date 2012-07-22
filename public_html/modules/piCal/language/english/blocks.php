<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_BL_LOADED' ) ) {

define( 'PICAL_BL_LOADED' , 1 ) ;

// for monthly calendar block
define('_MB_PICAL_PREV_MONTH','Previous');
define('_MB_PICAL_NEXT_MONTH','Next');
define('_MB_PICAL_YEAR','');
define('_MB_PICAL_MONTH','');
define('_MB_PICAL_JUMP','Jump');

// for after the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_AFTER','Events after %s');

// for the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_THEDAY','Events on %s');


define("_MB_PICAL_MAXITEMS","Display");
define("_MB_PICAL_CATSEL","Category");
define("_MB_PICAL_CATSELSUB","Also displays subcategories");
define("_MB_PICAL_UNTILDAYS","Until %s days at most (0 means eternal)");

define("_MB_PICAL_MAXGIFSADAY","Max dotgifs per a day");
define("_MB_PICAL_JUSTONCEADAYAPLUGIN","Display just 1 gif per a day and per a plugin");

}

?>