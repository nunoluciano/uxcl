<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {







// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:40
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:20
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:03:58
define('_MI_TIMEZONE_USING','Timezone del servidor');
define('_MI_OPT_TZ_USEXOOPS','valor de la configuraci…Ï de XOOPS');
define('_MI_OPT_TZ_USEWINTER','valor indicado por el servidor para el horario de invierno (recomendado)');
define('_MI_OPT_TZ_USESUMMER','valor indicado por el servidor para el horario de verano');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:11
define('_MI_USE24HOUR','Sistema 24h (no existe formato 12h)');
define('_MI_PICAL_ADMENU_PLUGINS','Configuraci…Ï de Plugins');

// Appended by Xoops Language Checker -GIJOE- in 2005-04-22 12:02:00
define('_MI_PICAL_BNAME_MINICALEX','MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC','miniCalendario Extensible con sistema de plugins');

// Appended by Xoops Language Checker -GIJOE- in 2005-01-08 04:36:48
define('_MI_PICAL_DEFAULTLOCALE','');
define('_MI_PICAL_LOCALE','Local (comprobaci…Ï de los archivos locales/*.php)');

define( 'PICAL_MI_LOADED' , 1 ) ;

// $Id: modinfo.php, v 0.5 2003/11/07 20:00:09$
//%%%%%%	Admin Module Name  piCal 	%%%%%
// Module Info

// The name of this module

// Appended by Xoops Language Checker -GIJOE- in 2004-06-22 18:39:02
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','Blocks&Groups Admin');

define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","M…Åulo de calendario con agenda de eventos");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","Mini Calendario");
define("_MI_PICAL_BNAME_MINICAL_DESC","Muestra un mini calendario en bloque");
define("_MI_PICAL_BNAME_MONTHCAL","calendario mensual");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Muestra un calendario mensual completo");
define("_MI_PICAL_BNAME_TODAYS","Eventos de hoy");
define("_MI_PICAL_BNAME_TODAYS_DESC","Muestra los eventos de hoy");
define("_MI_PICAL_BNAME_THEDAYS","Eventos del %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Muestra los eventos del dùÂ indicado");
define("_MI_PICAL_BNAME_COMING","Pr…Ùimos eventos");
define("_MI_PICAL_BNAME_COMING_DESC","Muestra los pr…Ùimos eventos");
define("_MI_PICAL_BNAME_AFTER","Eventos despuñÔ %s");
define("_MI_PICAL_BNAME_AFTER_DESC","Muestra eventos despuñÔ del dùÂ indicado");

// Names of submenu
// define("_MI_PICAL_SMNAME1","");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Autorizaciones de los usuarios");
define("_MI_GUESTS_AUTHORITY", "Autorizaciones de los visitantes");
define("_MI_MINICAL_TARGET", "Mostrar páÈina en el centro cuando se hace clic en la fecha del minicalendario");
define("_MI_COMING_NUMROWS", "N“Îero de eventos que se muestran el el bloque de pr…Ùimos eventos");
define("_MI_SKINFOLDER", "Nombre del folder de la piel(Skin)");
define("_MI_SUNDAYCOLOR", "Color del Domingo");
define("_MI_WEEKDAYCOLOR", "Color de los dùÂs de la semana");
define("_MI_SATURDAYCOLOR", "Color del SáÃado");
define("_MI_HOLIDAYCOLOR", "Color del dùÂ festivo");
define("_MI_TARGETDAYCOLOR", "Color del dùÂ con evento");
define("_MI_SUNDAYBGCOLOR", "Color de fondo del Domingo");
define("_MI_WEEKDAYBGCOLOR", "Color de fondo de los dùÂs de la semana");
define("_MI_SATURDAYBGCOLOR", "Color de fondo del SáÃado");
define("_MI_HOLIDAYBGCOLOR", "Color de fondo de los dùÂs festivos");
define("_MI_TARGETDAYBGCOLOR", "Color de fondo del dùÂ con evento");
define("_MI_CALHEADCOLOR", "Color del encabezado del calendario");
define("_MI_CALHEADBGCOLOR", "Color de fondo del encabezado del calendario");
define("_MI_CALFRAMECSS", "Estilo de la llama del calendario");
define("_MI_CANOUTPUTICS", "Permisos de hacer archivos ics");
define("_MI_MAXRRULEEXTRACT", "LùÎite superior de los eventos extraùÅos por regla.(CONT)");
define("_MI_WEEKSTARTFROM", "DùÂ que comienza de la semana");

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Permiso de agregar eventos a los visitantes");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "no pueden agregar");
define("_MI_OPT_AUTH_WAIT", "no pueden agregar pero necesitan permiso");
define("_MI_OPT_AUTH_POST", "no se pueden agregar sin admisi…Ï");
define("_MI_OPT_AUTH_BYGROUP", "Especificado en los permisos del grupo");
define("_MI_OPT_MINI_PHPSELF", "páÈina actual");
define("_MI_OPT_MINI_MONTHLY", "Calendario mensual");
define("_MI_OPT_MINI_WEEKLY", "Calendario semanal");
define("_MI_OPT_MINI_DAILY", "Calendario por dùÂ");
define("_MI_OPT_CANNOTOUTPUTICS", "puede hacer");
define("_MI_OPT_CANOUTPUTICS", "no puede hacer");
define("_MI_OPT_STARTFROMSUN", "Domingo");
define("_MI_OPT_STARTFROMMON", "Lunes");


