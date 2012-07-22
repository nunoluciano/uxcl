<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:40
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:20
define('_MI_PICAL_ADMENU_MYTPLSADMIN','樣版管');

define( 'PICAL_MI_LOADED' , 1 ) ;


// Module Info

// The name of this module

define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','區塊組管');
define("_MI_PICAL_NAME","piCal行事曆");

// A brief description of this module
define("_MI_PICAL_DESC","具有能的行事曆模組");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","日曆");
define("_MI_PICAL_BNAME_MINICAL_DESC","顯示日曆區塊");
define('_MI_PICAL_BNAME_MINICALEX','階月曆');
define('_MI_PICAL_BNAME_MINICALEX_DESC',' plugin 的月曆');
define("_MI_PICAL_BNAME_MONTHCAL","月曆");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","顯示完整的月曆");
define("_MI_PICAL_BNAME_TODAYS","今日事件");
define("_MI_PICAL_BNAME_TODAYS_DESC","顯示今天的事件");
define("_MI_PICAL_BNAME_THEDAYS","%s 的事件");
define("_MI_PICAL_BNAME_THEDAYS_DESC","顯示指日期的事件");
define("_MI_PICAL_BNAME_COMING","近期事件");
define("_MI_PICAL_BNAME_COMING_DESC","顯示近期的事件");
define("_MI_PICAL_BNAME_AFTER","今日後事件");
define("_MI_PICAL_BNAME_AFTER_DESC","顯示今日後的事件");

// Names of submenu
define('_MI_PICAL_SM_SUBMIT','');

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "用戶限");
define("_MI_GUESTS_AUTHORITY", "客限");
define("_MI_MINICAL_TARGET", "當選行事曆時所顯示面中央的行事曆");
define("_MI_COMING_NUMROWS", "近期事件區塊顯示事件的數目");
define("_MI_SKINFOLDER", "行事曆樣式的資料夾稱 (images目錄內)");
define('_MI_PICAL_DEFAULTLOCALE','big5_taiwan');
define('_MI_PICAL_LOCALE','域 <br />自動當例假日內建至2010為止之國曆曆假日');
define("_MI_SUNDAYCOLOR", "期日的色");
define("_MI_WEEKDAYCOLOR", "平日的色");
define("_MI_SATURDAYCOLOR", "期六的色");
define("_MI_HOLIDAYCOLOR", "假日的色");
define("_MI_TARGETDAYCOLOR", "日的色");
define("_MI_SUNDAYBGCOLOR", "期日的景色");
define("_MI_WEEKDAYBGCOLOR", "平日的色");
define("_MI_SATURDAYBGCOLOR", "期六的景色");
define("_MI_HOLIDAYBGCOLOR", "假日的景色");
define("_MI_TARGETDAYBGCOLOR", "日的景色");
define("_MI_CALHEADCOLOR", "行事曆部份的色");
define("_MI_CALHEADBGCOLOR", "行事曆部份的景色");
define("_MI_CALFRAMECSS", "行事曆視窗的樣式");
define("_MI_CANOUTPUTICS", "匯 ics 檔案的限");
define("_MI_MAXRRULEEXTRACT", "重複事件限數.");
define("_MI_WEEKSTARTFROM", "的第天");
define('_MI_TIMEZONE_USING','伺器的時區指');
define('_MI_USE24HOUR','使用24時制 (選擇自動12時制)');
define('_MI_NAMEORUNAME','顯示表者');
define('_MI_DESCNAMEORUNAME','請選擇顯示號或實(暱稱)');

// Description of each config items
define("_MI_EDITBYGUESTDSC", "客事件的限");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "事件");
define("_MI_OPT_AUTH_WAIT", "事件並需核");
define("_MI_OPT_AUTH_POST", "事件但不需核");
define("_MI_OPT_AUTH_BYGROUP", "依照組限");
define("_MI_OPT_MINI_PHPSELF", "目頁面");
define("_MI_OPT_MINI_MONTHLY", "月行事曆");
define("_MI_OPT_MINI_WEEKLY", "行事曆");
define("_MI_OPT_MINI_DAILY", "日行事曆");
define("_MI_OPT_CANNOTOUTPUTICS", "匯");
define("_MI_OPT_CANOUTPUTICS", "匯");
define("_MI_OPT_STARTFROMSUN", "期日");
define("_MI_OPT_STARTFROMMON", "期");
define('_MI_OPT_TZ_USEXOOPS','XOOPS的值');
define('_MI_OPT_TZ_USEWINTER','由伺器取的時間 (推薦)');
define('_MI_OPT_TZ_USESUMMER','由伺器取的時間');
define('_MI_OPT_USENAME','實');
define('_MI_OPT_USEUNAME','號');


// Admin Menus
define("_MI_PICAL_ADMENU0","待事件區");
define("_MI_PICAL_ADMENU1","事件管區");
define("_MI_PICAL_ADMENU2","組限管");
define('_MI_PICAL_ADMENU_PLUGINS','Plugin管區');

//d3comment integration
define("_MI_COM_DIRNAME","Comment integration directory");
define("_MI_COM_DIRNAMEDSC","When use D3-comment integration system. <br/>write your d3forum (html) directory <br/>If you do not use comments or use xoops comment system, leave this in empty.");
define("_MI_COM_FORUM_ID","d3forum_id");
define("_MI_COM_FORUM_IDDSC","When you set above integration diredtory, write forum_id");
define("_MI_COM_ORDER","Order of comment integration");
define("_MI_COM_ORDERDSC","When you set comment integration, select display order of comment posts");
define("_MI_COM_VIEW","View of comment-integration");
define("_MI_COM_VIEWDSC","select flat or thread");
define("_MI_COM_POSTSNUM","'Max posts displayed in comment integration");

// Appended by Xoops Language Checker -GIJOE- in 2003-12-05 14:18:43

// Appended by Xoops Language Checker -GIJOE- in 2003-12-26 10:55:16
define('_MI_DAYSTARTFROM','切換日的時間');
define('_MI_PICAL_GLOBAL_NOTIFY','模組整體');
define('_MI_PICAL_GLOBAL_NOTIFYDSC','所有 piCal 模組的知選項');
define('_MI_PICAL_CATEGORY_NOTIFY','類');
define('_MI_PICAL_CATEGORY_NOTIFYDSC','對所選擇類的知選項');
define('_MI_PICAL_EVENT_NOTIFY','事件');
define('_MI_PICAL_EVENT_NOTIFYDSC','對顯示中的事件知選項');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY','事件知');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP','有事件時的知選項');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC','有事件時的知選項');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} 有的事件喔');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:01
define('_MI_PICAL_BNAME_NEW','的事件');
define('_MI_PICAL_BNAME_NEW_DESC','顯示的事件');
define('_MI_DEFAULT_VIEW','的月曆顯示面');
define('_MI_WEEKNUMBERING','算方式');
define('_MI_OPT_MINI_LIST','事件覽');
define('_MI_OPT_WEEKNOEACHMONTH','月算');
define('_MI_OPT_WEEKNOWHOLEYEAR','整算');
define('_MI_PICAL_ADMENU_CAT','類管');
define('_MI_PICAL_ADMENU_CAT2GROUP','類的覽限');
define('_MI_PICAL_ADMENU_TM','時區維');
define('_MI_PICAL_ADMENU_ICAL','匯iCalendar');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY','個類裡的事件');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP','個類裡有事件時的知');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC','個類裡有事件時的知');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE}  有的事件');

}

?>