<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {


// Appended by Xoops Language Checker -GIJOE- in 2007-09-26 17:55:47
define($constpref.'_ALT_UNSOLVED','Unsolved topic');
define($constpref.'_ALT_MARKED','Marked topic');

define( $constpref.'_LOADED' , 1 ) ;

// definitions for displaying blocks
define($constpref."_FORUM","F�rum");
define($constpref."_TOPIC","T�pico");
define($constpref."_REPLIES","Respostas");
define($constpref."_VIEWS","Leituras");
define($constpref."_VOTESCOUNT","Votos");
define($constpref."_VOTESSUM","Contagens");
define($constpref."_LASTPOST","�ltima postagem");
define($constpref."_LASTUPDATED","Ultima atualiza��o");
define($constpref."_LINKTOSEARCH","Busca no f�rum");
define($constpref."_LINKTOLISTCATEGORIES","Categotia principal");
define($constpref."_LINKTOLISTFORUMS","F�rum principal");
define($constpref."_LINKTOLISTTOPICS","T�pico principal");
}
?>