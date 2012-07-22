<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {






// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:48
define('_AM_PICAL_DBUPDATED','Database Updated Successfully!');
define('_AM_PICAL_PERMADDNG','Could not add %s permission to %s for group %s');
define('_AM_PICAL_PERMADDOK','Added %s permission to %s for group %s');
define('_AM_PICAL_PERMRESETNG','Could not reset group permission for module %s');
define('_AM_PICAL_PERMADDNGP','All parent items must be selected.');

// Appended by Xoops Language Checker -GIJOE- in 2005-06-29 17:19:31
define('_AM_PI_TH_OPTIONS','Options (usually blank)');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-24 19:05:04
define('_AM_TZOPT_SERVER','As server timezone');
define('_AM_TZOPT_GMT','As GMT');
define('_AM_TZOPT_USER','As user\'s timezone');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:03:58
define('_AM_FMT_SERVER_TZ_ALL','Timezone of the server (winter): %+2.1f<br />Timezone of the server (summer): %+2.1f<br />Zonename of the server: %s<br />The value of XOOPS config: %+2.1f<br />The value of piCal using: %+2.1f<br />');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:11
define('_AM_FMT_SERVER_TZ_SYSTEM','Timezone en invierno: %+2.1f');
define('_AM_TH_SERVER_TZ_COUNT','Eventos');
define('_AM_TH_SERVER_TZ_VALUE','Timezone');
define('_AM_TH_SERVER_TZ_VALUE_TO','Cambios (-14.0¡Á14.0)');
define('_AM_JSALRT_SERVER_TZ','Don\'t forget backing-up events table before this operation');
define('_AM_NOTICE_SERVER_TZ','If your server set the timezone area with summer time (=Day Light Saving) and some events were registerd in piCal 0.6x or 0.7x, dont\'t push this button.<br />eg) It is natural to display both -5.0 and -4.0 in EDT');
define('_AM_MB_SUCCESSTZUPDATE','Events are modified with the timezone(s).');
define('_AM_PI_UPDATED','Plugins are updated');
define('_AM_PI_TH_TYPE','Tipo');
define('_AM_PI_TH_TITLE','Título');
define('_AM_PI_TH_DIRNAME','Modulo\'s nombredirectorio');
define('_AM_PI_TH_FILE','Plugin archivo');
define('_AM_PI_TH_DOTGIF','Punto GIF');
define('_AM_PI_TH_OPERATION','Operación');
define('_AM_PI_ENABLED','Activo');
define('_AM_PI_DELETE','Eliminar');
define('_AM_PI_NEW','Nuevo');
define('_AM_PI_VIEWYEARLY','Vista Anual');
define('_AM_PI_VIEWMONTHLY','Vista Mensual');
define('_AM_PI_VIEWWEEKLY','Vista semanal');
define('_AM_PI_VIEWDAILY','Vista diaria');

define( 'PICAL_AM_LOADED' , 1 ) ;

// $Id: admin.php, v 0.5 2003/11/07 20:00:09$
//%%%%%%	Admin Module Name  piCal 	%%%%%
// titles

// Appended by Xoops Language Checker -GIJOE- in 2004-06-22 18:39:02
define('_AM_OPT_PAST','Pasados');
define('_AM_OPT_FUTURE','Futuros');
define('_AM_OPT_PASTANDFUTURE','Pasados&Futuros');

define("_AM_CONFIG","Configuración del menú de piCal");
define("_AM_GENERALCONF","Configuración general de piCal");
define("_AM_ADMISSION","Admitir eventos");
define("_AM_ICALENDAR_IO","Importar/Exportar de iCalendar");
define("_AM_ICALENDAR_IMPORT","Importar iCalendar");
define("_AM_ICALENDAR_EXPORT","Exportar iCalendar");
define("_AM_GROUPPERM","Permisos a grupos");

// forms
define("_AM_BUTTON_EXTRACT","Extraer");
define("_AM_BUTTON_ADMIT","Admitir");
define("_AM_CONFIRM_DELETE","Eliminar, ¿OK?");

// admission
define("_AM_LABEL_ADMIT","Los eventos comprobados están: esperando admisión");
define("_AM_MES_ADMITTED","Evento(s) ha sido admitido");
define("_AM_ADMIT_TH0","Usuario");
define("_AM_ADMIT_TH1","Hora y fecha de inicio");
define("_AM_ADMIT_TH2","Hora y fecha de fin");
define("_AM_ADMIT_TH3","Título");
define("_AM_ADMIT_TH4","Regla");

// iCalendar I/O

define("_AM_LABEL_IMPORTFROMWEB","Importar datos de iCalendar desde la web (escribe la URL iniciando con 'http://' o 'webcal://')");
define("_AM_LABEL_UPLOADFROMFILE","Subir datos de iCalendar (Selecciona un archivo de tus PC)");
define("_AM_BUTTON_IMPORT","Importar!");
define("_AM_BUTTON_UPLOAD","Subir!");
define("_AM_LABEL_IO_CHECKEDITEMS","Eventos comprobados son:");
define("_AM_LABEL_IO_OUTPUT","ser exportado a iCalendar");
define("_AM_LABEL_IO_SELECTPLATFORM","Selecciona plataforma");
define("_AM_LABEL_IO_DELETE","eliminar");
define("_AM_MES_DELETED","Evento(s) ha sido eliminado");
define("_AM_IO_TH0","Usuario");
define("_AM_IO_TH1","Hora y fecha de inicio");
define("_AM_IO_TH2","Hora y fecha de fin");
define("_AM_IO_TH3","Título");
define("_AM_IO_TH4","Regla");
define("_AM_IO_TH5","Admisión");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "Pueden agregar" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "Pueden super agregar" ) ;
define( '_AM_GPERM_G_EDITABLE' , "Pueden editar" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "Pueden super editar" ) ;
define( '_AM_GPERM_G_DELETABLE' , "Pueden Eliminar" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "Pueden super eliminar" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "Pueden tocar otros" ) ;
define( '_AM_GROUPPERMDESC' , "Seleccione los permisos que permiten cada grupo que hagan <br />si usted necesita esta característica, fije ' permisos de los usuarios especificando en los permisos del grupo al principio.<br /> Los ajustes de dos grupos del administrador y de la visitante anónimo serán no hechos caso." ) ;




