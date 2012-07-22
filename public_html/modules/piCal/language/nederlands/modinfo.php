<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {







// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:39
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:19
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:04:00
define('_MI_TIMEZONE_USING','Timezone of the server');
define('_MI_OPT_TZ_USEXOOPS','value of XOOPS config');
define('_MI_OPT_TZ_USEWINTER','value told from the server as winter time (recommended)');
define('_MI_OPT_TZ_USESUMMER','value told from the server as summer time');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:13
define('_MI_USE24HOUR','24hours system (No means 12hours system)');
define('_MI_PICAL_ADMENU_PLUGINS','Plugins Manager');

// Appended by Xoops Language Checker -GIJOE- in 2005-04-22 12:02:01
define('_MI_PICAL_BNAME_MINICALEX','MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC','Extensible minicalendar with plugin system');

// Appended by Xoops Language Checker -GIJOE- in 2005-01-08 04:36:50
define('_MI_PICAL_DEFAULTLOCALE','');
define('_MI_PICAL_LOCALE','Locale (check files in locales/*.php)');

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module

// Appended by Xoops Language Checker -GIJOE- in 2004-06-22 18:39:03
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','Blocks&Groups Admin');

define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","Kalendermodule met activiteitsplanner");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","Mini-Kalender");
define("_MI_PICAL_BNAME_MINICAL_DESC","Mini-Kalender-Blok tonen");
define("_MI_PICAL_BNAME_MONTHCAL","Maandkalender");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Maandkalender in volle grootte tonen");
define("_MI_PICAL_BNAME_TODAYS","Huidige activiteiten");
define("_MI_PICAL_BNAME_TODAYS_DESC","Huidige activiteiten tonen");
define("_MI_PICAL_BNAME_THEDAYS","Activiteiten per %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Termine des Tages markiert anzeigen");
define("_MI_PICAL_BNAME_COMING","Eerstvolgende activiteiten");
define("_MI_PICAL_BNAME_COMING_DESC","Eerstvolgende activiteiten tonen");
define("_MI_PICAL_BNAME_AFTER","Activiteiten na %s");
define("_MI_PICAL_BNAME_AFTER_DESC","Activiteiten na deze dag tonen");

// Names of submenu
// define("_MI_PICAL_SMNAME1","");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Rechten voor gebruikers");
define("_MI_GUESTS_AUTHORITY", "Rechten voor gasten");
define("_MI_MINICAL_TARGET", "Kalendervoorstelling die wordt getoond wanneer op een datum in de Mini-Kalender wordt geklikt");
define("_MI_COMING_NUMROWS", "Aantal getoonde activiteiten in het 'Eerstvolgende activiteiten'-blok'");
define("_MI_SKINFOLDER", "Skin");
define("_MI_SUNDAYCOLOR", "Tekstkleur voor zondagen");
define("_MI_WEEKDAYCOLOR", "Tekstkleur voor weekdagen");
define("_MI_SATURDAYCOLOR", "Tekstkleur voor zaterdagen");
define("_MI_HOLIDAYCOLOR", "Tekstkleur voor vrijdagen");
define("_MI_TARGETDAYCOLOR", "Tekstkleur voor dagen met activiteiten");
define("_MI_SUNDAYBGCOLOR", "Achtergrondkleur voor zondagen");
define("_MI_WEEKDAYBGCOLOR", "Achtergrondkleur voor weekdagen");
define("_MI_SATURDAYBGCOLOR", "Achtergrondkleur voor zaterdagen");
define("_MI_HOLIDAYBGCOLOR", "Achtergrondkleur voor feestdag");
define("_MI_TARGETDAYBGCOLOR", "Achtergrondkleur voor dagen met activiteiten");
define("_MI_CALHEADCOLOR", "Kleur van de kalenderkop");
define("_MI_CALHEADBGCOLOR", "Achtergrondkleur van de kalenderkop");
define("_MI_CALFRAMECSS", "CSS-stijl van het kalenderraam");
define("_MI_CANOUTPUTICS", "iCalendar-Data (.ics) export mogelijk maken?");
define("_MI_MAXRRULEEXTRACT", "max. aantal activiteiten die door het Terugkeerpatroon kunnen gegenereerd worden");
define("_MI_WEEKSTARTFROM", "De week begint op");

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Rechten voor gasten om activiteiten toe te voegen");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "mogen niet toevoegen");
define("_MI_OPT_AUTH_WAIT", "mogen toevoegen maar hebben goedkeuring nodig");
define("_MI_OPT_AUTH_POST", "mogen direct zonder goedkeuring toevoegen");
define("_MI_OPT_AUTH_BYGROUP", "Vastgelegd door groepsrechten");
define("_MI_OPT_MINI_PHPSELF", "Startpagina");
define("_MI_OPT_MINI_MONTHLY", "Maandkalender");
define("_MI_OPT_MINI_WEEKLY", "Weekkalender");
define("_MI_OPT_MINI_DAILY", "Dagkalender");
define("_MI_OPT_CANNOTOUTPUTICS", "ICS output activeren");
define("_MI_OPT_CANOUTPUTICS", "ICS output deactiveren");
define("_MI_OPT_STARTFROMSUN", "Zondag");
define("_MI_OPT_STARTFROMMON", "Maandag");


// Admin Menus
define("_MI_PICAL_ADMENU0","Activiteit goedkeuren");
define("_MI_PICAL_ADMENU1","iCalendar I/O");
define("_MI_PICAL_ADMENU2","Groepsrechten");

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
define('_MI_NAMEORUNAME','Poster name displayed');
define('_MI_DESCNAMEORUNAME','Select which \'name\' is displayed');
define('_MI_OPT_USENAME','Handle Name');
define('_MI_OPT_USEUNAME','Login Name');

// Appended by Xoops Language Checker -GIJOE- in 2003-12-26 10:55:16
define('_MI_DAYSTARTFROM','Borderline to separate days');
define('_MI_PICAL_GLOBAL_NOTIFY','Global');
define('_MI_PICAL_GLOBAL_NOTIFYDSC','Global piCal notification options.');
define('_MI_PICAL_CATEGORY_NOTIFY','Category');
define('_MI_PICAL_CATEGORY_NOTIFYDSC','Notification options that apply to the current category.');
define('_MI_PICAL_EVENT_NOTIFY','Event');
define('_MI_PICAL_EVENT_NOTIFYDSC','Notification options that apply to the current event.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY','New Event');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP','Notify me when a new event is created.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC','Receive notification when a new event is created.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : New event');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:01
define('_MI_PICAL_BNAME_NEW','Events newly posted');
define('_MI_PICAL_BNAME_NEW_DESC','Display events ordered like that newer is upper');
define('_MI_PICAL_SM_SUBMIT','Submit');
define('_MI_DEFAULT_VIEW','Default View in center');
define('_MI_WEEKNUMBERING','Numbering rule for weeks');
define('_MI_OPT_MINI_LIST','event list');
define('_MI_OPT_WEEKNOEACHMONTH','by each month');
define('_MI_OPT_WEEKNOWHOLEYEAR','by whole year');
define('_MI_PICAL_ADMENU_CAT','Categories Manager');
define('_MI_PICAL_ADMENU_CAT2GROUP','Category\'s Permissions');
define('_MI_PICAL_ADMENU_TM','Table Maintenance');
define('_MI_PICAL_ADMENU_ICAL','Importing iCalendar');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY','New Event in the Category');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP','Notify me when a new event is created in the Category.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC','Receive notification when a new event is created in the Category.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : New event');


}

?>
