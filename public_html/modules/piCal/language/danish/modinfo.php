<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define('_MI_PICAL_NAME', 'piCal');

// A brief description of this module
define('_MI_PICAL_DESC', 'Kalender modul med planlning');

// Default Locale
define('_MI_PICAL_DEFAULTLOCALE', 'usa');

// Names of blocks for this module (Not all module has blocks)
define('_MI_PICAL_BNAME_MINICAL', 'Minikalender');
define('_MI_PICAL_BNAME_MINICAL_DESC', 'Vis minikalender i blok');
define('_MI_PICAL_BNAME_MINICALEX', 'MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC', 'Minikalender med mulighed for udvidelse via plugin');
define('_MI_PICAL_BNAME_MONTHCAL', 'Medlig kalender');
define('_MI_PICAL_BNAME_MONTHCAL_DESC', 'Vis fuld strelse af medlig kalender');
define('_MI_PICAL_BNAME_TODAYS', 'Dagens events');
define('_MI_PICAL_BNAME_TODAYS_DESC', 'Vis dagens events');
define('_MI_PICAL_BNAME_THEDAYS', 'Events den %s');
define('_MI_PICAL_BNAME_THEDAYS_DESC', 'Vis events for den dag der markeres');
define('_MI_PICAL_BNAME_COMING', 'Fremtidige events');
define('_MI_PICAL_BNAME_COMING_DESC', 'Vis fremtidige events');
define('_MI_PICAL_BNAME_AFTER', 'Events efter %s');
define('_MI_PICAL_BNAME_AFTER_DESC', 'Vis events efter den dag der markeres');
define('_MI_PICAL_BNAME_NEW', 'Nye events');
define('_MI_PICAL_BNAME_NEW_DESC', 'Vis events sorteret efter dato');

// Names of submenu
define('_MI_PICAL_SM_SUBMIT', 'Indsend');

//define('_MI_PICAL_ADMENU1', 'Events indstillinger');

// Title of config items
define('_MI_USERS_AUTHORITY', 'Rettigheder for brugere');
define('_MI_GUESTS_AUTHORITY', 'Rettigheder for gter');
define('_MI_DEFAULT_VIEW', 'Default visning i centrum');
define('_MI_MINICAL_TARGET', 'Met for visningen af Minikalender');
define('_MI_COMING_NUMROWS', 'Antallet af events i kommende events blokken');
define('_MI_SKINFOLDER', 'Navn pskabelon folder');
define('_MI_PICAL_LOCALE', 'Lokale helligdage (Kontroll filerne i locales/*.php)');
define('_MI_SUNDAYCOLOR', 'Farven psdage');
define('_MI_WEEKDAYCOLOR', 'Farven phverdage');
define('_MI_SATURDAYCOLOR', 'Farven pldage');
define('_MI_HOLIDAYCOLOR', 'Farven phelligdage');
define('_MI_TARGETDAYCOLOR', 'Farven pdags dato');
define('_MI_SUNDAYBGCOLOR', 'Baggrundsfarven psdage');
define('_MI_WEEKDAYBGCOLOR', 'Baggrundsfarven phverdage');
define('_MI_SATURDAYBGCOLOR', 'Baggrundsfarven pldage');
define('_MI_HOLIDAYBGCOLOR', 'Baggrundsfarven phelligdage');
define('_MI_TARGETDAYBGCOLOR', 'Baggrundsfarven pdags dato');
define('_MI_CALHEADCOLOR', 'Farven phovedet  af kalenderen');
define('_MI_CALHEADBGCOLOR', 'Baggrundsfarven phovedet af kalenderen');
define('_MI_CALFRAMECSS', 'Stilen prammen af kalenderen');
define('_MI_CANOUTPUTICS', 'Rettigheder til at downloade ics filer');
define('_MI_MAXRRULEEXTRACT', 'erste grse for udtr af Rrule. (ANTAL)');
define('_MI_WEEKSTARTFROM', 'Ugen begynder med ');
define('_MI_WEEKNUMBERING', 'Nummerering af uger');
define('_MI_DAYSTARTFROM', 'Skillelinie for at adskille dage');
define('_MI_TIMEZONE_USING', 'Tidszone pserveren');
define('_MI_USE24HOUR', '24 timers ur (nej giver 12 timers ur)');
define('_MI_NAMEORUNAME', 'Vis navn pindsender');
define('_MI_DESCNAMEORUNAME', 'Vg hvilket navn der vises');
define('_MI_PROXYSETTINGS', 'Proxy indstillinger (host:port:user:pass)');