// Appended by Xoops Language Checker -GIJOE- in 2003-11-14 16:47:57
define('_AM_DTFMT_LIST_ALLDAY','d-m-y');
define('_AM_DTFMT_LIST_NORMAL','d-m-y<\b\r />H:i');

// Appended by Xoops Language Checker -GIJOE- in 2003-12-05 14:18:42
define('_AM_MYBLOCKSADMIN','piCal\'s Administrador de Bloque&Grupos');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:00
define('_AM_MENU_EVENTS','Editor de Eventos');
define('_AM_MENU_CATEGORIES','Editor de Categorias');
define('_AM_MENU_CAT2GROUP','Permisos Categoria\s');
define('_AM_TABLEMAINTAIN','Mantenimiento Tablas (actualización)');
define('_AM_BUTTON_MOVE','Mover');
define('_AM_BUTTON_COPY','Copiar');
define('_AM_CONFIRM_MOVE','Eliminar un enlace a una categoria y añadir un enlace a la categoria especificada, Acepta?');
define('_AM_CONFIRM_COPY','Añadir un enlace a la categoría especificada?');
define('_AM_BUTTON_EXPORT','Exportar!');
define('_AM_MES_EVENTLINKTOCAT','evento(s) enlazados con esta categoría');
define('_AM_MES_EVENTUNLINKED','evento(s) cuyos enlaces van a ser eliminados en la categoría anterior');
define('_AM_FMT_IMPORTED','evento(s) que van a ser importados de \'%s\'');
define('_AM_CAT2GROUPDESC','Compruebe las categorías a las que usted tiene acceso');
define('_AM_MB_SUCCESSUPDATETABLE','La actualización de tabla(s) a concluido');
define('_AM_MB_FAILUPDATETABLE','La actualización de tabla(s) a fallado');
define('_AM_NOTICE_NOERRORS','No existe ningún error con las tablas o los registros.');
define('_AM_ALRT_CATTABLENOTEXIST','La tabla de categorias no existe.<br />
Usted quiere crear la tabla ?');
define('_AM_ALRT_OLDTABLE','La estructua de la tabla de eventos es antigua.<br />
Usted quiere actualizar la tabla?');
define('_AM_ALRT_TOOOLDTABLE','Ha ocurrido un error al actualizar la tabla.<br />
Probablemente este utilizado el calendario 0.3x o anterior.<br />
primero, debe actualizarse a 0.4x o 0.5x.');
define('_AM_FMT_WRONGSTZ','There are %s event(s) which is recorded with wrong timezone.<br />Do you repair them ?');
define('_AM_CAT_TH_TITLE','Título');
define('_AM_CAT_TH_DESC','Descripción');
define('_AM_CAT_TH_PARENT','Categoria vinculada');
define('_AM_CAT_TH_OPTIONS','Opciones');
define('_AM_CAT_TH_LASTMODIFY','Ultima modificación');
define('_AM_CAT_TH_OPERATION','Operación');
define('_AM_CAT_TH_ENABLED','Activar');
define('_AM_CAT_TH_WEIGHT','Ancho');
define('_AM_CAT_TH_SUBMENU','registra un SubMenu');
define('_AM_BTN_UPDATE','ACTUALIZAR');
define('_AM_MENU_CAT_EDIT','Editar una Categoria');
define('_AM_MENU_CAT_NEW','Crear una nueva Categoria');
define('_AM_MB_MAKESUBCAT','SubCategoria');
define('_AM_MB_MAKETOPCAT','Crear una categoria en el nivel superior');
define('_AM_MB_CAT_INSERTED','Nueva Categoria creada');
define('_AM_MB_CAT_UPDATED','Categoria actualizada');
define('_AM_FMT_CAT_DELETED','%s Categorias eliminadas');
define('_AM_FMT_CAT_BATCHUPDATED','%s Categories actualizadas');
define('_AM_FMT_CATDELCONFIRM','Usted quiere eliminar la categoria %s ?');

}

?>