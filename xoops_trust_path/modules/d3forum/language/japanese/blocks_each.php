<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// definitions for displaying blocks 
define($constpref."_FORUM","�ե������");
define($constpref."_TOPIC","�ȥԥå�");
define($constpref."_REPLIES","�ֿ�");
define($constpref."_VIEWS","����");
define($constpref."_VOTESCOUNT","��ɼ");
define($constpref."_VOTESSUM","��ɼ");
define($constpref."_LASTPOST","�ǽ����");
define($constpref."_LASTUPDATED","�ǽ�����");
define($constpref."_LINKTOSEARCH","�ե�������⸡����");
define($constpref."_LINKTOLISTCATEGORIES","���ƥ��꡼������");
define($constpref."_LINKTOLISTFORUMS","�ե�����������");
define($constpref."_LINKTOLISTTOPICS","�ȥԥå�������");
define($constpref."_ALT_UNSOLVED","̤���ȥԥå�");
define($constpref."_ALT_MARKED","���ܥȥԥå�");

}

?>