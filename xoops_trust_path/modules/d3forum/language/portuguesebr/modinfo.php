<?php

// site par cont�do traduzidos para o CMS XOOPS
// PORTAL X-TRAD - http://www.x-trad.org/
// traduzido por artsgeral

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","Forum");

// A brief description of this module
define($constpref."_DESC","Forum module for XOOPS");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME_LIST_TOPICS","Topicos"); //
define($constpref."_BDESC_LIST_TOPICS","Este bloco pode ser usado para varias finalidade. Naturalmente, voc� pode por multiplly.");
define($constpref."_BNAME_LIST_POSTS","Mensagens"); //
define($constpref."_BNAME_LIST_FORUMS","Forums");  //

// admin menu
define($constpref.'_ADMENU_CATEGORYACCESS','Permiss�es das Categorias');
define($constpref.'_ADMENU_FORUMACCESS','Permiss�es dos Forums');
define($constpref.'_ADMENU_ADVANCEDADMIN','Avan�ado');
define($constpref.'_ADMENU_POSTHISTORIES','Historias');
define($constpref.'_ADMENU_MYLANGADMIN','Linguagem');
define($constpref.'_ADMENU_MYTPLSADMIN','Templates');
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocos/Permiss�es');
define($constpref.'_ADMENU_MYPREFERENCES','Preferencias');

// configurations
define($constpref.'_TOP_MESSAGE','Mensagem no inicio do forum');  //
define($constpref.'_TOP_MESSAGEDEFAULT','<h1 class="d3f_title">Inicio do Forum</h1><p class="d3f_welcome">Para come�ar a visualizar as mensagens, selecionar uma  categoria ou o forum de que voc� queira visitar na sele��o abaixo.</p>');  //
define($constpref.'_SHOW_BREADCRUMBS','Visualizar breadcrumbs');
define($constpref.'_DEFAULT_OPTIONS','Checkbox padr�o no formul�rio de mensagens');
define($constpref.'_DEFAULT_OPTIONSDSC','Listar as op��es de checkbox separadas por v�rgula(,).<br />ex) smiley,xcode,br,number_entity<br />Voc� pode adicionar estas op��es: special_entity html attachsig u2t_marked');
define($constpref.'_ALLOW_HTML','Permitir HTML'); //
define($constpref.'_ALLOW_HTMLDSC','N�o coloque SIM, ocasionalmente. Pois isto pode conter uma vunerabilidade e que um usuario coloque um script malicioso.'); //
define($constpref.'_ALLOW_TEXTIMG','Permitir visualzar as imagens externas na mensagem'); //
define($constpref.'_ALLOW_TEXTIMGDSC','Se alguem afixar uma imagem externa usando [img], ele pode saber quais o IPs ou os usu�rios visitaram seu site.'); //
define($constpref.'_ALLOW_SIG','Permitir a assinatura'); //
define($constpref.'_ALLOW_SIGDSC','');
define($constpref.'_ALLOW_SIGIMG','Permitir vizualizar imagens externas na assinatura');  //
define($constpref.'_ALLOW_SIGIMGDSC','Se alguem afixar uma imagem externa usando [img], ele pode saber quais o IPs ou os usu�rios visitaram seu site.');   //
define($constpref.'_USE_VOTE','usar a caracter�stica do VOTO');
define($constpref.'_USE_SOLVED','usar a caracter�stica de RESOLVIDO');  //
define($constpref.'_ALLOW_MARK','usar a caracter�stica de MARCAR T�PICO');   //
define($constpref.'_ALLOW_HIDEUID','Permitir um usu�rio registrado pode postar sem seu nome'); //
define($constpref.'_POSTS_PER_TOPIC','M�ximo de mensagens por t�pico');  //
define($constpref.'_POSTS_PER_TOPICDSC','O t�pico tem um limite de suas mensagens'); //
define($constpref.'_HOT_THRESHOLD','T�pico Quente');//
define($constpref.'_HOT_THRESHOLDDSC','Mensagens nescessarias para se tornar um TOPICO QUENTE');
define($constpref.'_TOPICS_PER_PAGE','M�ximo de t�picos por pagina, mostrada no forum.'); //
define($constpref.'_TOPICS_PER_PAGEDSC','');
define($constpref.'_VIEWALLBREAK','T�picos por uma p�gina nos forums do cruzamento da vista');
define($constpref.'_VIEWALLBREAKDSC','');
define($constpref.'_SELFEDITLIMIT','O limite de tempo para usu�rios editar as mensagens (em segundo)'); //
define($constpref.'_SELFEDITLIMITDSC','N�o permitir de usu�rios normais de poder editar, determinando 0 (zero). Permitir usu�rios normais de pode editar, determinando o valor em segundos.');
define($constpref.'_SELFDELLIMIT','Limite de tempo para os usu�rios apagarem as mensagens (em segundo)');
define($constpref.'_SELFDELLIMITDSC','N�o permitir de usu�rios normais de poder apagar, determinando 0 (zero). Permitir usu�rios normais de pode apagar, determinando o valor em segundos.');
define($constpref.'_CSS_URI','Usar arquivo URI ou CSS para este m�dulo'); //
define($constpref.'_CSS_URIDSC','o trajeto relativo ou absoluto pode ser ajustado por padr�o: index.css'); //
define($constpref.'_IMAGES_DIR','Diret�rio para arquivos de imagem'); //
define($constpref.'_IMAGES_DIRDSC','o trajeto relativo deve ser ajustado no diret�rio do m�dulo, por padr�o: imagens'); //
define($constpref.'_BODY_EDITOR','Corpo do Editor');
define($constpref.'_BODY_EDITORDSC','O editor WYSIWYG ser� habilitado somente nos f�runs onde for permitido o HTML. Com f�runs escapando dos caracteres especiais do HTML, o xoopsdhtml ser� mostrado autom�ticamnte.');
define($constpref.'_ANONYMOUS_NAME','Nome para Convidados');
define($constpref.'_ANONYMOUS_NAMEDSC','');
define($constpref.'_ICON_MEANINGS','Significado dos �cones');
define($constpref.'_ICON_MEANINGSDSC','Defini��o de ALTs dos �cones. Cada alts deve ser separado pelo pipe(|). O primeiro alt corresponde "posticon0.gif", dentro do diret�rio /images.');
define($constpref.'_ICON_MEANINGSDEF','none|normal|triste|feliz|baixo|alto|relatar|perguntar');
define($constpref.'_GUESTVOTE_IVL','Voto dos visitantes');//
define($constpref.'_GUESTVOTE_IVLDSC','Colocando 0(zero), impossibilita dos visitantes votarem. Qualquer outro numero significa o tempo (em segundos) para poderem votar de novo na mensagem, com o mesmo IP.'); //
define($constpref.'_ANTISPAM_GROUPS','Usar anti-SPAM para Grupos');
define($constpref.'_ANTISPAM_GROUPSDSC','Deixado geralmente em branco.<br> Vai desabilitar o anti-SPAM ');
define($constpref.'_ANTISPAM_CLASS','Class nome de anti-SPAM');
define($constpref.'_ANTISPAM_CLASSDSC','O valor padr�o � �default�. Para desabilitar o anti-SPAM, deixar em branco');