// Admin Menus
define("_MI_PICAL_ADMENU0","Admitir eventos");
define("_MI_PICAL_ADMENU1","Importar/Exportar de iCalendar");
define("_MI_PICAL_ADMENU2","Permisos de los grupos");

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

// Appended by Xoops Language Checker -GIJOE- in 2003-12-05 14:18:42
define('_MI_NAMEORUNAME','Nombre del cartel mostrado');
define('_MI_DESCNAMEORUNAME','Seleccionar el \'name\' que sera mostrado');
define('_MI_OPT_USENAME','Usar Nombre');
define('_MI_OPT_USEUNAME','Usar seudonimo');

// Appended by Xoops Language Checker -GIJOE- in 2003-12-26 10:55:15
define('_MI_DAYSTARTFROM','Linea del borde para separar los dùÂs');
define('_MI_PICAL_GLOBAL_NOTIFY','Global');
define('_MI_PICAL_GLOBAL_NOTIFYDSC','Global piCal opciones de notificaci…Ï.');
define('_MI_PICAL_CATEGORY_NOTIFY','Categoria');
define('_MI_PICAL_CATEGORY_NOTIFYDSC','Opciones de Notificaci…Ï que seran aplicadas a esta categorùÂ.');
define('_MI_PICAL_EVENT_NOTIFY','Evento');
define('_MI_PICAL_EVENT_NOTIFYDSC','Opciones de Notificaci…Ï que seran aplicadas a este evento.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY','Nuevo Evento');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP','Notificarme cuando se aÂda un evento.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC','Recibir una notificaci…Ï cuando un envento es aÂdido.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notificaci…Ï : Nuevo evento');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:00
define('_MI_PICAL_BNAME_NEW','Nuevos eventos publicados');
define('_MI_PICAL_BNAME_NEW_DESC','Mostrar los eventos en orden el nuevo es el primero');
define('_MI_PICAL_SM_SUBMIT','Aprobar');
define('_MI_DEFAULT_VIEW','Vista predefinida en el centro');
define('_MI_WEEKNUMBERING','N“Îero de divisiones por semanas');
define('_MI_OPT_MINI_LIST','lista de eventos');
define('_MI_OPT_WEEKNOEACHMONTH','por cada mes');
define('_MI_OPT_WEEKNOWHOLEYEAR','por aÐs');
define('_MI_PICAL_ADMENU_CAT','Editor de Categorias');
define('_MI_PICAL_ADMENU_CAT2GROUP','Categoria\s Permisos');
define('_MI_PICAL_ADMENU_TM','Mantenimiento de Tablas');
define('_MI_PICAL_ADMENU_ICAL','Importar desde iCalendar');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY','Nuevo evento en esta categoria');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP','Notificarme cuando un nuevo evento se cree en esta categoria.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC','Recibir una notificaci…Ï cuando un evento haya sido creado en esta categorùÂ.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notificar : Nuevo evento');

}

?>
