<?php
//Traducci�n al espa�ol para ImpressCMS por debianus
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","Foros");

// A brief description of this module
define($constpref."_DESC","M�dulo de foros para ImpressCMS");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME_LIST_TOPICS","Temas");
define($constpref."_BDESC_LIST_TOPICS","Este bloque puede ser usado para muchos prop�sitos. Por supuesto puede ser puesto en la web en m�s de un lugar.");//This block can be used for multi-purpose. Of course, you can put it multiplly
define($constpref."_BNAME_LIST_POSTS","Mensajes");
define($constpref."_BNAME_LIST_FORUMS","Foros");

// admin menu
define($constpref.'_ADMENU_CATEGORYACCESS','Permisos de las categor�as');
define($constpref.'_ADMENU_FORUMACCESS','Permisos de los foros');
define($constpref.'_ADMENU_ADVANCEDADMIN','Avanzado');
define($constpref.'_ADMENU_POSTHISTORIES','Historial');
define($constpref.'_ADMENU_MYLANGADMIN','Idiomas');
define($constpref.'_ADMENU_MYTPLSADMIN','Plantillas');
define($constpref.'_ADMENU_MYBLOCKSADMIN','Bloques/Permisos');
define($constpref.'_ADMENU_MYPREFERENCES','Preferencias');

