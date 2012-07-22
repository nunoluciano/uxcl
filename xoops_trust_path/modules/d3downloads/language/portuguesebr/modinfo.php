<?php
//  ------------------------------------------------------------------------ //
// $Id: modinfo.php 0003 12:32 2008/04/09 avtx30 $
//  ------------------------------------------------------------------------ //
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3downloads' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","M��ulo Duplic��el V3(D3) para downloads");

// A brief description of this module
define($constpref."_DESC","Cria uma se��o de downloads onde os usu��ios podem baixar, enviar e avaliar os diversos arquivos.");

// admin menus
define($constpref.'_ADMENU_FILEMANAGER',"Downloads") ;
define($constpref.'_ADMENU_APPROVALMANAGER',"Aprova��o") ;
define($constpref.'_ADMENU_CATEGORYMANAGER',"Categorias") ;
define($constpref.'_ADMENU_USER_ACCES','Permiss��s das Categorias') ;
define($constpref.'_ADMENU_IMPORT',"Importar e Atualizar") ;
define($constpref.'_ADMENU_CONFIG_CHECK',"Checagem do Ambiente") ;
define($constpref.'_ADMENU_MYLANGADMIN',"Linguagens") ;
define($constpref.'_ADMENU_MYTPLSADMIN',"Modelos") ;
define($constpref.'_ADMENU_MYBLOCKSADMIN',"Blocos e Permiss��s") ;
define($constpref.'_ADMENU_MYPREFERENCES',"Prefer��cias") ;

// blocks
define($constpref.'_BNAME_RECENT',"��timos Downloads") ;
define($constpref.'_BNAME_TOPRANK',"Top Downloads") ;
define($constpref.'_BNAME_DOWNLOAD',"Informa��es do Download") ;
define($constpref.'_BNAME_LIST',"Lista de Downloads") ;
define($constpref.'_BNAME_PICKUP',"Pickup Downloads") ;
define($constpref.'_BNAME_CATEGORY','Categories') ;

// Sub menu titles
define($constpref.'_SMNAME1',"Popular");
define($constpref.'_SMNAME2',"Melhor Avaliado");
define($constpref.'_SMNAME3','Lista de Arquivos');
define($constpref.'_MYPOST_VIEW','Meu Post');

