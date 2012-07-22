<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:40
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:20
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","Модуль Календаря");

// Default Locale
define("_MI_PICAL_DEFAULTLOCALE","russia");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","МиниКалендар);
define("_MI_PICAL_BNAME_MINICAL_DESC","Показывает блок МиниКалендар);
define("_MI_PICAL_BNAME_MINICALEX","МиниКалендар);
define("_MI_PICAL_BNAME_MINICALEX_DESC","Блок МиниКалендарсистемой плагинов");
define("_MI_PICAL_BNAME_MONTHCAL","Календар);
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Показывает полноразмерный мечный календар);
define("_MI_PICAL_BNAME_TODAYS","Сегодняшние события");
define("_MI_PICAL_BNAME_TODAYS_DESC","Показывает сегодняшние события");
define("_MI_PICAL_BNAME_THEDAYS","События на %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Показывает события указанного дня");
define("_MI_PICAL_BNAME_COMING","Ближайшисобытия");
define("_MI_PICAL_BNAME_COMING_DESC","Показывает наступающисобытия");
define("_MI_PICAL_BNAME_AFTER","События посл%s");
define("_MI_PICAL_BNAME_AFTER_DESC","Показывает события послуказанного дня");
define("_MI_PICAL_BNAME_NEW","Новысобытия");
define("_MI_PICAL_BNAME_NEW_DESC","Показывает события подксоздан (новыраньше)");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","Добавить");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Правпользовате");
define("_MI_GUESTS_AUTHORITY", "Правгостя");
define("_MI_DEFAULT_VIEW", "Випо умолчаницентре");
define("_MI_MINICAL_TARGET", "Випо умолчанипо ссылке из МиниКалендаря");
define("_MI_COMING_NUMROWS", "Количество событиблокближайшисобыти);
define("_MI_SKINFOLDER", "Скин (имя директории images)");
define("_MI_PICAL_LOCALE", "Локаль (проверьтфайлlocales/*.php)");
define("_MI_SUNDAYCOLOR", "Цвет воскресенья");
define("_MI_WEEKDAYCOLOR", "Цвет дня недели");
define("_MI_SATURDAYCOLOR", "Цвет суббот);
define("_MI_HOLIDAYCOLOR", "Цвет праздник);
define("_MI_TARGETDAYCOLOR", "Цвет выбранного дня");
define("_MI_SUNDAYBGCOLOR", "Фовоскресенья");
define("_MI_WEEKDAYBGCOLOR", "Фодня недели");
define("_MI_SATURDAYBGCOLOR", "Фосуббот);
define("_MI_HOLIDAYBGCOLOR", "Фопраздник);
define("_MI_TARGETDAYBGCOLOR", "Фовыбранного дня");
define("_MI_CALHEADCOLOR", "Цвет заголовккалендаря");
define("_MI_CALHEADBGCOLOR", "Фозаголовккалендаря");
define("_MI_CALFRAMECSS", "Стилрамккалендаря");
define("_MI_CANOUTPUTICS", "Экспорics-файл);
define("_MI_MAXRRULEEXTRACT", "Максимальное ково событи создаваемыпо правилповтор);
define("_MI_WEEKSTARTFROM", "День начала недели");
define("_MI_WEEKNUMBERING", "Правилнумерацинедель");
define("_MI_DAYSTARTFROM", "Границдля разделен дней");
define("_MI_TIMEZONE_USING", "Часовопоясервер);
define("_MI_USE24HOUR", "24 часовая систем(Не- 12 часовая систем");
define("_MI_NAMEORUNAME" , "Отображать имя" ) ;
define("_MI_DESCNAMEORUNAME" , "Выберите, какоимя отображать" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Разрешитсоздаватсобытия гостя);

// Options of each config items
define("_MI_OPT_AUTH_NONE", "Не можесоздаватсобытия");
define("_MI_OPT_AUTH_WAIT", "Можесоздаватсобытия, требуется подтверждени);
define("_MI_OPT_AUTH_POST", "Можесоздаватсобытия, подтверждает автоматическ);
define("_MI_OPT_AUTH_BYGROUP", "Расписанправах для груп);
define("_MI_OPT_MINI_PHPSELF", "Текущая страница");
define("_MI_OPT_MINI_MONTHLY", "Календарпо меца);
define("_MI_OPT_MINI_WEEKLY", "Календарпо неде);
define("_MI_OPT_MINI_DAILY", "Календарпо дня);
define("_MI_OPT_MINI_LIST", "Список событи);
define("_MI_OPT_CANOUTPUTICS", "Да (можнэкспортировать)");
define("_MI_OPT_CANNOTOUTPUTICS", "Не(нель экспортировать)");
define("_MI_OPT_STARTFROMSUN", "Воскресень);
define("_MI_OPT_STARTFROMMON", "Понедельни);
define("_MI_OPT_WEEKNOEACHMONTH", "Недели меца");
define("_MI_OPT_WEEKNOWHOLEYEAR", "Недели года");
define("_MI_OPT_USENAME" , "Настщеимя" ) ;
define("_MI_OPT_USEUNAME" , "Имя пользовате" ) ;
define("_MI_OPT_TZ_USEXOOPS" , "Из конфигурации XOOPS" ) ;
define("_MI_OPT_TZ_USEWINTER" , "Зимнее время, сообщённое сервером (рекомендуется)" ) ;
define("_MI_OPT_TZ_USESUMMER" , "Летнее время, сообщённое сервером" ) ;

// Admin Menus
define("_MI_PICAL_ADMENU0","Подтвержденисобыти);
define("_MI_PICAL_ADMENU1","Менеджер событи);
define("_MI_PICAL_ADMENU_CAT","Категори);
define("_MI_PICAL_ADMENU_CAT2GROUP","Правкатегори);
define("_MI_PICAL_ADMENU2","Правгруп);
define("_MI_PICAL_ADMENU_TM","Поддержктаблиц");
define("_MI_PICAL_ADMENU_PLUGINS","Плагин);
define("_MI_PICAL_ADMENU_ICAL","Импорт");
define("_MI_PICAL_ADMENU_MYBLOCKSADMIN","Блок);

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
define('_MI_PICAL_GLOBAL_NOTIFY', 'Глобальные');
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'Глобальные настройкоповещений piCal.');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Категория');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'Настройкоповещений для текущекатегори');
define('_MI_PICAL_EVENT_NOTIFY', 'Событи);
define('_MI_PICAL_EVENT_NOTIFYDSC', 'Настройкоповещен для текущего события.');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'Новособыти);
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Оповестить ме прсоздании нового события.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Оповестить ме создании нового события, включиописание события.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} авто-оповещение : Новособыти);

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'Новособытикатегори);
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'Оповестить ме создании нового события категори');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'Оповестить ме создании нового события категори включиописание события.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} авто-оповещение : Новособытикатегори{CATEGORY_TITLE}');



}

?>