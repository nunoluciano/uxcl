<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_BL_LOADED' ) ) {

define( 'PICAL_BL_LOADED' , 1 ) ;

// for monthly calendar block
define('_MB_PICAL_PREV_MONTH','前月');
define('_MB_PICAL_NEXT_MONTH','翌月');
define('_MB_PICAL_YEAR','年');
define('_MB_PICAL_MONTH','月');
define('_MB_PICAL_JUMP','Jump');

// for after the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_AFTER','%s以降の予定');

// for the day's events block
// %s means the indicated day
define('_MB_PICAL_EVENTS_THEDAY','%sの予定');


define("_MB_PICAL_MAXITEMS","表示件数");
define("_MB_PICAL_CATSEL","カテゴリー絞り込み");
define("_MB_PICAL_CATSELSUB","配下のカテゴリーも表示する");
define("_MB_PICAL_UNTILDAYS","最大 %s 日後までの予定を表示する（0なら制限なし）");
define("_MB_PICAL_MAXGIFSADAY","１日あたりのGIFリンク表示件数");
define("_MB_PICAL_JUSTONCEADAYAPLUGIN","１プラグインあたり１日１件しか表示しない");


}

?>