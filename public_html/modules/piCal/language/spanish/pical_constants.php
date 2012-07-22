<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2005-05-17 17:33:59
define('_PICAL_BTN_DELETE_ONE','Remove just one');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:12
define('_PICAL_JS_CALENDAR','calendar-en.js');
define('_PICAL_JSFMT_YMDN','%d %B %Y (%A)');
define('_PICAL_DTFMT_MINUTE','i');
define('_PICAL_FMT_YMDN','%3$s %2$s %1$s %4$s');
define('_PICAL_FMT_DHI','%1$s %2$s:%3$s');
define('_PICAL_FMT_HI','%1$s:%2$s');
define('_PICAL_TH_TIMEZONE','Time Zone');

define( 'PICAL_CNST_LOADED' , 1 ) ;

// $Id: pical_constants.php, v 0.5 2003/11/07 20:00:09$
//%%%%%%	Admin Module Name  piCal 	%%%%%

define('_PICAL_DTFMT_TIME','a g:i') ;
// define('_PICAL_DTFMT_DATE','jS M Y (D)') ;
// define('_PICAL_DTFMT_MD','jS M') ;

define('_PICAL_LOCALE','es_MX') ;
define('_PICAL_STRFFMT_DATE','%x') ;

define('_PICAL_FMT_MD','%2$s %1$s') ;
define('_PICAL_FMT_YMD','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YMW','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YEAR_MONTH','%2$s %1$s') ;
define('_PICAL_FMT_YEAR','<font size="-1">Aé—O </font>%s') ;

define('_PICAL_ICON_DAILY','Vista por d˘¬') ;
define('_PICAL_ICON_WEEKLY','Vista semanal') ;
define('_PICAL_ICON_MONTHLY','Vista mensual') ;
define('_PICAL_ICON_YEARLY','Vista anual') ;

define('_PICAL_MB_LINKTODAY','Hoy') ;
define('_PICAL_MB_NOSUBJECT','(Sin asunto)') ;

define('_PICAL_MB_PREV_DATE','MaÅ¬na') ;
define('_PICAL_MB_NEXT_DATE','Ayer') ;
define('_PICAL_MB_PREV_WEEK','Semana Pasada') ;
define('_PICAL_MB_NEXT_WEEK','Siguiente Semana') ;
define('_PICAL_MB_PREV_MONTH','Mes Pasado') ;
define('_PICAL_MB_NEXT_MONTH','Siguiente Mes') ;
define('_PICAL_MB_PREV_YEAR','AÅ– Pasado') ;
define('_PICAL_MB_NEXT_YEAR','Siguiente AÅ–') ;

define('_PICAL_MB_NOEVENT','No hay eventos') ;
define('_PICAL_MB_ADDEVENT','Agregar un evento') ;
define('_PICAL_MB_CONTINUING','(continua)') ;
define('_PICAL_MB_RESTEVENT_PRE','m·‘') ;
define('_PICAL_MB_RESTEVENT_SUF','elemento(s)') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','Evento de todo el d˘¬') ;
define('_PICAL_MB_LONG_EVENT','Mostrar como barra') ;
define('_PICAL_MB_LONG_SPECIALDAY','Aniversario etc.') ;

define('_PICAL_MB_PUBLIC','Publico') ;
define('_PICAL_MB_PRIVATE','Privado') ;
define('_PICAL_MB_PRIVATETARGET',' entre %s') ;

define('_PICAL_MB_LINK_TO_RRULE1ST','Salta al primer evento ') ;
define('_PICAL_MB_RRULE1ST','Este es el primer evento') ;

define('_PICAL_MB_EVENT_NOTREGISTER','No Registrado') ;
define('_PICAL_MB_EVENT_ADMITTED','Admitido') ;
define('_PICAL_MB_EVENT_NEEDADMIT','Esperando admisiÖœ') ;

define('_PICAL_MB_TITLE_EVENTINFO','Agenda') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','Vista detallada') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','Vista de ediciÖœ') ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_TH_SUMMARY','Resumen') ;
define('_PICAL_TH_STARTDATETIME','Hora y fecha de inicio') ;
define('_PICAL_TH_ENDDATETIME','Hora y fecha de fin') ;
define('_PICAL_TH_ALLDAYOPTIONS','OpciÖœ de todo el d˘¬') ;
define('_PICAL_TH_LOCATION','LocalizaciÖœ') ;
define('_PICAL_TH_CONTACT','Contacto') ;
define('_PICAL_TH_CLASS','Clase') ;
define('_PICAL_TH_DESCRIPTION','DescripciÖœ') ;
define('_PICAL_TH_RRULE','Se repiten las reglas') ;
define('_PICAL_TH_ADMISSIONSTATUS','Estado') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','(NìŒero de entradas)') ;
define('_PICAL_NTC_EXTRACTLIMIT','**Se extraen solamente %s acontecimientos como m·Ÿimo') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(%s es el nìŒero de art˘ƒulos que admite)') ;

define('_PICAL_OPT_PRIVATEMYSELF','Solo yo') ;
define('_PICAL_OPT_PRIVATEGROUP','Grupo %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(grupo inv·Õido)') ;

define('_PICAL_CNFM_SAVEAS_YN','Est·‘ seguro de guardar como otra entrada?') ;
define('_PICAL_CNFM_DELETE_YN','Est·‘ seguro de borrar esta entrada?') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Error: ID del evento no encontrada') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"Error: No tienes permiso de ver el calendario") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"Error: No tienes permiso de editar el calendario") ;
define('_PICAL_ERR_LACKINDISPITEM','El art˘ƒulo %s est· vacio.<br />Regresa haciendo click atras en tu navegador') ;