// Notify Categories
define($constpref.'_NOTCAT_TOPIC', 'Este t�pico');//
define($constpref.'_NOTCAT_TOPICDSC', 'As notifica��es sobre o objetivo do t�pico');
define($constpref.'_NOTCAT_FORUM', 'Este forum'); //
define($constpref.'_NOTCAT_FORUMDSC', 'As notifica��es sobre o objetivo do forum');
define($constpref.'_NOTCAT_CAT', 'Esta categoria'); //
define($constpref.'_NOTCAT_CATDSC', 'As notifica��es sobre o objetivo do categoria');
define($constpref.'_NOTCAT_GLOBAL', 'Este modulo'); //
define($constpref.'_NOTCAT_GLOBALDSC', 'As notifica��es sobre o objetivo do modulo');

// Each Notifications
define($constpref.'_NOTIFY_TOPIC_NEWPOST', 'Nova mensagem no t�pico'); //
define($constpref.'_NOTIFY_TOPIC_NEWPOSTCAP', 'Notificar-me de novas mensagens neste t�pico'); //
define($constpref.'_NOTIFY_TOPIC_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{TOPIC_TITLE} Nova mensagem no t�pico'); //

define($constpref.'_NOTIFY_FORUM_NEWPOST', 'Nova mensagem no forum'); //
define($constpref.'_NOTIFY_FORUM_NEWPOSTCAP', 'Notificar-me de novas mensagens neste forum.');   //
define($constpref.'_NOTIFY_FORUM_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} Nova mensagem no forum');//

define($constpref.'_NOTIFY_FORUM_NEWTOPIC', 'Novo t�pico no forum'); //
define($constpref.'_NOTIFY_FORUM_NEWTOPICCAP', 'Notificar-me de novos t�picos neste forum.');    //
define($constpref.'_NOTIFY_FORUM_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} Novo t�pico no forum'); //

define($constpref.'_NOTIFY_CAT_NEWPOST', 'Nova mensagem na categoria');   //
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP', 'Notificar-me de novas mensagens nesta categoria.');   //
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} Nova mensagem na categoria');  //

define($constpref.'_NOTIFY_CAT_NEWTOPIC', 'Novo t�pico na categoria');  //
define($constpref.'_NOTIFY_CAT_NEWTOPICCAP', 'Notificar-me de novos t�picos nesta categoria.');  //
define($constpref.'_NOTIFY_CAT_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} Nova mensagem na categoria'); //

define($constpref.'_NOTIFY_CAT_NEWFORUM', 'Novo forum na categoria'); //
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP', 'Notificar-me de novos foruns nesta categoria.');  //
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} Novo forum na categoria'); //

define($constpref.'_NOTIFY_GLOBAL_NEWPOST', 'Nova mensagem no m�dulo'); //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP', 'Notificar-me de novas mensagens no m�dulo.'); //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}: Nova mensagem');  //

define($constpref.'_NOTIFY_GLOBAL_NEWTOPIC', 'Novo t�pico no m�dulo');   //
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICCAP', 'Notificar-me de novos t�picos no m�dulo.');  //
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}: Novo t�pica');   //

define($constpref.'_NOTIFY_GLOBAL_NEWFORUM', 'Novo forum no m�dule');  //
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMCAP', 'Notificar-me de novos forums no m�dulo.');  //
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}: Novo forum'); //

define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULL', 'Nova Mensagem (Texto Completo)');   //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLCAP', 'Notificar-me de todas as novas mensagens (incluir o texto completo nas mensagem).'); //
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLSBJ', '[{X_SITENAME}] {POST_TITLE}'); //
define($constpref.'_NOTIFY_GLOBAL_WAITING', 'Requerendo aprova��o');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP', 'Notificar-me de novas mensagens que requerem a aprova��o. Somente para administrador.');  //
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ', '[{X_SITENAME}] {X_MODULE}: Requerendo aprova��o');

}

?>