// configurations
define($constpref.'_TOP_MESSAGE','Mensaje en la cabecera de los foros');
define($constpref.'_TOP_MESSAGEDEFAULT','<h1 class="d3f_title">Forod</h1><p class="d3f_welcome"><Para comenzar a leer los mensajes seleccione la categor�a y el foro que desee visitar en la caja de selecci�n de abajo.</p>');
define($constpref.'_SHOW_BREADCRUMBS','Mostrar "breadcrumbs"');
define($constpref.'_DEFAULT_OPTIONS','Opciones predeterminadas en el formulario de env�o de mensajes');
define($constpref.'_DEFAULT_OPTIONSDSC','Escriba las opciones separadas por una coma(,).<br />eg) smiley,xcode,br,number_entity<br />Puede a�adir estas opciones: special_entity html attachsig u2t_marked');
define($constpref.'_ALLOW_HTML','Permitir HTML');
define($constpref.'_ALLOW_HTMLDSC','Tenga cuidado con esta opci�n: activarla causa una vulnerabilidad por la posible inserci�n de scripts si un usuario con mala intenci�n puede participar en los foros.');
define($constpref.'_ALLOW_TEXTIMG','Permitir mostrar im�genes externas en el mensaje');
define($constpref.'_ALLOW_TEXTIMGDSC','Si alg�n atacante puede mostrar una im�gen externa usando [img], puede saber la IPs o "User-Agents" de quienes visitan su sitio.');
define($constpref.'_ALLOW_SIG','Permitir firmas');
define($constpref.'_ALLOW_SIGDSC','');
define($constpref.'_ALLOW_SIGIMG','Permitir que se muestren im�genes externas en las firmas');
define($constpref.'_ALLOW_SIGIMGDSC','Si alg�n atacante puede mostrar una im�gen externa usando [img], puede saber la IPs o "User-Agents" de quienes visitan su sitio.');
define($constpref.'_USE_VOTE','Usar la funci�n "Votar"');
define($constpref.'_USE_SOLVED','Usar la funci�n "Solucionado"');
define($constpref.'_ALLOW_MARK','Usar la funci�n "MARKING" (marcar mensajes)');
define($constpref.'_ALLOW_HIDEUID','Permitir a los usuarios registrados enviar mensajes sin su nombre');
define($constpref.'_POSTS_PER_TOPIC','M�ximo de mensajes en un tema');
define($constpref.'_POSTS_PER_TOPICDSC','Un tema que tenga este n�mero de mensajes ser� bloqueado autom�ticamente.');
define($constpref.'_HOT_THRESHOLD','Tema popular');//Hot Topic Threshold
define($constpref.'_HOT_THRESHOLDDSC','N�mero de mensajes necesario para considerar un tema como tal');
define($constpref.'_TOPICS_PER_PAGE','Temas por p�gina en la vista de un foro.');
define($constpref.'_TOPICS_PER_PAGEDSC','');
define($constpref.'_VIEWALLBREAK','Temas por p�gina en la "vista cruzada" de los foros');//Topics per a page in the view crossing
define($constpref.'_VIEWALLBREAKDSC','');
define($constpref.'_SELFEDITLIMIT','Tiempo l�mite para la edici�n por los usuarios (en segundos)');
define($constpref.'_SELFEDITLIMITDSC','Para permitir a los usuarios modificar sus mensajes, establezca un valor alto en segundos. Para no permitir que los usuarios puedan editar sus mensajes, establezca el valor en 0.');
define($constpref.'_SELFDELLIMIT','Tiempo l�mite para la eliminaci�n de mensajes por los usuarios (en segundos)');
define($constpref.'_SELFDELLIMITDSC','Para permitir a los usuarios eliminar sus mensajes, establezca un valor alto en segundos. Para no permitir que los usuarios puedan eliminar sus mensajes, establezca el valor en 0. En ning�n caso los mensajes que se traten de responder ser�n eliminados.');
define($constpref.'_CSS_URI','URL del archivo CSS para este m�dulo');
define($constpref.'_CSS_URIDSC','Se puede fijar la ruta relativa o absoluta. Ruta predeterminada: {mod_url}/index.php?page=main_css');
define($constpref.'_IMAGES_DIR','Directorio para los archivos de imagen');
define($constpref.'_IMAGES_DIRDSC','La ruta relativa deber�a ser establecida en el directorio en el que est� el moulo. Ruta predeterminada :images');
define($constpref.'_BODY_EDITOR','Editor de texto');
define($constpref.'_BODY_EDITORDSC','Un editor WYSIWYG solo podr� ser usado en los foros que permitan el uso de c�digo HTML. El editor dhtml ser� mostrado autom�ticamente en otro caso.');//With foros escaping HTML specialchars, xoopsdhtml will be displayed automatically
define($constpref.'_ANONYMOUS_NAME','Nombre para los usuarios an�nimos');
define($constpref.'_ANONYMOUS_NAMEDSC','Nombre que aparecer� cuando un mensaje sea enviado por un usuario no registrado (si tal cosa est� admitida');
define($constpref.'_ICON_MEANINGS','Significado de los iconos');
define($constpref.'_ICON_MEANINGSDSC','Especifique los que mostrar� "ALTs" para los iconos. Cada texto debe estar separado del siguiente por el s�mbolo(|). El primero corresponde a "mensajeicon0.gif".');
define($constpref.'_ICON_MEANINGSDEF','ninguno|normal|triste|feliz|abajo|arriba|exclamaci�n|interrogaci�n');
define($constpref.'_GUESTVOTE_IVL','Votos de usuarios an�nimos');
define($constpref.'_GUESTVOTE_IVLDSC','Establezca el valor en 0 para no permitir los votos de usuarios an�nimos. El otro n�mero hace referencia al tiempo, en segundos, para permitir un segundo mensaje desde la misma IP.');
define($constpref.'_ANTISPAM_GROUPS','Grupos con respecto a los cuales usar el antispam');
define($constpref.'_ANTISPAM_GROUPSDSC','Normalmente no seleccione ninguno.');//Usually set all blank
define($constpref.'_ANTISPAM_CLASS','"Class name" del antispam');
define($constpref.'_ANTISPAM_CLASSDSC','El valor por defecto es "default". Si desactiva el antispam deje el valor en blanco');//against guests even, set it blank


