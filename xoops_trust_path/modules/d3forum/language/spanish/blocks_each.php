<?php
//Traducci�n al espa�ol para ImpressCMS por debianus

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// definitions for displaying blocks 
define($constpref."_FORUM","Foro");
define($constpref."_TOPIC","Tema");
define($constpref."_REPLIES","Respuestas");
define($constpref."_VIEWS","Visto");
define($constpref."_VOTESCOUNT","Votos");
define($constpref."_VOTESSUM","Puntuaci�n");
define($constpref."_LASTPOST","�ltimo mensaje");
define($constpref."_LASTUPDATED","�ltima actualizaci�n");
define($constpref."_LINKTOSEARCH","Buscar en el foro");
define($constpref."_LINKTOLISTCATEGORIES","�ndice de categor�as");
define($constpref."_LINKTOLISTFORUMS","�ndice del foro");
define($constpref."_LINKTOLISTTOPICS","�ndice de temas");
define($constpref."_ALT_UNSOLVED","Tema no solucionado");
define($constpref."_ALT_MARKED","Tema marcado");

}

?>