// Title of config items
define($constpref.'_POPULAR',"N��ero de hits para um download ser considerado como popular");
define($constpref.'_NEWDLS',"N��ero m��imo de novos downloads a serem mostrados na p��ina principal");
define($constpref.'_NEWMARK',"N��ero de dias para mostrar o ��one 'Novo'");
define($constpref.'_PERPAGE',"Listar contador de Download");
define($constpref.'_ORDER','Ordenar padr�� download');
define($constpref.'_ORDERSC','Selecionar a ordem padr�� para o download listado.');
define($constpref.'_POPULARITYLTOM','Popularidade (Do hit mais baixo para o mais alto)');
define($constpref.'_POPULARITYMTOL','Popularidade (Do hit mais alto para o mais baixo');
define($constpref.'_TITLEATOZ','T��ulo (A para Z)');
define($constpref.'_TITLEZTOA','T��ulo (Z para A)');
define($constpref.'_DATEOLD','Data (Arquivos mais antigos listados primeiro)');
define($constpref.'_DATENEW','Date (Arquivos mais novos listados primeiro)');
define($constpref.'_RATINGLTOH','Avalia��o (Do mais baixo escore para o mais alto)');
define($constpref.'_RATINGHTOL','Avalia��o (Do mais alto escore para o mais baixo)');
define($constpref.'_POSTNAME','Mostrar o nome de quem enviou na listagem do download');
define($constpref.'_MYPOST','Mostrar minhas fotos no sub menu');
define($constpref.'_USESHOTS',"Mostrar imagens do screenshot");
define($constpref.'_USEALBUM',"Utilizar o m��ulo administrador de envio de imagens para as imagens screenshot");
define($constpref.'_USEALBUMDSC',"Quando 'Mostrar Imagens Screenshot' for configurado Sim, o m��ulo de administra��o de envio de imagem pode ser usado para as imagens do screenshot.");
define($constpref.'_ALBUMSELECT',"Nome do diret��io do related myAlbum-P");
define($constpref.'_ALBUMSELECTDSC',"Por favor, informe o nome do diret��io do m��ulo de administra��o de imagens (exemplo: myalbum)");
define($constpref.'_SHOTSSELECT',"Usar thumbnail web service para criar imagens screenshot");
define($constpref.'_SHOTSSELECTDSC',"Se 'Mostrar Imagens Screenshot' for selecionado e n�� existirem imagens screenshot, utilize thumbnail web service para criar imagens alternativas.");
define($constpref.'_SHOTWIDTH',"Mostrar largura da Imagem");
define($constpref.'_CHECKURL',"Desalbilitar downloads da mesma URL");
define($constpref.'_CHECKHOST',"Desabilitar download linkado direto (parasita)");
define($constpref.'_REFERERS',"Sites que podem linkar diretamente para seus arquivos <br />Separado com | ");
define($constpref.'_PER_HISTORY',"N��ero de gera��es para o hist��ico");
define($constpref.'_EXTENSION',"Extens��s permitidadas");
define($constpref.'_EXTENSIONDSC',"Listar as extens��s permitidas separadas por |. Letras pequenas sem espa��s ou pontos. php ou html ser�ignorado.");
define($constpref.'_MAXFILESIZE',"Tamanho m��imo do arquivo para envio (in bytes)");
define($constpref.'_MULTIDOT',"Checar multi-dot quando do envio");
define($constpref.'_MULTIDOTDSC',"Configurar permiss�� de envio para nome do arquivos com multiplos pontos (nome de aquivos com dois ou mais pontos). Por padr��, arquivos com multiplos pontos ser�� apagados raz��s de sesguran��.");
define($constpref.'_CHECKHEAD',"Checar o cabe��lho do arquivo quando do envio");
define($constpref.'_PURIFIER',"Remover palavras fraudulentas quando o Html estiver ativado");
define($constpref.'_PURIFIERDSC',"Quando o Html estiver ativado, o filtro Html ser�validado por padr�� para remover algumas palavras fraudulentas. Os postadores s�� limitados para usu��ios de confian��. Por favor, selecione 'Sim' na maioria dos casos, exceto quando os filtros de Html provocam alguns efeitos colaterais.");
define($constpref.'_PLATFORM',"Plataforma");
define($constpref.'_PLATFORMDSC',"Listar a plataforma (OS, application, etc), separada com | . Elas ser�� mostradas na caixa de sele��o do formulario de envio.");
define($constpref.'_TELLAFRINED',"Usar o m��ulo 'Recomende a um amigo'");
define($constpref.'_PER_RSS',"N��ero de itens de RSS");
define($constpref.'_COM_DIRNAME',"Integra��o de coment��ios: nome do diret��io do d3forum");
define($constpref.'_COM_FORUM_ID',"Integra��o de coment��ios: ID do f��um");
define($constpref.'_COM_VIEW',"Integra��o de coment��ios: Modo de vizualiza��o");
define($constpref.'_COM_ORDER','Ordem da integra��o de coment��ios');
define($constpref.'_COM_POSTSNUM','N��ero m��imo de post mostrados na integra��o de coment��ios');
define($constpref.'_CRON_PASS','Senha de um arquivo errado / checar link quebrado para cron');
define($constpref.'_CRONPASSDSC','Quando usar uma fun��o de checagem running out do arquivo quebrado ou linha de comando no link, por favor use a senha configurada aqui. Utilize apenas caracteres alfanum��icos. Por favor, n�� deixe em branco.');

define($constpref.'_POPULARDSC',"N��ero de hits antes do status do Download ser considerado como popular.");
define($constpref.'_NEWDLSDSC',"Por favor, configure o n��ero de downloads para serem mostrados no topo da p��ina dos ��timos Downloads");
define($constpref.'_PERPAGEDSC',"N��ero de Downloads a serem mostrados na lista de cada categoria.");
define($constpref.'_SHOTWIDTHDSC',"Digite a largura m��ima (em pixels) das imagens screenshot");
define($constpref.'_REFERERSDSC',"Por favor, relacione os sites os quais podem linkar diretamente seus arquivos");

// Notify Categories
define($constpref.'_NOTCAT_CAT',"Categorias dispon��eis");
define($constpref.'_NOTCAT_CATDSC',"Configura��o das notifica��es para as categorias dipon��eis");
define($constpref.'_NOTCAT_GLOBAL',"Todo o M��uto");
define($constpref.'_NOTCAT_GLOBALDSC',"Configura��es das notifica��es globais para este m��ulo");
define($constpref.'_NOTCAT_FILE', 'P��ina atual');
define($constpref.'_NOTCAT_FILEDSC', 'Op��es de notifica��o aplic��eis a p��ina atual.');

// Each Notifications
define($constpref.'_NOTIFY_CAT_NEWPOST',"Novo post na categoria");
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP',"Notifique-me quando houver um novo post nesta categaria.");
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ',"[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} novo post");