// Notify Categories
define($constpref.'_NOTCAT_TOPIC', 'Este tema'); 
define($constpref.'_NOTCAT_TOPICDSC', 'Notificaciones sobre el tema seleccionado');
define($constpref.'_NOTCAT_FORUM', 'Este foro'); 
define($constpref.'_NOTCAT_FORUMDSC', 'Notificaciones sobre el foro seleccionado');
define($constpref.'_NOTCAT_CAT', 'Esta categor�a');
define($constpref.'_NOTCAT_CATDSC', 'Notificaciones sobre la categor�a seleccionada');
define($constpref.'_NOTCAT_GLOBAL', 'Este m�dulo');
define($constpref.'_NOTCAT_GLOBALDSC', 'Notificaciones sobre cualquier contenido del m�dulo');

// Each Notifications
define($constpref.'_NOTIFY_TOPIC_NEWPOST', 'Nuevos mensajes en este tema');
define($constpref.'_NOTIFY_TOPIC_NEWPOSTCAP', 'Notificarme cuando haya nuevos mensajes en este tema.');
define($constpref.'_NOTIFY_TOPIC_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{TOPIC_TITLE} Nuvos mensajes en el tema');

define($constpref.'_NOTIFY_FORUM_NEWPOST', 'Nuevos mensajes en este foro');
define($constpref.'_NOTIFY_FORUM_NEWPOSTCAP', 'Notificarme el env�o de nuevos mensajes en este foro.');
define($constpref.'_NOTIFY_FORUM_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} Nuevo mensaje en el foro');

define($constpref.'_NOTIFY_FORUM_NEWTOPIC', 'Nuevo tema en el foro');
define($constpref.'_NOTIFY_FORUM_NEWTOPICCAP', 'Notificarme cuando haya nuevos temas en este foro.');
define($constpref.'_NOTIFY_FORUM_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} Nuevo tema en el foro');

define($constpref.'_NOTIFY_CAT_NEWPOST', 'Nuevo mensaje en la categor�a');
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP', 'Notificarme si hay nuevos mensajes en esta categor�a.');
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} Nuevo mensaje en la categor�a');

define($constpref.'_NOTIFY_CAT_NEWTOPIC', 'Nuevo tema en la categor�a');
define($constpref.'_NOTIFY_CAT_NEWTOPICCAP', 'Notificarme de la existencia de nuevos temas en esta categor�a.');
define($constpref.'_NOTIFY_CAT_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} Nuevo tema en la categor�a');

define($constpref.'_NOTIFY_CAT_NEWFORUM', 'Nuevo foro en la categor�a');
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP', 'Notificarme de la existencia de nuevos foros en esta categor�a.');
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} Nuevo foro en la categor�a');

define($constpref.'_NOTIFY_GLOBAL_NEWPOST', 'Nuevo mensaje en el m�dulo');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP', 'Notificarme los nuevos mensajes en el m�dulo.');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}: Nuevo mensaje');

define($constpref.'_NOTIFY_GLOBAL_NEWTOPIC', 'Nuevo tema en el m�dulo');
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICCAP', 'Notificarme los nuevos temas de este m�dulo.');
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}: Nuevo tema');

define($constpref.'_NOTIFY_GLOBAL_NEWFORUM', 'Nuevo foro en el m�dulo');
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMCAP', 'Notificarme de los nuevos foros que se creen en este m�dulo.');
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}: Nuevo foro');

define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULL', 'Nuevo mensaje (con texto completo)');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLCAP', 'Notificarme el env�o de cualquier nuevo mensaje incluyendo el texto completo del mismo.');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLSBJ', '[{X_SITENAME}] {POST_TITLE}');
define($constpref.'_NOTIFY_GLOBAL_WAITING', 'Nuevo mensaje esperando aprobaci�n');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP', 'Notificarme los nuevos mensajes que se env�en y est�n esperando su aprobaci�n. Solo para administradores.');
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ', '[{X_SITENAME}] {X_MODULE}: Nuevo mensaje esperando aprobaci�n');

}

?>
