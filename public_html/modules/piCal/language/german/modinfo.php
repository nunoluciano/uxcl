<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {

// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:41
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:21
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:03:58
define('_MI_TIMEZONE_USING','Zeitzone des Servers');
define('_MI_OPT_TZ_USEXOOPS','Wle die XOOPS-Konfiguration');
define('_MI_OPT_TZ_USEWINTER','Wle die Zeit des Servers als Winterzeit (empfohlen)');
define('_MI_OPT_TZ_USESUMMER','Wle die Zeit des Servers als Sommerzeit');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:11
define('_MI_USE24HOUR','24 Stunden-System (Nein hei, 12 Stunden-System)');
define('_MI_PICAL_ADMENU_PLUGINS','Plugin Manager');

// Appended by Xoops Language Checker -GIJOE- in 2005-04-22 12:02:00
define('_MI_PICAL_BNAME_MINICALEX','MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC','Erweiterbarer Minikalender mit Plugin-System');

// Appended by Xoops Language Checker -GIJOE- in 2005-01-08 04:36:48
define('_MI_PICAL_DEFAULTLOCALE','austria');
define('_MI_PICAL_LOCALE','Locale (check files in locales/*.php)');

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module

// Appended by Xoops Language Checker -GIJOE- in 2004-06-22 18:39:02
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','Blocks&Groups Admin');

define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","Kalendermodul mit Terminplaner");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","Minikalender");
define("_MI_PICAL_BNAME_MINICAL_DESC","Minikalender-Block anzeigen");
define("_MI_PICAL_BNAME_MONTHCAL","Monatskalender");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Monatskalender in voller Größe anzeigen");
define("_MI_PICAL_BNAME_TODAYS","Heutige Termine");
define("_MI_PICAL_BNAME_TODAYS_DESC","Heutige Termine anzeigen");
define("_MI_PICAL_BNAME_THEDAYS","Termine des %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Termine des Tages markiert anzeigen");
define("_MI_PICAL_BNAME_COMING","Kommende Termine");
define("_MI_PICAL_BNAME_COMING_DESC","Kommende Termine anzeigen");
define("_MI_PICAL_BNAME_AFTER","Termine nach %s");
define("_MI_PICAL_BNAME_AFTER_DESC","Termine nach diesem Tag markiert anzeigen");
define("_MI_PICAL_BNAME_NEW","Neu eingetragene Termine");
define("_MI_PICAL_BNAME_NEW_DESC","Termine werden geordnet angezeigt (neuere zuerst)");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","Eintragen");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Berechtigungen f Benutzer");
define("_MI_GUESTS_AUTHORITY", "Berechtigungen f Gte");
define("_MI_DEFAULT_VIEW", "Standardansicht");
define("_MI_MINICAL_TARGET", "Ansicht, die angezeigt werden soll, wenn ein Datum auf dem MiniKalender angeklickt wird");
define("_MI_COMING_NUMROWS", "Anzahl der angezeigten Termine im 'Kommende Termine Block'");
define("_MI_SKINFOLDER", "Skin");
define("_MI_SUNDAYCOLOR", "Textfarbe f Sonntag");
define("_MI_WEEKDAYCOLOR", "Textfarbe f Wochentage");
define("_MI_SATURDAYCOLOR", "Textfarbe f Samstag");
define("_MI_HOLIDAYCOLOR", "Textfarbe f Feiertage");
define("_MI_TARGETDAYCOLOR", "Textfarbe f ausgewlten Tag");
define("_MI_SUNDAYBGCOLOR", "Hintergrundfarbe f Sonntag");
define("_MI_WEEKDAYBGCOLOR", "Hintergrundfarbe f Wochentage");
define("_MI_SATURDAYBGCOLOR", "Hintergrundfarbe f Samstag");
define("_MI_HOLIDAYBGCOLOR", "Hintergrundfarbe f Feiertage");
define("_MI_TARGETDAYBGCOLOR", "Hintergrundfarbe f ausgewlten Tag");
define("_MI_CALHEADCOLOR", "Farbe des Kalender-Headers");
define("_MI_CALHEADBGCOLOR", "Hintergrundfarbe des Kalender-Headers");
define("_MI_CALFRAMECSS", "CSS-Stil des Kalenderrahmens");
define("_MI_CANOUTPUTICS", "iCalendar-Datei (.ics) Ausgabe ermlichen?");
define("_MI_MAXRRULEEXTRACT", "max. Anzahl an Terminen, die durch die Regeln f wiederkehrende Termine erzeugt werden");
define("_MI_WEEKSTARTFROM", "Die Woche beginnt mit");
define("_MI_WEEKNUMBERING", "Wochennummerierung");
define('_MI_DAYSTARTFROM','Zeitpunkt des Tagesbeginns');
define('_MI_NAMEORUNAME','Welcher \'Name\' des Autors soll angezeigt werden?');
define('_MI_DESCNAMEORUNAME','');

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Berechtigungen f Gte, um Termine hinzuzufen");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "dfen nicht hinzufen");
define("_MI_OPT_AUTH_WAIT", "dfen hinzufen, brauchen aber Freigabe");
define("_MI_OPT_AUTH_POST", "dfen direkt ohne Freigabe hinzufen");
define("_MI_OPT_AUTH_BYGROUP", "Festgelegt durch Gruppenberechtigungen");
define("_MI_OPT_MINI_PHPSELF", "aktuelle Seite");
define("_MI_OPT_MINI_MONTHLY", "Monatskalender");
define("_MI_OPT_MINI_WEEKLY", "Wochenkalender");
define("_MI_OPT_MINI_DAILY", "Tageskalender");
define("_MI_OPT_MINI_LIST", "Terminliste");
define("_MI_OPT_CANOUTPUTICS", "ICS Ausgabe aktivieren");
define("_MI_OPT_CANNOTOUTPUTICS", "ICS Ausgabe deaktivieren");
define("_MI_OPT_STARTFROMSUN", "Sonntag");
define("_MI_OPT_STARTFROMMON", "Montag");
define("_MI_OPT_WEEKNOEACHMONTH", "jeweils f einen Monat");
define("_MI_OPT_WEEKNOWHOLEYEAR", "durchgehend f das ganze Jahr");
define('_MI_OPT_USENAME','Name');
define('_MI_OPT_USEUNAME','Login Name');

