<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:41
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-04-06 04:57:58
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define("_MI_PICAL_NAME"              ,"piCal");

// A brief description of this module
define("_MI_PICAL_DESC"              ,"Kalendarz z harmonogramem");

// Default Locale
define("_MI_PICAL_DEFAULTLOCALE"     ,"Poland");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL"            , "MiniCalendarz");
define("_MI_PICAL_BNAME_MINICAL_DESC"       , "Wyswietl blok MiniCalendarza");
define("_MI_PICAL_BNAME_MINICALEX"          , "MiniCalendarEx");
define("_MI_PICAL_BNAME_MINICALEX_DESC"     , "Extensible minicalendar z pluginem systemu");
define("_MI_PICAL_BNAME_MONTHCAL"           , "Miesizny kalendarz");
define("_MI_PICAL_BNAME_MONTHCAL_DESC"      , "Wyietl pey widkok Miesiznego kalendarza");
define("_MI_PICAL_BNAME_TODAYS"             , "Dzisiejsze wydarzenia");
define("_MI_PICAL_BNAME_TODAYS_DESC"        , "Wyietl wydarzenia na dzi);
define("_MI_PICAL_BNAME_THEDAYS"            , "Wydarzenia w %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC"       , "Wyietl wydarzenia dla wskazanego dnia");
define("_MI_PICAL_BNAME_COMING"             , "Nadchodze wydarzenia");
define("_MI_PICAL_BNAME_COMING_DESC"        , "Wyietl nadchodze wydarzenia");
define("_MI_PICAL_BNAME_AFTER"              , "Wydarzenia po %s");
define("_MI_PICAL_BNAME_AFTER_DESC"         , "Wyietl wydarzenia po wksazanym dniu");
define("_MI_PICAL_BNAME_NEW"                , "Nowe wydarzenia");
define("_MI_PICAL_BNAME_NEW_DESC"           , "Nowe wydarzenia bwyj nistarsze");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT"                ,"Dodaj");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY"                , "Prawa utkownik");
define("_MI_GUESTS_AUTHORITY"               , "Prawa goi");
define("_MI_DEFAULT_VIEW"                   , "Domyny widok na odku");
define("_MI_MINICAL_TARGET"                 , "Docelowy widok z MiniCalendarza");
define("_MI_COMING_NUMROWS"                 , "Liczba wydarzew bloku Nadchodzych Wydarze);
define("_MI_SKINFOLDER"                     , "Nazwa folderu ze skk);
define("_MI_PICAL_LOCALE"                   , "Lokacja (sprawdpliki w locales/*.php)");
define("_MI_SUNDAYCOLOR"                    , "Kolor niedziel");
define("_MI_WEEKDAYCOLOR"                   , "Kolor zwykgo dnia");
define("_MI_SATURDAYCOLOR"                  , "Kolor soboty");
define("_MI_HOLIDAYCOLOR"                   , "Kolor wakacji");
define("_MI_TARGETDAYCOLOR"                 , "Kolor wybranego dnia");
define("_MI_SUNDAYBGCOLOR"                  , "T niedzieli");
define("_MI_WEEKDAYBGCOLOR"                 , "T zwykgo dnia");
define("_MI_SATURDAYBGCOLOR"                , "T soboty");
define("_MI_HOLIDAYBGCOLOR"                 , "T wakacji");
define("_MI_TARGETDAYBGCOLOR"               , "T wybranego dnia");
define("_MI_CALHEADCOLOR"                   , "Kolor nag³ówka");
define("_MI_CALHEADBGCOLOR"                 , "T nag³ówka");
define("_MI_CALFRAMECSS"                    , "Styl ramki kalendarza");
define("_MI_CANOUTPUTICS"                   , "Permission of outputting ics files");
define("_MI_MAXRRULEEXTRACT"                , "Upper limit of events extracted by Rrule.(COUNT)");
define("_MI_WEEKSTARTFROM"                  , "Dziezaczyncy tydzie);
define("_MI_WEEKNUMBERING"                  , "Numbering rule for weeks");
define("_MI_DAYSTARTFROM"                   , "Linia graniczna pomizy dniami");
define("_MI_TIMEZONE_USING"                 , "Strefa czasowa serwera");
define("_MI_USE24HOUR"                      , "24-godzinny system (Lub 12-godzinny)");
define("_MI_NAMEORUNAME"                    , "Wyietlanick autora wydarzenia" ) ;
define("_MI_DESCNAMEORUNAME"                , "Wybierz jeli 'imi jest pokazywane" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC"                 , "Uprawnienia dodawanie wydarzeprzez goi");

// Options of each config items
define("_MI_OPT_AUTH_NONE"                  , "nie mo dodawa);
define("_MI_OPT_AUTH_WAIT"                  , "mo ale musi to zaakceptowaadministrator");
define("_MI_OPT_AUTH_POST"                  , "mo dodawabez akceptacji administratora");
define("_MI_OPT_AUTH_BYGROUP"               , "Ustawienia grup");
define("_MI_OPT_MINI_PHPSELF"               , "Obecna strona");
define("_MI_OPT_MINI_MONTHLY"               , "Miesizny kalendarz");
define("_MI_OPT_MINI_WEEKLY"                , "Tygodniowy kalendarz");
define("_MI_OPT_MINI_DAILY"                 , "Dzienny kalendarz");
define("_MI_OPT_MINI_LIST"                  , "Lista wydarze);
define("_MI_OPT_CANOUTPUTICS"               , "mo przetworzy);
define("_MI_OPT_CANNOTOUTPUTICS"            , "nie mo przetworzy);
define("_MI_OPT_STARTFROMSUN"               , "Niedziela");
define("_MI_OPT_STARTFROMMON"               , "Poniedziak");
define("_MI_OPT_WEEKNOEACHMONTH"            , "przez kay miesi");
define("_MI_OPT_WEEKNOWHOLEYEAR"            , "przez carok");
define("_MI_OPT_USENAME"                    , "Prawdziwe imi ) ;
define("_MI_OPT_USEUNAME"                   , "Login" ) ;
define("_MI_OPT_TZ_USEXOOPS"                , "Ustawienia Xoopsa" ) ;
define("_MI_OPT_TZ_USEWINTER"               , "warto¶æ z serwera jako czas zimowy (zalecane)" ) ;
define("_MI_OPT_TZ_USESUMMER"               , "warto¶æ z serwera jako czas letni" ) ;

// Admin Menus
define("_MI_PICAL_ADMENU0"                  , "Wydarzenia do akceptacji");
define("_MI_PICAL_ADMENU1"                  , "Zarzzanie wydarzeniami");
define("_MI_PICAL_ADMENU_CAT"               , "Zarzzanie kategoriami");
define("_MI_PICAL_ADMENU_CAT2GROUP"         , "Uprawnienia dostu do kategorii");
define("_MI_PICAL_ADMENU2"                  , "Globalne uprawnienia dostu");
define("_MI_PICAL_ADMENU_TM"                , "Tabela");
define("_MI_PICAL_ADMENU_PLUGINS"           , "Zarzzanie pluginami");
define("_MI_PICAL_ADMENU_ICAL"              , "Import z iCalendar");
define("_MI_PICAL_ADMENU_MYBLOCKSADMIN"     , "Bloki i grupy");

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
define('_MI_PICAL_GLOBAL_NOTIFY'            , 'Ogne');
define('_MI_PICAL_GLOBAL_NOTIFYDSC'         , 'Opcje powiadomie');
define('_MI_PICAL_CATEGORY_NOTIFY'          , 'Kategorie');
define('_MI_PICAL_CATEGORY_NOTIFYDSC'       , 'Opcje powiadomie kte odnoszsido aktualnej kategorii.');
define('_MI_PICAL_EVENT_NOTIFY'             , 'Wydarzenie');
define('_MI_PICAL_EVENT_NOTIFYDSC'          , 'Opcje powiadomie kte odnoszsido aktualnego wydarzenia.');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY'       , 'Nowe wydarzenie');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP'    , 'Powiadom mnie kiedy zostanie utworzone nowe wydarzenie.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC'    , 'Powiadom mnie kiedy zostanie utworzone nowe wydarzenie (+opis wydarzenia).');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ'    , '[{X_SITENAME}] {X_MODULE} auto-notify : Nowe wydarzenie');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY'     , 'Nowe wydarzenie w kategorii');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP'  , 'Powiadom mnie kiedy zostanie utworzone nowe wydarzenie w kategorii.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC'  , 'Powiadom mnie kiedy zostanie utworzone nowe wydarzenie w kategorii (+opis).');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ'  , '[{X_SITENAME}] {X_MODULE} auto-notify : Nowe wydarzenie w {CATEGORY_TITLE}');



}

?>