// Description of each config items
define('_MI_EDITBYGUESTDSC', 'Rettigheder til at tilfe events til gter');

// Options of each config items
define('_MI_OPT_AUTH_NONE', 'Kan ikke tilfe');
define('_MI_OPT_AUTH_WAIT', 'Kan tilfe men events krer godkendelse');
define('_MI_OPT_AUTH_POST', 'Kan tilfe events uden godkendelse');
define('_MI_OPT_AUTH_BYGROUP', 'Angivet i gruppe rettighederne');
define('_MI_OPT_MINI_PHPSELF', 'Aktuel side');
define('_MI_OPT_MINI_MONTHLY', 'Medlig kalender');
define('_MI_OPT_MINI_WEEKLY', 'Ugentlig kalender');
define('_MI_OPT_MINI_DAILY', 'Daglig kalender');
define('_MI_OPT_MINI_LIST', 'Event liste');
define('_MI_OPT_CANOUTPUTICS', 'kan downloade');
define('_MI_OPT_CANNOTOUTPUTICS', 'kan ikke downloade');
define('_MI_OPT_STARTFROMSUN', 'Sdag');
define('_MI_OPT_STARTFROMMON', 'Mandag');
define('_MI_OPT_WEEKNOEACHMONTH', 'efter hver med');
define('_MI_OPT_WEEKNOWHOLEYEAR', 'efter hele et');
define('_MI_OPT_USENAME', 'Rigtige navn');
define('_MI_OPT_USEUNAME', 'Login navn');
define('_MI_OPT_TZ_USEXOOPS', 'vdien af XOOPS konfiguration');
define('_MI_OPT_TZ_USEWINTER', 'vdien fra serveren som vintertid (anbefalet)');
define('_MI_OPT_TZ_USESUMMER', 'vdien fra serveren som sommertid');

// Admin Menus
define('_MI_PICAL_ADMENU0', 'Tilf events');
define('_MI_PICAL_ADMENU1', 'Events indstillinger');
define('_MI_PICAL_ADMENU_CAT', 'Kategori indstillinger');
define('_MI_PICAL_ADMENU_CAT2GROUP', 'Kategori rettigheder');
define('_MI_PICAL_ADMENU2', 'Globale rettigheder');
define('_MI_PICAL_ADMENU_TM', 'Tabel vedligeholdelse');
define('_MI_PICAL_ADMENU_PLUGINS', 'Tilfelses indstillinger');
define('_MI_PICAL_ADMENU_ICAL', 'Importer iCalendar');
define('_MI_PICAL_ADMENU_MYTPLSADMIN', 'Skabeloner');
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN', 'Blok og gruppe administration');

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
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'Globale piCal besked muligheder');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Kategori');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'Besked muligheder ved denne kategori');
define('_MI_PICAL_EVENT_NOTIFY', 'Event');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'Besked muligheder ved denne event');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'Ny event');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Inform mig n en ny event bliver oprettet');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Inform mig med beskrivelsen og n en ny event oprettes');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-besked: Ny event');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'Ny event i kategorien');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'Inform mig nen ny event er oprettet i kategorien');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'Inform mig med beskrivelsen og n en ny event er oprettet i kategorien.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-besked : Ny event i kategorier {CATEGORY_TITLE}');



}

?>