// Admin Menus
define("_MI_PICAL_ADMENU0","Termin-Freigabe");
define("_MI_PICAL_ADMENU1","Termin-Manager");
define("_MI_PICAL_ADMENU_CAT","Kategorie-Manager");
define("_MI_PICAL_ADMENU_CAT2GROUP","Kategorie-Berechtigungen");
define("_MI_PICAL_ADMENU2","Gruppenberechtigungen");
define("_MI_PICAL_ADMENU_TM","Tabellen-Wartung");
define("_MI_PICAL_ADMENU_ICAL","iCalendar Import");

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
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'Globale piCal Benachrichtigungsoptionen');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Kategorie');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'Benachrichtigungsoptionen, die der aktuellen Kategorie entsprechen');
define('_MI_PICAL_EVENT_NOTIFY', 'Termin');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'Benachrichtigungsoptionen, die dem aktuellen Termin entsprechen');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'Neuer Termin');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Benachrichtigung erfolgt, wenn ein neuer Termin eingetragen wird.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Eine Benachrichtigung wird automatisch zugeschickt, sobald ein neuer Termin eingetragen wird.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} Automatische Benachrichtigung: Neuer Termin');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'Neuer Termin in dieser Kategorie');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'Benachrichtigung erfolgt, wenn ein neuer Termin in dieser Kategorie eingetragen wird.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'Eine Benachrichtigung wird automatisch zugeschickt, sobald ein neuer Termin in dieser Kategorie eingetragen wird.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} Automatische Benachrichtigung: Neuer Termin');


}

?>
