<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3pipes' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","D3 PIPES");

// A brief description of this module
define($constpref."_DESC","M�dulo Flex�vel de Propaga��o de Informa��es");

// admin menus
define($constpref.'_ADMENU_PIPE','Feed') ;
define($constpref.'_ADMENU_CACHE','Cache') ;
define($constpref.'_ADMENU_CLIPPING','Clippings') ;
define($constpref.'_ADMENU_JOINT','Conjuntos iniciais') ;
define($constpref.'_ADMENU_JOINTCLASS','Class Iniciais') ;
define($constpref.'_ADMENU_MYLANGADMIN','Linguagens') ;
define($constpref.'_ADMENU_MYTPLSADMIN','Modelos') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocos e Permiss�es') ;
define($constpref.'_ADMENU_MYPREFERENCES','Prefer�ncias') ;

// blocks
define($constpref.'_BNAME_ASYNC','�ltimos Feeds (Async)') ;
define($constpref.'_BNAME_SYNC','�ltimos Feeds (Sync)') ;

// configs
define($constpref.'_INDEXTOTAL','Total de registros no topo deste m�dulo');
define($constpref.'_INDEXEACH','M�ximo de registros de um feed no topo deste m�dulo');
define($constpref.'_INDEXKEEPPIPE','Mostrar no topo deste m�dulo acima dos feeds, quando possivel ');
define($constpref.'_ENTRIESAPIPE','Registros vistos de cada um dos feeds');
define($constpref.'_ENTRIESAPAGE','Registros em uma p�gina na lista de clipping');
define($constpref.'_ENTRIESARSS','Registros de um RSS/ATOM');
define($constpref.'_ENTRIESSMAP','Registros do sitemap xml para google etc');
define($constpref.'_ARCB_FETCHED','Auto expira��o do tempo das buscas (dias)');
define($constpref.'_ARCB_FETCHEDDSC','Especificar os dias que os clippings dever�o ser removidos. 0 significa desabilitar auto-expira��o. Os clippings com coment�rios e destacados nunca ser�o removidos.');
define($constpref.'_INTERNALENC','Codifica��o interna');
define($constpref.'_FETCHCACHELT','Tempo da busca em cache (seg)');
define($constpref.'_REDIRECTWARN','Alertar se a URI RSS/ATOM ser� redirecionada');
define($constpref.'_SNP_MAXREDIRS','Redirecionamento m�ximo para Snoopy');
define($constpref.'_SNP_MAXREDIRSDSC','Depois da contru��o dos feeds com sucesso, configures esta op��o como 0');
define($constpref.'_SNP_PROXYHOST','Nome do host do servidor proxy');
define($constpref.'_SNP_PROXYHOSTDSC','especificar isso por FQDN. Normalmente, deixe em branco aqui');
define($constpref.'_SNP_PROXYPORT','Porta do servidor proxy');
define($constpref.'_SNP_PROXYUSER','Nome de usu�rio para o servidor proxy');
define($constpref.'_SNP_PROXYPASS','Senha para o servidor proxy');
define($constpref.'_SNP_CURLPATH','curl percurso (padr�o: /usr/bin/curl)');
define($constpref.'_TIDY_PATH','tidy percurso (padr�o: /usr/bin/tidy)');
define($constpref.'_XSLTPROC_PATH','xsltproc percurso (padr�o: /usr/bin/xsltproc)');
define($constpref.'_UPING_SERVERS','Atualizar servidores Ping');
define($constpref.'_UPING_SERVERSDSC','Escreva um RPC end point come�ando com "http://" uma linha.<br />Se voc� precisar enviar um Ping longo, adicione " E" depois da URI.');
define($constpref.'_UPING_SERVERSDEF',"http://blogsearch.google.com/ping/RPC2 E\nhttp://rpc.weblogs.com/RPC2 E\nhttp://ping.blo.gs/ E");
define($constpref.'_CSS_URI','CSS URI');
define($constpref.'_CSS_URIDSC','percurso relativo ou absoluto pode ser configurado. padr�o: {mod_url}/index.css');
define($constpref.'_IMAGES_DIR','Diret�rio para os arquivos de imagem');
define($constpref.'_IMAGES_DIRDSC','o percurso relativo deve ser configurado no diret�rio do m�dulo. padr�o: images');
define($constpref.'_COM_DIRNAME','Integra��o dos coment�rios: nome do diret�rio do d3forum');
define($constpref.'_COM_FORUM_ID','Integra��o dos coment�rios: ID do f�rum');
define($constpref.'_COM_VIEW','Vizualia��o da integra��o dos coment�rios');
define($constpref.'_COM_ORDER','Ordem da integra��o dos coment�rios');
define($constpref.'_COM_POSTSNUM','M�ximo de posts mostrados na Integra��o dos coment�rios');
define($constpref.'_BACKEND_PIPE_ID','ID do tubo para backend.php (Disabled: 0)');

}


?>
