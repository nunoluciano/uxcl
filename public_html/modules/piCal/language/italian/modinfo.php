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

// Appended by Xoops Language Checker -GIJOE- in 2005-04-22 12:02:02
define('_MI_PICAL_BNAME_MINICALEX','MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC','Extensible minicalendar with plugin system');

// Appended by Xoops Language Checker -GIJOE- in 2005-01-08 04:36:50
define('_MI_PICAL_DEFAULTLOCALE','italia');
define('_MI_PICAL_LOCALE','Locale (controlla i file in locales/*.php)');

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","Modulo Calendario e Pianificazione eventi");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","CalendarioMini");
define("_MI_PICAL_BNAME_MINICAL_DESC","Mostra il calendarioMini nel blocco");
define("_MI_PICAL_BNAME_MONTHCAL","Calendario mensile");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Mostra il calendario mensile a grandezza piena");
define("_MI_PICAL_BNAME_TODAYS","Eventi di oggi");
define("_MI_PICAL_BNAME_TODAYS_DESC","Mostra gli eventi di oggi");
define("_MI_PICAL_BNAME_THEDAYS","Eventi del %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Mostra gli eventi del giorno specificato");
define("_MI_PICAL_BNAME_COMING","Prossimi eventi");
define("_MI_PICAL_BNAME_COMING_DESC","Mostra prossimi eventi");
define("_MI_PICAL_BNAME_AFTER","Eventi dopo il %s");
define("_MI_PICAL_BNAME_AFTER_DESC","Mostra gli eventi dopo il giorno indicato");
define("_MI_PICAL_BNAME_NEW","Nuovi eventi inviati");
define("_MI_PICAL_BNAME_NEW_DESC","Mostra gli ultimi eventi inviati");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","Invia");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Permessi degli Utenti");
define("_MI_GUESTS_AUTHORITY", "Permessi degli ospiti");
define("_MI_DEFAULT_VIEW", "Vista centrale predefinita");
define("_MI_MINICAL_TARGET", "Vista per il calendarioMini");
define("_MI_COMING_NUMROWS", "Numero di eventi da visualizzare nel blocco 'Prossimi Eventi'");
define("_MI_SKINFOLDER", "Nome della directory del tema");
define("_MI_SUNDAYCOLOR", "Colore della Domenica");
define("_MI_WEEKDAYCOLOR", "Colore dei feriali");
define("_MI_SATURDAYCOLOR", "Colore del Sabato");
define("_MI_HOLIDAYCOLOR", "Colore delle feste");
define("_MI_TARGETDAYCOLOR", "Colore del giorno selezionato");
define("_MI_SUNDAYBGCOLOR", "Colore di sfondo della Domenica");
define("_MI_WEEKDAYBGCOLOR", "Colore di sfondo dei feriali");
define("_MI_SATURDAYBGCOLOR", "Colore di sfondodel Sabato");
define("_MI_HOLIDAYBGCOLOR", "Colore di sfondodelle feste");
define("_MI_TARGETDAYBGCOLOR", "Colore di sfondodel giorno selezionato");
define("_MI_CALHEADCOLOR", "Colore della testata del calendario");
define("_MI_CALHEADBGCOLOR", "Colore di sfondo della testata del calendario");
define("_MI_CALFRAMECSS", "Stile del bordo del calendario");
define("_MI_CANOUTPUTICS", "Permessi di esportazione file ics");
define("_MI_MAXRRULEEXTRACT", "Limite di eventi estratti da rrule. (COUNT)");
define("_MI_WEEKSTARTFROM", "Inizio della settimana");
define("_MI_WEEKNUMBERING", "Numerazione delle settimane");
define("_MI_DAYSTARTFROM", "Ora limite per separare i giorni");
define("_MI_NAMEORUNAME" , "Nome visualizzato" ) ;
define("_MI_DESCNAMEORUNAME" , "Scegli quale 'nome' visualizzato" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Permessi degli ospiti di inserire eventi");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "non puinserire");
define("_MI_OPT_AUTH_WAIT", "puinserire ma necessita approvazione");
define("_MI_OPT_AUTH_POST", "puinserire senza approvazione");
define("_MI_OPT_AUTH_BYGROUP", "Speficificato nei permessi di gruppo");
define("_MI_OPT_MINI_PHPSELF", "Pagina attuale");
define("_MI_OPT_MINI_MONTHLY", "calendario mensile");
define("_MI_OPT_MINI_WEEKLY", "calendario settimanale");
define("_MI_OPT_MINI_DAILY", "calendario giornaliero");
define("_MI_OPT_MINI_LIST", "lista eventi");
define("_MI_OPT_CANOUTPUTICS", "puesportare");
define("_MI_OPT_CANNOTOUTPUTICS", "non puesportare");
define("_MI_OPT_STARTFROMSUN", "Domenica");
define("_MI_OPT_STARTFROMMON", "Luned);
define("_MI_OPT_WEEKNOEACHMONTH", "per ogni mese");
define("_MI_OPT_WEEKNOWHOLEYEAR", "per l'intero anno");
define("_MI_OPT_USENAME" , "Nickname" ) ;
define("_MI_OPT_USEUNAME" , "Nome del Login" ) ;

// Admin Menus
define("_MI_PICAL_ADMENU0","Eventi da approvare");
define("_MI_PICAL_ADMENU1","Gestione Eventi");
define("_MI_PICAL_ADMENU_CAT","Gestione Categorie");
define("_MI_PICAL_ADMENU_CAT2GROUP","Permessi delle categorie");
define("_MI_PICAL_ADMENU2","Permessi Globali");
define("_MI_PICAL_ADMENU_TM","Manutenzione Tabella");
define("_MI_PICAL_ADMENU_ICAL","Importazione iCalendar");
define("_MI_PICAL_ADMENU_MYBLOCKSADMIN","Amministrazione Blocchi&Gruppi");

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
define('_MI_PICAL_GLOBAL_NOTIFY', 'Globale');
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'Opzioni globali di notifica piCal.');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Categoria');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'Opzioni di nofica per la categoria corrente.');
define('_MI_PICAL_EVENT_NOTIFY', 'Eventi');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'Opzioni di notifica per l\'evento corrente.');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'Nuovo evento');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Notifica quando un nuovo evento viene creato.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Ricevi notifica quando un nuovo evento viene creato.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notifica : Nuovo evento');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'Nuovo Evento nella Categoria');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'Notifica quando un nuovo evento creato nella Categoria.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'Ricevi notifica quando un nuovo evento creato nella Categoria.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notifica : Nuovo Evento in {CATEGORY_TITLE}');

}

?>