define($constpref.'_NOTIFY_CAT_NEWPOSTFULL',"Todo o post nesta categoria");
define($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP',"Notifique-me com todo o post quando houver um novo post nesta cagegoria.");
define($constpref.'_NOTIFY_CATL_NEWPOSTFULLSBJ',"[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} todo o post");

define($constpref.'_NOTIFY_CAT_NEWFORUM',"Novo f��um nesta categoria");
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP',"Notifique-me quando houver um novo forum nesta cagegoria.");
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ',"[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} novo f��um");

define($constpref.'_NOTIFY_GLOBAL_NEWPOST',"Novo Post");
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP',"Notifique-me quando houver um novo post neste m��ulo.");
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ',"[{X_SITENAME}] {X_MODULE}: novo post");

define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORY',"Todo o M��ulo");
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP',"Notifique-me quando houver uma nova categoria neste m��ulo.");
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYSBJ',"[{X_SITENAME}] {X_MODULE}: nova categoria");

define($constpref.'_NOTIFY_GLOBAL_WAITING',"Aguardando aprova��o");
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP',"Notifique-me quando houver um download enviado ou editado aguardando aprova��o.");
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ',"[{X_SITENAME}] {X_MODULE}: aguardando");

define($constpref.'_NOTIFY_GLOBAL_BROKEN',"Comunica��o de arquivo errado");
define($constpref.'_NOTIFY_GLOBAL_BROKENCAP',"Notifique-me quando houver uma comunica��o de erro. (Somente para os webmasters)");
define($constpref.'_NOTIFY_GLOBAL_BROKENSBJ',"[{X_SITENAME}] {X_MODULE}: comunica��o de download errado");

define($constpref.'_NOTIFY_GLOBAL_APPROVE',"Aprova��o de Download");
define($constpref.'_NOTIFY_GLOBAL_APPROVECAP',"Notifique-me quando este download for aprovado.");
define($constpref.'_NOTIFY_GLOBAL_APPROVECAPSBJ',"[{X_SITENAME}] {X_MODULE}: arquivo aprovado");

// add photosite
define($constpref.'_CHECKHEADDSC','Por padr��, a primeira parte de um arquivo �checada quando do envio.') ;
define($constpref.'_ADMENU_BROKENMANAGER','Comunica��es de erro') ;
define($constpref.'_TOP_MESSAGE','Descri��o da categoria TOP');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_BREADCRUMBS','Mostrar breadcrumbs');
define($constpref.'_EDITOR','Corpo do editor');
define($constpref.'_EDITORDSC','o fckeditor ser�habilitado apenas sob a categoria que for permito o HTML. Nesta categoria , os caracteres especiais de escape do HTML do xoopsdhtml ser�� mostrados automaticamente.');
define($constpref.'_USELICENSE','Mostrar Licen��');
define($constpref.'_LICENSE','Licen��');
define($constpref.'_LICENSEDSC','Listar licen�� separada com | . Elas ser�� mostradas na caixa de sele��o do formul��io de envio.');
define($constpref."_PLUSPOSTS","Computar os posts no contador de post dos usu��io");
define($constpref."_PLUSPOSTSDSC", "Quando os downloads mais novos forem publicados, os 'Posts' dos usu��ios ser�� aumentados.");
define($constpref.'_BNAME_MYLINK','Listar meu Link') ;
define($constpref.'_MYLINK','Meu Link');
define($constpref.'_MODULESELECT','O m��ulo de administra��o de imagem usado em conjunto �selecionado. ');
define($constpref.'_ALBUMMODULEDSC','Agora isso corresponde ao myAlbum-P, GnaviD3 e webphoto.');
define($constpref.'_NOTIFY_FILE_COMMENT', 'novo coment��io');
define($constpref.'_NOTIFY_FILE_COMMENTCAP', 'Notifique-me quando um novo coment��io for postado.');
define($constpref.'_NOTIFY_FILE_COMMENTSBJ', '[{X_SITENAME}] {X_MODULE} : novo coment��io');
define($constpref.'_CSS_URI','URI do arquivo CSS para este m��ulo');
define($constpref.'_CSS_URIDSC','o percurso absoluto ou relativo pode ser configurado. Padr��: {mod_url}/index.php?page=module_header&src=main.css');
define($constpref.'_LIVE_URI','URI do arquivo CSS para livevalidation');
define($constpref.'_LIVE_URIDSC','o percurso absoluto ou relativo pode ser configurado. Padr��: {mod_url}/index.php?page=module_header&src=livevalidation.css');
define($constpref.'_HTMLPR_EXCEPT','Grupos que podem evitar purifica��o por Html estiver ativado');
define($constpref.'_HTMLPR_EXCEPTDSC','Posts de usu��ios que n�� pertencem a esses ser�� for��dos a purifica��o com o sanitized HTML pelo Html estiver ativado');

}
?>
