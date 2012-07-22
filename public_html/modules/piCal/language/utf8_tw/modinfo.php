<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:41
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:21
define('_MI_PICAL_ADMENU_MYTPLSADMIN','樣版管理');

define( 'PICAL_MI_LOADED' , 1 ) ;


// Module Info

// The name of this module

define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','區塊與群組管理');
define("_MI_PICAL_NAME","piCal行事?");

// A brief description of this module
define("_MI_PICAL_DESC","具有多功能的行事?模組");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","迷?日?");
define("_MI_PICAL_BNAME_MINICAL_DESC","顯示迷?日?區塊");
define('_MI_PICAL_BNAME_MINICALEX','進階小月?');
define('_MI_PICAL_BNAME_MINICALEX_DESC','可以搭配 plugin 的小月?');
define("_MI_PICAL_BNAME_MONTHCAL","月?");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","顯示完整的月?");
define("_MI_PICAL_BNAME_TODAYS","今日事件");
define("_MI_PICAL_BNAME_TODAYS_DESC","顯示今天的事件");
define("_MI_PICAL_BNAME_THEDAYS","%s 的事件");
define("_MI_PICAL_BNAME_THEDAYS_DESC","顯示指出日期的事件");
define("_MI_PICAL_BNAME_COMING","近期事件");
define("_MI_PICAL_BNAME_COMING_DESC","顯示近期的事件");
define("_MI_PICAL_BNAME_AFTER","今日以後事件");
define("_MI_PICAL_BNAME_AFTER_DESC","顯示今日以後的事件");

// Names of submenu
define('_MI_PICAL_SM_SUBMIT','新增');

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "用?權限");
define("_MI_GUESTS_AUTHORITY", "訪客權限");
define("_MI_MINICAL_TARGET", "當點選迷?行事?時所要顯示在畫面中央的行事?");
define("_MI_COMING_NUMROWS", "在近期事件區塊顯示事件的數目");
define("_MI_SKINFOLDER", "行事?樣式的資料夾名稱 (images目??)");
define('_MI_PICAL_DEFAULTLOCALE','utf8_taiwan');
define('_MI_PICAL_LOCALE','地域設定 <br />將自動帶入當地例假日，台灣已?建至2010年為止之國?與農?假日');
define("_MI_SUNDAYCOLOR", "星期日的顏色");
define("_MI_WEEKDAYCOLOR", "平日的顏色");
define("_MI_SATURDAYCOLOR", "星期六的顏色");
define("_MI_HOLIDAYCOLOR", "假日的顏色");
define("_MI_TARGETDAYCOLOR", "預定日的顏色");
define("_MI_SUNDAYBGCOLOR", "星期日的背景顏色");
define("_MI_WEEKDAYBGCOLOR", "平日的顏色");
define("_MI_SATURDAYBGCOLOR", "星期六的背景顏色");
define("_MI_HOLIDAYBGCOLOR", "假日的背景顏色");
define("_MI_TARGETDAYBGCOLOR", "預定日的背景顏色");
define("_MI_CALHEADCOLOR", "行事?主題部?的顏色");
define("_MI_CALHEADBGCOLOR", "行事?主題部?的背景顏色");
define("_MI_CALFRAMECSS", "行事?視窗的樣式");
define("_MI_CANOUTPUTICS", "匯出 ics ?案的權限");
define("_MI_MAXRRULEEXTRACT", "重複事件展開上限數.");
define("_MI_WEEKSTARTFROM", "?週的第一天是");
define('_MI_TIMEZONE_USING','伺服器的時區指定');
define('_MI_USE24HOUR','是否使用24小時制 (如選擇否將自動以12小時制)');
define('_MI_NAMEORUNAME','顯示發表者名');
define('_MI_DESCNAMEORUNAME','請選擇顯示帳號或是真實姓名(?稱)');

// Description of each config items
define("_MI_EDITBYGUESTDSC", "訪客新增事件的權限");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "無法新增事件");
define("_MI_OPT_AUTH_WAIT", "可以新增事件並且需要審核");
define("_MI_OPT_AUTH_POST", "可以新增事件但不需要審核");
define("_MI_OPT_AUTH_BYGROUP", "依照群組權限設定");
define("_MI_OPT_MINI_PHPSELF", "目前頁面");
define("_MI_OPT_MINI_MONTHLY", "月行事?");
define("_MI_OPT_MINI_WEEKLY", "週行事?");
define("_MI_OPT_MINI_DAILY", "日行事?");
define("_MI_OPT_CANNOTOUTPUTICS", "可以匯出");
define("_MI_OPT_CANOUTPUTICS", "無法匯出");
define("_MI_OPT_STARTFROMSUN", "星期日");
define("_MI_OPT_STARTFROMMON", "星期一");
define('_MI_OPT_TZ_USEXOOPS','XOOPS的預設?');
define('_MI_OPT_TZ_USEWINTER','由伺服器取得的冬令時間 (推薦)');
define('_MI_OPT_TZ_USESUMMER','由伺服器取得的夏令時間');
define('_MI_OPT_USENAME','真實姓名');
define('_MI_OPT_USEUNAME','登入帳號');


// Admin Menus
define("_MI_PICAL_ADMENU0","待審事件區");
define("_MI_PICAL_ADMENU1","事件管理區");
define("_MI_PICAL_ADMENU2","群組權限管理");
define('_MI_PICAL_ADMENU_PLUGINS','Plugin管理區');

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
define('_MI_DAYSTARTFROM','切換一日的時間');
define('_MI_PICAL_GLOBAL_NOTIFY','模組整體');
define('_MI_PICAL_GLOBAL_NOTIFYDSC','所有 piCal 模組的通知選項');
define('_MI_PICAL_CATEGORY_NOTIFY','類別');
define('_MI_PICAL_CATEGORY_NOTIFYDSC','針對所選擇類別的通知選項');
define('_MI_PICAL_EVENT_NOTIFY','事件');
define('_MI_PICAL_EVENT_NOTIFYDSC','針對顯示中的事件通知選項');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY','新事件通知');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP','有新增事件時的通知選項');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC','有新增事件時的通知選項');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} ：有新增的事件?！');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:01
define('_MI_PICAL_BNAME_NEW','新的事件');
define('_MI_PICAL_BNAME_NEW_DESC','顯示新增的事件');
define('_MI_DEFAULT_VIEW','預設的月?顯示畫面');
define('_MI_WEEKNUMBERING','週別計算方式');
define('_MI_OPT_MINI_LIST','事件一覽');
define('_MI_OPT_WEEKNOEACHMONTH','以?月計算');
define('_MI_OPT_WEEKNOWHOLEYEAR','以整年計算');
define('_MI_PICAL_ADMENU_CAT','類別管理');
define('_MI_PICAL_ADMENU_CAT2GROUP','類別的瀏覽權限');
define('_MI_PICAL_ADMENU_TM','時區維護');
define('_MI_PICAL_ADMENU_ICAL','匯入iCalendar');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY','?個類別裡的新增事件');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP','在這個類別裡有新增事件時的通知');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC','在這個類別裡有新增事件時的通知');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} ： 有新的事件');

}

?>