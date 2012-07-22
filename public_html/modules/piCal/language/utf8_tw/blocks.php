<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_BL_LOADED' ) ) {

define( 'PICAL_BL_LOADED' , 1 ) ;

// for monthly calendar block
define('_MB_PICAL_PREV_MONTH','上個月');
define('_MB_PICAL_NEXT_MONTH','下個月');
define('_MB_PICAL_YEAR','年');
define('_MB_PICAL_MONTH','月');
define('_MB_PICAL_JUMP','切換');

// for after the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_AFTER','%s 以後的事件');

// for the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_THEDAY','%s 的事件');

define('_MB_PICAL_MAXITEMS','顯示件數');
define('_MB_PICAL_CATSEL','類別鎖定');
define('_MB_PICAL_CATSELSUB','子類別也顯示');
define('_MB_PICAL_UNTILDAYS','最多顯示 %s 天的事件 (0 為無限制)');
define('_MB_PICAL_MAXGIFSADAY','設定每日顯示最多幾個事件');
define('_MB_PICAL_JUSTONCEADAYAPLUGIN','每個 plugin 每天僅能顯示一個事件');

}

?>