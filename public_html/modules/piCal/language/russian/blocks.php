<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_BL_LOADED' ) ) {

define( 'PICAL_BL_LOADED' , 1 ) ;

// for monthly calendar block
define('_MB_PICAL_PREV_MONTH','Предыдущий');
define('_MB_PICAL_NEXT_MONTH','Следующий');
define('_MB_PICAL_YEAR','');
define('_MB_PICAL_MONTH','');
define('_MB_PICAL_JUMP','Перейти');

// for after the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_AFTER','События после %s');

// for the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_THEDAY','События на %s');


define("_MB_PICAL_MAXITEMS","Показывать");
define("_MB_PICAL_CATSEL","Категория");
define("_MB_PICAL_CATSELSUB","Показывать подкатегории");
define("_MB_PICAL_UNTILDAYS","До %s дней включительно (0 - без ограничения по времени)");

define("_MB_PICAL_MAXGIFSADAY","Максимальное количество точек/картинок в день");
define("_MB_PICAL_JUSTONCEADAYAPLUGIN","Показывать только 1 точку/картинку в день на плагин");
//define("_MB_PICAL_PLUGINS","Активные плагины");
//define("_MB_PICAL_PLUGINS_DESC","list the plugin's name separated with , (comma)");
//define("_MB_PICAL_PLUGINS_VALID","Valid Plugins");

}

?>