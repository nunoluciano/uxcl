<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","Calendar module with Scheduler");

// Default Locale
define("_MI_PICAL_DEFAULTLOCALE","usa");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","MiniCalendar");
define("_MI_PICAL_BNAME_MINICAL_DESC","Display MiniCalendar block");
define("_MI_PICAL_BNAME_MINICALEX","MiniCalendarEx");
define("_MI_PICAL_BNAME_MINICALEX_DESC","Extensible minicalendar with plugin system");
define("_MI_PICAL_BNAME_MONTHCAL","Monthly calendar");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Display full size of Monthly calendar");
define("_MI_PICAL_BNAME_TODAYS","Today's events");
define("_MI_PICAL_BNAME_TODAYS_DESC","Display events for today");
define("_MI_PICAL_BNAME_THEDAYS","Events on %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Display events for the day indicated");
define("_MI_PICAL_BNAME_COMING","Coming Events");
define("_MI_PICAL_BNAME_COMING_DESC","Display Coming Events");
define("_MI_PICAL_BNAME_AFTER","Events after %s");
define("_MI_PICAL_BNAME_AFTER_DESC","Display events after the day indicated");
define("_MI_PICAL_BNAME_NEW","Events newly posted");
define("_MI_PICAL_BNAME_NEW_DESC","Display events ordered like that newer is upper");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","Submit");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Authorities of Users");
define("_MI_GUESTS_AUTHORITY", "Authorities of Guests");
define("_MI_DEFAULT_VIEW", "Default View in center");
define("_MI_MINICAL_TARGET", "Target View from MiniCalendar");
define("_MI_COMING_NUMROWS", "The number of events in Coming Events block");
define("_MI_SKINFOLDER", "Name of skin folder");
define("_MI_PICAL_LOCALE", "Locale (check files in locales/*.php)");
define("_MI_SUNDAYCOLOR", "Color of Sunday");
define("_MI_WEEKDAYCOLOR", "Color of weekday");
define("_MI_SATURDAYCOLOR", "Color of Saturday");
define("_MI_HOLIDAYCOLOR", "Color of holiday");
define("_MI_TARGETDAYCOLOR", "Color of targeted day");
define("_MI_SUNDAYBGCOLOR", "Bgcolor of Sunday");
define("_MI_WEEKDAYBGCOLOR", "Bgcolor of weekday");
define("_MI_SATURDAYBGCOLOR", "Bgcolor of Saturday");
define("_MI_HOLIDAYBGCOLOR", "Bgcolor of holiday");
define("_MI_TARGETDAYBGCOLOR", "Bgcolor of targeted day");
define("_MI_CALHEADCOLOR", "Color of header part of calendar");
define("_MI_CALHEADBGCOLOR", "Bgcolor of header part of calendar");
define("_MI_CALFRAMECSS", "Style for the frame of calendar");
define("_MI_CANOUTPUTICS", "Permission of outputting ics files");
define("_MI_MAXRRULEEXTRACT", "Upper limit of events extracted by Rrule.(COUNT)");
define("_MI_WEEKSTARTFROM", "Beginning day of the week");
define("_MI_WEEKNUMBERING", "Numbering rule for weeks");
define("_MI_DAYSTARTFROM", "Borderline to separate days");
define("_MI_TIMEZONE_USING", "Timezone of the server");
define("_MI_USE24HOUR", "24hours system (No means 12hours system)");
define("_MI_NAMEORUNAME" , "Poster name displayed" ) ;
define("_MI_DESCNAMEORUNAME" , "Select which 'name' is displayed" ) ;
define("_MI_PROXYSETTINGS" , "Proxy settings (host:port:user:pass)" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Permission of adding events by Guest");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "cannot add");
define("_MI_OPT_AUTH_WAIT", "can add but Events need approval");
define("_MI_OPT_AUTH_POST", "can add Events without approval");
define("_MI_OPT_AUTH_BYGROUP", "Specified in Group's permissions");
define("_MI_OPT_MINI_PHPSELF", "Current Page");
define("_MI_OPT_MINI_MONTHLY", "Monthly Calendar");
define("_MI_OPT_MINI_WEEKLY", "Weekly Calendar");
define("_MI_OPT_MINI_DAILY", "Daily Calendar");
define("_MI_OPT_MINI_LIST", "Event List");
define("_MI_OPT_CANOUTPUTICS", "can output");
define("_MI_OPT_CANNOTOUTPUTICS", "cannot output");
define("_MI_OPT_STARTFROMSUN", "Sunday");
define("_MI_OPT_STARTFROMMON", "Monday");
define("_MI_OPT_WEEKNOEACHMONTH", "by each month");
define("_MI_OPT_WEEKNOWHOLEYEAR", "by whole year");
define("_MI_OPT_USENAME" , "Real Name" ) ;
define("_MI_OPT_USEUNAME" , "Login Name" ) ;
define("_MI_OPT_TZ_USEXOOPS" , "value of XOOPS config" ) ;
define("_MI_OPT_TZ_USEWINTER" , "value told from the server as winter time (recommended)" ) ;
define("_MI_OPT_TZ_USESUMMER" , "value told from the server as summer time" ) ;

// Admin Menus
define("_MI_PICAL_ADMENU0","Admitting Events");
define("_MI_PICAL_ADMENU1","Events Manager");
define("_MI_PICAL_ADMENU_CAT","Categories Manager");
define("_MI_PICAL_ADMENU_CAT2GROUP","Category's Permissions");
define("_MI_PICAL_ADMENU2","Global Permissions");
define("_MI_PICAL_ADMENU_TM","Table Maintenance");
define("_MI_PICAL_ADMENU_PLUGINS","Plugins Manager");
define("_MI_PICAL_ADMENU_ICAL","Importing iCalendar");
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');
define("_MI_PICAL_ADMENU_MYBLOCKSADMIN","Blocks & Groups Admin");

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
define('_MI_PICAL_GLOBAL_NOTIFY', 'Global');
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'Global piCal notification options.');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Category');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'Notification options that apply to the current category.');
define('_MI_PICAL_EVENT_NOTIFY', 'Event');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'Notification options that apply to the current event.');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'New Event');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Notify me when a new event is created.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Notify me with the description included when a new event is created.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New event');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'New Event in the Category');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'Notify me when a new event is created in the Category.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'Notify me with the description included when a new event is created in the Category.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New event in {CATEGORY_TITLE}');



}

?>