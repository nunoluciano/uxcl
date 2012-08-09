<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3pipes' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {




// Appended by Xoops Language Checker -GIJOE- in 2009-01-18 07:46:42
define($constpref.'_COM_ORDER','Order of comment-integration');

// Appended by Xoops Language Checker -GIJOE- in 2008-11-18 04:46:03
define($constpref.'_INDEXKEEPPIPE','Displays upper pipes as possible in the top of this module');

// Appended by Xoops Language Checker -GIJOE- in 2008-05-20 05:59:23
define($constpref.'_COM_VIEW','View of comment-integration');
define($constpref.'_COM_POSTSNUM','Max posts displayed in comment-integration');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","D3 PIPES");

// A brief description of this module
define($constpref."_DESC","Module de Syndication Flexible");

// admin menus
define($constpref.'_ADMENU_PIPE','Flux') ;
define($constpref.'_ADMENU_CACHE','Cache') ;
define($constpref.'_ADMENU_CLIPPING','Clips') ;
define($constpref.'_ADMENU_JOINT','Joint initiales') ;
define($constpref.'_ADMENU_JOINTCLASS','Classes initials') ;
define($constpref.'_ADMENU_MYLANGADMIN','Langages') ;
define($constpref.'_ADMENU_MYTPLSADMIN','Templates') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocs/Permissions') ;
define($constpref.'_ADMENU_MYPREFERENCES','Pr�f�rences') ;

// blocks
define($constpref.'_BNAME_ASYNC','Liste d\'entr�es (Async)') ;
define($constpref.'_BNAME_SYNC','Liste d\'entr�es (Sync)') ;

// configs
define($constpref.'_INDEXTOTAL','Total d\'entr�es en t�te de ce module');
define($constpref.'_INDEXEACH','Max entr�es depuis un flux en t�te de module');
define($constpref.'_ENTRIESAPIPE','Max entr�es a afficher/RSS pour chaque flux');
define($constpref.'_ENTRIESAPAGE','Entr�es par page dans la liste des clips');
define($constpref.'_ENTRIESARSS','Entr�es par RSS/Atom');
define($constpref.'_ENTRIESSMAP','Entri�es du sitemap xml pour google etc');
define($constpref.'_ARCB_FETCHED','Auto expire par temps de pr�l�vement (jours)');
define($constpref.'_ARCB_FETCHEDDSC','Specifier nombre de jours que les clips doivent �tre retir�s. 0 signifie d�sactiver auto-expire. Les Clips avec des commentaures/surlign�s ne sont jamais restir�s.');
define($constpref.'_INTERNALENC','Encodage Interne');
define($constpref.'_FETCHCACHELT','Temps de cache du pr�l�vement (sec)');
define($constpref.'_REDIRECTWARN','Alerter si le URI du rss/atom est redirig�');
define($constpref.'_SNP_MAXREDIRS','Max redirections pour Snoopy');
define($constpref.'_SNP_MAXREDIRSDSC','Apr�s contruire ules flux avec succ�s, cchangez cette option en 0');
define($constpref.'_SNP_PROXYHOST','Hostname ou serveur proxy');
define($constpref.'_SNP_PROXYHOSTDSC','specifier ceci par FQDN. Normalement laisser ceci en blanc');
define($constpref.'_SNP_PROXYPORT','Port du serveur proxy');
define($constpref.'_SNP_PROXYUSER','Nom d\'utilisateur pour le serveur proxy');
define($constpref.'_SNP_PROXYPASS','Mot de passe pour le serveur proxy');
define($constpref.'_SNP_CURLPATH','Chemin de boucle (d�faut: /usr/bin/curl)');
define($constpref.'_TIDY_PATH','Chemin de Tidy (d�faut: /usr/bin/tidy)');
define($constpref.'_XSLTPROC_PATH','Chemin de xsltproc (d�faut: /usr/bin/xsltproc)');
define($constpref.'_UPING_SERVERS','Mettre � jour les serveurs Ping');
define($constpref.'_UPING_SERVERSDSC','�crire un point final RPC commen�ant la ligne par "http://".<br />Si vous voulez envoyer extendedPing, ajouter " E" apr�s le URI.');
define($constpref.'_UPING_SERVERSDEF',"http://blogsearch.google.com/ping/RPC2 E\nhttp://rpc.weblogs.com/RPC2 E\nhttp://ping.blo.gs/ E");

define($constpref.'_CSS_URI','CSS URI');
define($constpref.'_CSS_URIDSC','un chemin relatif ou absolut peut �tre d�finit. D�faut: {mod_url}/index.css');
define($constpref.'_IMAGES_DIR','Rep�rtoire pour les fichiers images');
define($constpref.'_IMAGES_DIRDSC','le chemin relatif devrait �tre configur� dans le rep�rtoire du module. d�faut: images');
define($constpref.'_COM_DIRNAME','Integration-Commentaires: dirname de d3forum');
define($constpref.'_COM_FORUM_ID','Int�gration-Commentaires: ID forum');
define($constpref.'_BACKEND_PIPE_ID','Tuyau d\'identit� pour backend.php (handicap�s: 0)');

}


?>