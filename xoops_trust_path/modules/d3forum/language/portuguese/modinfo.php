<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {




// Appended by Xoops Language Checker -GIJOE- in 2007-09-28 15:55:32
define($constpref.'_DEFAULT_OPTIONS','Default checked in post form');
define($constpref.'_DEFAULT_OPTIONSDSC','List checked options separated by comma(,).<br />eg) smiley,xcode,br,number_entity<br />You can add these options: special_entity html attachsig u2t_marked');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-27 16:50:42
define($constpref.'_BODY_EDITOR','Body Editor');
define($constpref.'_BODY_EDITORDSC','WYSIWYG editor will be enabled under only forums allowing HTML. With forums escaping HTML specialchars, xoopsdhtml will be displayed automatically.');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-26 17:55:47
define($constpref.'_ADMENU_POSTHISTORIES','Histories');
define($constpref.'_SHOW_BREADCRUMBS','Display breadcrumbs');
define($constpref.'_ANTISPAM_GROUPS','Groups should be checked anti-SPAM');
define($constpref.'_ANTISPAM_GROUPSDSC','Usually set all blank.');
define($constpref.'_ANTISPAM_CLASS','Class name of anti-SPAM');
define($constpref.'_ANTISPAM_CLASSDSC','Default value is "default". If you disable anti-SPAM against guests even, set it blank');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","Forum");

// A brief description of this module
define($constpref."_DESC","Forum module for XOOPS Cube");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME_LIST_TOPICS","T�picos"); //
define($constpref."_BDESC_LIST_TOPICS","Este bloco pode ser utilizado para v�rias finalidades, e pode ser clonado facilmente.");
define($constpref."_BNAME_LIST_POSTS","Mensagens"); //
define($constpref."_BNAME_LIST_FORUMS","F�runs");  //

define($constpref.'_ADMENU_ADVANCEDADMIN','Avan�ado');            //
define($constpref.'_ADMENU_CATEGORYACCESS','Categorias');  //
define($constpref.'_ADMENU_FORUMACCESS','F�runs');    //
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocos e permiss�es');
define($constpref.'_ADMENU_MYLANGADMIN','Idiomas');
define($constpref.'_ADMENU_MYPREFERENCES','Prefer�ncias');
define($constpref.'_ADMENU_MYTPLSADMIN','Modelos');

// configurations
define($constpref.'_TOP_MESSAGE','Mensagem no inicio do f�rum');  //
define($constpref.'_TOP_MESSAGEDEFAULT','<h1 class="d3f_title">In�cio do Forum</h1><p class="d3f_welcome">Para come�ar a mostrar as mensagens, selecionar uma  categoria ou o f�rum de que voc� queira visitar na sele��o abaixo.</p>');  //
define($constpref.'_ALLOW_HTML','Permitir HTML'); //
define($constpref.'_ALLOW_HTMLDSC','N�o coloque SIM, ocasionalmente. Pois isto pode conter uma vunerabilidade e que um visitante coloque um script malicioso.'); //
define($constpref.'_ALLOW_TEXTIMG','Permitir mostrar as imagens externas na mensagem'); //
define($constpref.'_ALLOW_TEXTIMGDSC','Se alguem afixar uma imagem externa usando [img], ele pode saber quais o IPs ou os visitantes visitaram seu site.'); //
define($constpref.'_ALLOW_SIG','Permitir a assinatura'); //
define($constpref.'_ALLOW_SIGDSC','');
define($constpref.'_ALLOW_SIGIMG','Permitir mostrar imagens externas na assinatura');  //
define($constpref.'_ALLOW_SIGIMGDSC','Se alguem fixar uma imagem externa usando [img], ele pode saber quais o IPs ou os visitantes visitaram seu site.');   //
define($constpref.'_USE_VOTE','Utilizar a op��o de VOTO');
define($constpref.'_USE_SOLVED','Utilizar a op��o de RESOLVIDO');  //
define($constpref.'_ALLOW_MARK','Utilizar a op��o de MARCAR T�PICO');   //
define($constpref.'_ALLOW_HIDEUID','Permitir um usu�rio registrado pode postar sem seu nome'); //
define($constpref.'_POSTS_PER_TOPIC','M�ximo de mensagens por t�pico');  //
define($constpref.'_POSTS_PER_TOPICDSC','O t�pico tem um limite de suas mensagens'); //
define($constpref.'_HOT_THRESHOLD','TOPICO QUENTE');//
define($constpref.'_HOT_THRESHOLDDSC','N�meros de postagens necess�rias para considerar este um t�pico como popular');
define($constpref.'_TOPICS_PER_PAGE','M�ximo de t�picos por p�gina, mostrada no f�rum.'); //
define($constpref.'_TOPICS_PER_PAGEDSC','');
define($constpref.'_VIEWALLBREAK','T�picos por uma p�gina nos f�runs do cruzamento da vista');
define($constpref.'_VIEWALLBREAKDSC','');
define($constpref.'_SELFEDITLIMIT','O limite de tempo para que os visitantes possam editar as postagens (em segundos)'); //
define($constpref.'_SELFEDITLIMITDSC','Permitir que os associados possam editar as suas pr�prias postagens em um per�odo de tempo determinado em segundos. Escreva 0 (zero) para desabilitar esta op��o.');
define($constpref.'_SELFDELLIMIT','Limite de tempo para os visitantes apagarem as mensagens (em segundo)');
define($constpref.'_SELFDELLIMITDSC','N�o permitir de visitantes normais de poder apagar, determinando 0 (zero). Permitir visitantes normais de pode apagar, determinando o valor em segundos.');
define($constpref.'_CSS_URI','Usar URI do arquivo CSS para este m�dulo'); //
define($constpref.'_CSS_URIDSC','o trajeto relativo ou absoluto pode ser ajustado por padr�o: index.css'); //
define($constpref.'_IMAGES_DIR','Diret�rio para arquivos de imagem'); //
define($constpref.'_IMAGES_DIRDSC','o trajeto relativo deve ser ajustado no diret�rio do m�dulo, por padr�o: imagens'); //
define($constpref.'_ANONYMOUS_NAME','Nome para os visitantes an�nimos');
define($constpref.'_ANONYMOUS_NAMEDSC','');
define($constpref.'_ICON_MEANINGS','Significado dos �cones');
define($constpref.'_ICON_MEANINGSDSC','Defini��o de ALTs dos �cones. Cada alts deve ser separado pelo pipe(|). O primeiro alt corresponde "posticon0.gif", dentro do diret�rio /images.');
define($constpref.'_ICON_MEANINGSDEF','nenhum|normal|triste|feliz|progresso|retrocesso|impressionante|d�vida');
define($constpref.'_GUESTVOTE_IVL','Votos an�nimos');//
define($constpref.'_GUESTVOTE_IVLDSC','Colocando 0 (zero), impossibilita dos visitantes votarem. Qualquer outro numero significa o tempo (em segundos) para poderem votar de novo na mensagem, com o mesmo IP.'); //



// Notify Categories
define($constpref.'_NOTCAT_TOPIC', 'Este t�pico');//
define($constpref.'_NOTCAT_TOPICDSC', 'As notifica��es sobre o objetivo do t�pico');
define($constpref.'_NOTCAT_FORUM', 'Este f�rum'); //
define($constpref.'_NOTCAT_FORUMDSC', 'As notifica��es sobre o objetivo do f�rum');
define($constpref.'_NOTCAT_CAT', 'Esta categoria'); //
define($constpref.'_NOTCAT_CATDSC', 'As notifica��es sobre o objetivo do categoria');
define($constpref.'_NOTCAT_GLOBAL', 'Este m�dulo'); //
define($constpref.'_NOTCAT_GLOBALDSC', 'As notifica��es sobre o objetivo do m�dulo');

// Each Notifications
define($constpref.'_NOTIFY_TOPIC_NEWPOST', 'Nova mensagem no t�pico'); //
define($constpref.'_NOTIFY_TOPIC_NEWPOSTCAP', 'Notificar-me de novas mensagens neste t�pico'); //
define($constpref.'_NOTIFY_TOPIC_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{TOPIC_TITLE} NOVA MENSAGEM NO T�PICO'); //

define($constpref.'_NOTIFY_FORUM_NEWPOST', 'Nova mensagem no f�rum'); //
define($constpref.'_NOTIFY_FORUM_NEWPOSTCAP', 'Notificar-me de novas mensagens neste f�rum.');   //
define($constpref.'_NOTIFY_FORUM_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} NOVA MENSAGEM NO FORUM');//

define($constpref.'_NOTIFY_FORUM_NEWTOPIC', 'Novo t�pico no f�rum'); //
define($constpref.'_NOTIFY_FORUM_NEWTOPICCAP', 'Notificar-me de novos t�picos neste f�rum.');    //
define($constpref.'_NOTIFY_FORUM_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} NOVO T�PICO NO FORUM'); //

define($constpref.'_NOTIFY_CAT_NEWPOST', 'Nova mensagem na categoria');   //
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP', 'Notificar-me de novas mensagens nesta categoria.');   //
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} NOVA MENSAGEM NA CATEGORIA');  //

