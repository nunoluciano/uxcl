<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {







// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:41
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:21
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:04:00
define('_MI_TIMEZONE_USING','Timezone of the server');
define('_MI_OPT_TZ_USEXOOPS','value of XOOPS config');
define('_MI_OPT_TZ_USEWINTER','value told from the server as winter time (recommended)');
define('_MI_OPT_TZ_USESUMMER','value told from the server as summer time');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:13
define('_MI_USE24HOUR','24hours system (No means 12hours system)');
define('_MI_PICAL_ADMENU_PLUGINS','Plugins Manager');

// Appended by Xoops Language Checker -GIJOE- in 2005-04-22 12:02:02
define('_MI_PICAL_BNAME_MINICALEX','MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC','Utbyggbar Minikalender med plugin system');

// Appended by Xoops Language Checker -GIJOE- in 2005-01-08 04:36:50
define('_MI_PICAL_DEFAULTLOCALE','');
define('_MI_PICAL_LOCALE','Locale (kontrollera filer i locales/*.php)');

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module

// Appended by Xoops Language Checker -GIJOE- in 2004-06-22 18:39:03
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','Block&Grupp Admin');

define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","Kalender modul med schema");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","Minikalender");
define("_MI_PICAL_BNAME_MINICAL_DESC","Visa Minikalender block");
define("_MI_PICAL_BNAME_MONTHCAL","M��adskalender");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Visa M��adskalender i full storlek");
define("_MI_PICAL_BNAME_TODAYS","Dagens h��delser");
define("_MI_PICAL_BNAME_TODAYS_DESC","Visa Dagens h��delser");
define("_MI_PICAL_BNAME_THEDAYS","Denna dagens %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Visa h��delser f�� markerad dag");
define("_MI_PICAL_BNAME_COMING","Kommande h��delser");
define("_MI_PICAL_BNAME_COMING_DESC","Visa kommande h��delser");
define("_MI_PICAL_BNAME_AFTER","H��delser efter %s");
define("_MI_PICAL_BNAME_AFTER_DESC","Visa h��delser efter markerad dag");

// Names of submenu
// define("_MI_PICAL_SMNAME1","");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Beh��igheter f�� anv��dare");
define("_MI_GUESTS_AUTHORITY", "Beh��igheter f�� g��ter");
define("_MI_MINICAL_TARGET", "Sida som visas i center blocket om man klickar p� Minikalendern");
define("_MI_COMING_NUMROWS", "Antalet visade h��delser i blocket f�� kommande h��delser");
define("_MI_SKINFOLDER", "Namnet p� den katalog som inneh��ler 'skin' filerna");
define("_MI_SUNDAYCOLOR", "F��g p� texten f�� S��dag");
define("_MI_WEEKDAYCOLOR", "F��g p� texten f�� Veckodagar");
define("_MI_SATURDAYCOLOR", "F��g p� texten f�� L��dag");
define("_MI_HOLIDAYCOLOR", "F��g p� texten f�� Helgdag");
define("_MI_TARGETDAYCOLOR", "F��g p� texten f�� Markerad dag");
define("_MI_SUNDAYBGCOLOR", "Bakgrundsf��g f�� S��dagar");
define("_MI_WEEKDAYBGCOLOR", "Bakgrundsf��g f�� Veckodagar");
define("_MI_SATURDAYBGCOLOR", "Bakgrundsf��g f�� L��dagar");
define("_MI_HOLIDAYBGCOLOR", "Bakgrundsf��g f�� Helgdagar");
define("_MI_TARGETDAYBGCOLOR", "Bakgrundsf��g p� markerad dag");
define("_MI_CALHEADCOLOR", "F��g p� texten i 'headern' p� kalendern");
define("_MI_CALHEADBGCOLOR", "Bakgrundsf��g i 'headern' p� kalendern");
define("_MI_CALFRAMECSS", "Stil p� ramen runt kalendern");
define("_MI_CANOUTPUTICS", "Till��else att mata ut ics filer?");
define("_MI_MAXRRULEEXTRACT", "��vre gr��s p� antalet h��delser som f�� extraheras med regel.(ANTAL)");
define("_MI_WEEKSTARTFROM", "F��sta dagen i veckan");
define("_MI_DAYSTARTFROM", "Gr��s f�� att separera dagar");
define("_MI_NAMEORUNAME" , "Vilket namn p� anv��daren skall visas" ) ;
define("_MI_DESCNAMEORUNAME" , "V��j vilket 'namn' som visas" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Till��else f�� g��ter att l��ga till h��delser");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "kan inte l��ga till");
define("_MI_OPT_AUTH_WAIT", "kan l��ga till men kr��er godk��nande");
define("_MI_OPT_AUTH_POST", "kan l��ga till utan godk��nande");
define("_MI_OPT_AUTH_BYGROUP", "Specificerad i Gruppr��tigheterna");
define("_MI_OPT_MINI_PHPSELF", "nuvarande sida");
define("_MI_OPT_MINI_MONTHLY", "m��adskalender");
define("_MI_OPT_MINI_WEEKLY", "veckokalender");
define("_MI_OPT_MINI_DAILY", "dagskalender");
define("_MI_OPT_CANOUTPUTICS", "kan mata ut");
define("_MI_OPT_CANNOTOUTPUTICS", "kan inte mata ut");
define("_MI_OPT_STARTFROMSUN", "S��dag");
define("_MI_OPT_STARTFROMMON", "M��dag");
define("_MI_OPT_USENAME" , "Anv��darnamn" ) ;
define("_MI_OPT_USEUNAME" , "Login Namn" ) ;

// Admin Menus
define("_MI_PICAL_ADMENU0","Godk��na h��delser");
define("_MI_PICAL_ADMENU1","iCalendar I/O");
define("_MI_PICAL_ADMENU2","Grupp r��tigheter");

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

// Text for notifications
define('_MI_PICAL_GLOBAL_NOTIFY', 'Globala');
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'Globala piCal underr��telse inst��lningar.');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Kategori');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'Underr��telse inst��lningar som g��ler f�� aktuell kategori.');
define('_MI_PICAL_EVENT_NOTIFY', 'H��delse');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'Underr��telse inst��lningar som g��ler f�� aktuell h��delse.');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'Ny h��delse');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Underr��ta mig n�� en ny h��delse har skapats.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Mottag underr��telse n�� en ny h��delse har skapats.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} automatiska underr��telser : Ny h��delse');



// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:01
define('_MI_PICAL_BNAME_NEW','Nyligen publicerade h��delser');
define('_MI_PICAL_BNAME_NEW_DESC','Visa h��delser sorterade med nyaste ��erst');
define('_MI_PICAL_SM_SUBMIT','L��g till');
define('_MI_DEFAULT_VIEW','Default Vy i center');
define('_MI_WEEKNUMBERING','Numrerings regel f�� veckor');
define('_MI_OPT_MINI_LIST','H��delse lista');
define('_MI_OPT_WEEKNOEACHMONTH','f�� varje m��ad');
define('_MI_OPT_WEEKNOWHOLEYEAR','f�� hela ��et');
define('_MI_PICAL_ADMENU_CAT','Kategori Administration');
define('_MI_PICAL_ADMENU_CAT2GROUP','R��tigheter f�� Kategorier');
define('_MI_PICAL_ADMENU_TM','Tabell Underh��l');
define('_MI_PICAL_ADMENU_ICAL','Importera iCalendar');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY','Ny h��delse i denna kategori');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP','Meddela mig n�� en ny h��delse �� skapad i denna kategori.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC','Mottag underr��telse n�� en ny h��delse �� skapad i denna kategori.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : Ny h��delse');

}

?>