define('_PICAL_BTN_JUMP','Saltar') ;
define('_PICAL_BTN_NEWINSERTED','Nueva Entrada') ;
define('_PICAL_BTN_SUBMITCHANGES',' Actualizar! ') ;
define('_PICAL_BTN_SAVEAS','Guardar como') ;
define('_PICAL_BTN_DELETE','Eliminarlo') ;
define('_PICAL_BTN_EDITEVENT','Editarlo') ;
define('_PICAL_BTN_RESET','Reestablecer') ;
define('_PICAL_BTN_OUTPUTICS_WIN','Calendario(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','Calendario(Mac)') ;

define('_PICAL_RR_EVERYDAY','Cada d˘¬') ;
define('_PICAL_RR_EVERYWEEK','Cada semana') ;
define('_PICAL_RR_EVERYMONTH','Cada mes') ;
define('_PICAL_RR_EVERYYEAR','Cada aÅ–') ;
define('_PICAL_RR_FREQDAILY','Diario') ;
define('_PICAL_RR_FREQWEEKLY','Semanal') ;
define('_PICAL_RR_FREQMONTHLY','Mensual') ;
define('_PICAL_RR_FREQYEARLY','Anual') ;
define('_PICAL_RR_FREQDAILY_PRE','Cada') ;
define('_PICAL_RR_FREQWEEKLY_PRE','Cada') ;
define('_PICAL_RR_FREQMONTHLY_PRE','Cada') ;
define('_PICAL_RR_FREQYEARLY_PRE','Cada') ;
define('_PICAL_RR_FREQDAILY_SUF','d˘¬(s)') ;
define('_PICAL_RR_FREQWEEKLY_SUF','Semana(s)') ;
define('_PICAL_RR_FREQMONTHLY_SUF','Mes(es)') ;
define('_PICAL_RR_FREQYEARLY_SUF','AÅ–(s)') ;
define('_PICAL_RR_PERDAY','every %s d˘¬s') ;
define('_PICAL_RR_PERWEEK','every %s semanas') ;
define('_PICAL_RR_PERMONTH','every %s meses') ;
define('_PICAL_RR_PERYEAR','every %s aÅ–s') ;
define('_PICAL_RR_COUNT','<br />%s veces') ;
define('_PICAL_RR_UNTIL','<br />hasta %s') ;
define('_PICAL_RR_R_NORRULE','Que no se repite') ;
define('_PICAL_RR_R_YESRRULE','Que se repite') ;
define('_PICAL_RR_OR','o') ;
define('_PICAL_RR_S_NOTSELECTED','-no seleccionado-') ;
define('_PICAL_RR_S_SAMEASBDATE','Igual que la fecha entrante') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','Ningunas condiciones de repetir') ;
define('_PICAL_RR_R_USECOUNT_PRE','repetir') ;
define('_PICAL_RR_R_USECOUNT_SUF','veces') ;
define('_PICAL_RR_R_USEUNTIL','hasta') ;


// Appended by Xoops Language Checker -GIJOE- in 2003-12-05 14:18:43
define('_PICAL_TH_SUBMITTER','Aprobar');

// Appended by Xoops Language Checker -GIJOE- in 2003-12-26 10:55:15
define('_PICAL_STRFFMT_DATE_FOR_BLOCK','%d %b');
define('_PICAL_STRFFMT_TIME','%H:%M');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:00
define('_PICAL_FMT_YW','SEMANA%2$s %1$s');
define('_PICAL_FMT_WEEKNO','SEMANA %s');
define('_PICAL_ICON_LIST','Vista Lista');
define('_PICAL_MB_SHOWALLCAT','Todas las Categorias');
define('_PICAL_MB_ORDER_ASC','ascendiente');
define('_PICAL_MB_ORDER_DESC','descendiente');
define('_PICAL_MB_SORTBY','Ordenar por:');
define('_PICAL_MB_CURSORTEDBY','Enventos actualmente ordenados por:');
define('_PICAL_TH_CATEGORIES','Categorias');
define('_PICAL_TH_LASTMODIFIED','Ultima modificaciÖœ');
define('_PICAL_BTN_PRINT','Imprimir');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-17 18:09:07
define('_PICAL_FMT_YMDO','%4$s%3$s%2$s%1$s');
define('_PICAL_MB_LABEL_CHECKEDITEMS','Comprobar eventos:');
define('_PICAL_MB_LABEL_OUTPUTICS','exportar a iCalendar');
define('_PICAL_MB_ICALSELECTPLATFORM','Select plataforma');
define('_PICAL_MB_OP_AFTER','Despues');
define('_PICAL_MB_OP_BEFORE','Antes');
define('_PICAL_MB_OP_ON','En');
define('_PICAL_MB_OP_ALL','Todos');
define('_PICAL_BTN_IMPORT','Importar!');
define('_PICAL_BTN_UPLOAD','Cargar!');
define('_PICAL_BTN_EXPORT','Exportar!');
define('_PICAL_BTN_EXTRACT','Extraer');
define('_PICAL_BTN_ADMIT','Admitir');
define('_PICAL_BTN_MOVE','Mover');
define('_PICAL_BTN_COPY','Copiar');

}

?>