define($constpref.'_NOTIFY_CAT_NEWTOPIC', 'Novo t�pico na categoria');  //
define($constpref.'_NOTIFY_CAT_NEWTOPICCAP', 'Notificar-me de novos t�picos nesta categoria.');  //
define($constpref.'_NOTIFY_CAT_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} NOVA MENSAGEM NA CATEGORIA'); //

define($constpref.'_NOTIFY_CAT_NEWFORUM', 'Novo f�rum na categoria'); //
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP', 'Notificar-me de novos foruns nesta categoria.');  //
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} NOVO FORUM NA CATEGORIA'); //

define($constpref.'_NOTIFY_GLOBAL_NEWPOST', 'Nova mensagem no m�dulo'); //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP', 'Notificar-me de novas mensagens no m�dulo.'); //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}: NOVA MENSAGEM');  //

define($constpref.'_NOTIFY_GLOBAL_NEWTOPIC', 'Novo t�pico no m�dulo');   //
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICCAP', 'Notificar-me de novos t�picos no m�dulo.');  //
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}: NOVO T�PICA');   //

define($constpref.'_NOTIFY_GLOBAL_NEWFORUM', 'Novo f�rum no m�dule');  //
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMCAP', 'Notificar-me de novos f�runs no m�dulo.');  //
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}: NOVO FORUM'); //

define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULL', 'Nova Mensagem (Texto Completo)');   //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLCAP', 'Notificar-me de todas as novas mensagens (incluir o texto completo nas mensagem).'); //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLSBJ', '[{X_SITENAME}] {POST_TITLE}'); //
define($constpref.'_NOTIFY_GLOBAL_WAITING', 'Requerendo aprova��o');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP', 'Notificar-me de novas mensagens que requerem a aprova��o. Somente para administrador.');  //
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ', '[{X_SITENAME}] {X_MODULE}: Requerendo aprova��o');
}
?>
