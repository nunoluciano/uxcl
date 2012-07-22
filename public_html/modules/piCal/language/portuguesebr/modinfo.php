<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {







// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:41
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:20
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:04:01
define('_MI_TIMEZONE_USING','Timezone of the server');
define('_MI_OPT_TZ_USEXOOPS','value of XOOPS config');
define('_MI_OPT_TZ_USEWINTER','value told from the server as winter time (recommended)');
define('_MI_OPT_TZ_USESUMMER','value told from the server as summer time');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:14
define('_MI_USE24HOUR','24hours system (No means 12hours system)');
define('_MI_PICAL_ADMENU_PLUGINS','Plugins Manager');

// Appended by Xoops Language Checker -GIJOE- in 2005-04-22 12:02:03
define('_MI_PICAL_BNAME_MINICALEX','MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC','Extensible minicalendar with plugin system');

// Appended by Xoops Language Checker -GIJOE- in 2005-01-08 04:36:51
define('_MI_PICAL_DEFAULTLOCALE','brazil');
define('_MI_PICAL_LOCALE','Locale (check files in locales/*.php)');

define( 'PICAL_MI_LOADED' , 1 ) ;
 //* Brazilian Portuguese Translation by Marcelo Yuji Himoro <www.yuji.eu.org> *//
// Module Info

// The name of this module
define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","MÖ≈ulo de calend·”io com agenda.");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","Mini-calend·”io");
define("_MI_PICAL_BNAME_MINICAL_DESC","Mostra um mini-calend·”io em bloco.");
define("_MI_PICAL_BNAME_MONTHCAL","Calend·”io mensal em tamanho completo");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","Mostra um calend·”io mensal em tamanho completo.");
define("_MI_PICAL_BNAME_TODAYS","Eventos de hoje");
define("_MI_PICAL_BNAME_TODAYS_DESC","Mostra eventos de hoje.");
define("_MI_PICAL_BNAME_THEDAYS","Eventos em %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC","Mostra eventos do dia indicado no calend·”io.");
define("_MI_PICAL_BNAME_COMING","PrÖŸimos eventos");
define("_MI_PICAL_BNAME_COMING_DESC","Mostra os prÖŸimos eventos.");
define("_MI_PICAL_BNAME_AFTER","Eventos depois %s");
define("_MI_PICAL_BNAME_AFTER_DESC","Mostra os eventos apÖ‘ o dia indicado no calend·”io.");
define("_MI_PICAL_BNAME_NEW","Eventos recentes"); 
define("_MI_PICAL_BNAME_NEW_DESC","Mostra os eventos mais recentes.");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","Enviar");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "Permissâ∆s gerais dos usu·”ios");
define("_MI_GUESTS_AUTHORITY", "Permissâ∆s dos anáœimos");
define("_MI_DEFAULT_VIEW", "Calend·”io padrÂ–");
define("_MI_MINICAL_TARGET", "O que mostrar quando uma data È clicada no mini-calend·”io?");
define("_MI_COMING_NUMROWS", "NìŒero de eventos mostrados no bloco de eventos seguintes");
define("_MI_SKINFOLDER", "Nome da pasta das skins");
define("_MI_SUNDAYCOLOR", "Cor dos domingos");
define("_MI_WEEKDAYCOLOR", "Cor dos dias da semana");
define("_MI_SATURDAYCOLOR", "Cor dos s·√ados");
define("_MI_HOLIDAYCOLOR", "Cor dos feriados");
define("_MI_TARGETDAYCOLOR", "Cor dos dias com evento");
define("_MI_SUNDAYBGCOLOR", "Cor de fundo dos domingos");
define("_MI_WEEKDAYBGCOLOR", "Cor de fundo dos dias da semana");
define("_MI_SATURDAYBGCOLOR", "Cor de fundo dos s·√ados");
define("_MI_HOLIDAYBGCOLOR", "Cor de fundo dos feriados");
define("_MI_TARGETDAYBGCOLOR", "Cor de fundo dos dias com evento");
define("_MI_CALHEADCOLOR", "Cor do topo do calendario");
define("_MI_CALHEADBGCOLOR", "Cor de fundo do topo do calend·”io");
define("_MI_CALFRAMECSS", "Estilo da borda do calend·”io");
define("_MI_CANOUTPUTICS", "PermissÂ– para geraÓÂo de arquivos ics");
define("_MI_MAXRRULEEXTRACT", "Limite m·Ÿimo dos eventos extra˘≈os da regra de repetiÓÂo. (COUNT)");
define("_MI_WEEKSTARTFROM", "Dia inicial da semana");
define("_MI_WEEKNUMBERING", "Regra de numeraÓÂo para as semanas");
define("_MI_DAYSTARTFROM", "Hora do encerramento de um dia");
define("_MI_NAMEORUNAME" , "Mostrar nome do autor");
define("_MI_DESCNAMEORUNAME" , "Escolha 'Usu·”io' ou 'Nome verdadeiro'." ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Permitir que usu·”ios anáœimos criem eventos?");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "Permissâ∆s de criaÓÂo");
define("_MI_OPT_AUTH_WAIT", "Podem criar (requer aprovaÓÂo)");
define("_MI_OPT_AUTH_POST", "Podem criar");
define("_MI_OPT_AUTH_BYGROUP", "Especifcado nas permissâ∆s dos Grupos");
define("_MI_OPT_MINI_PHPSELF", "Manter configuraÓ˜es atuais");
define("_MI_OPT_MINI_MONTHLY", "Mostrar calend·”io mensal como padrÂ–");
define("_MI_OPT_MINI_WEEKLY", "Mostrar calend·”io semanal como padrÂ–");
define("_MI_OPT_MINI_DAILY", "Mostrar calend·”io di·”io como padrÂ–");
define("_MI_OPT_MINI_LIST", "Lista de eventos");
define("_MI_OPT_CANOUTPUTICS", "Podem gerar");
define("_MI_OPT_CANNOTOUTPUTICS", "NÂ– podem gerar");
define("_MI_OPT_STARTFROMSUN", "Domingo");
define("_MI_OPT_STARTFROMMON", "Segunda");
define("_MI_OPT_WEEKNOEACHMONTH", "Mensal");
define("_MI_OPT_WEEKNOWHOLEYEAR", "Anual");
define("_MI_OPT_USENAME" , "Nome verdadeiro" ) ;
define("_MI_OPT_USEUNAME" , "Usu·”io" ) ;

// Admin Menus
define("_MI_PICAL_ADMENU0","Aprovar eventos");
define("_MI_PICAL_ADMENU1","AdministraÓÂo de eventos");
define("_MI_PICAL_ADMENU_CAT","AdministraÓÂo de categorias");
define("_MI_PICAL_ADMENU_CAT2GROUP","Permissâ∆s globais das categorias");
define("_MI_PICAL_ADMENU2","Permisâ∆s globais dos grupos");
define("_MI_PICAL_ADMENU_TM","ManutenÓÂo das tabelas");
define("_MI_PICAL_ADMENU_ICAL","Importar do iCalendar");
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','AdministraÓÂo de blocos e grupos');

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
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'OpÓ˜es globais de aviso do piCal.');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Categoria');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'OpÓ˜es de aviso que se aplicam para a categoria atual.');
define('_MI_PICAL_EVENT_NOTIFY', 'Evento');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'OpÓ˜es de aviso que se aplicam para o evento atual.');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'Novo evento');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Avisar-me quando um novo evento for criado.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Receber uma viso quando um novo evento for criado.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso autom·’ico: Novo evento');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'Novo evento na categoria');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'Avisar-me quando um novo evento for criado na categoria atual.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'Receber uma aviso quando um novo evento for criado na categoria atual.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso autom·’ico: Novo evento em {CATEGORY_TITLE}');


}

?>
