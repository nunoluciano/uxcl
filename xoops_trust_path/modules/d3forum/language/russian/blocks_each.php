<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {


// Appended by Xoops Language Checker -GIJOE- in 2007-04-05 12:11:22
define($constpref.'_ALT_UNSOLVED','Unsolved topic');
define($constpref.'_ALT_MARKED','Marked topic');

define( $constpref.'_LOADED' , 1 ) ;

// definitions for displaying blocks 
define($constpref."_FORUM","�����");
define($constpref."_TOPIC","����");
define($constpref."_REPLIES","������");
define($constpref."_VIEWS","���������");
define($constpref."_VOTESCOUNT","������");
define($constpref."_VOTESSUM","����");
define($constpref."_LASTPOST","��������� ���������");
define($constpref."_LASTUPDATED","��������� ����������");
define($constpref."_LINKTOSEARCH","����� �� ������");
define($constpref."_LINKTOLISTCATEGORIES","������ ���������");
define($constpref."_LINKTOLISTFORUMS","������ �������");
define($constpref."_LINKTOLISTTOPICS","������ ���");

}

?>
