<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3diary' ;
$constpref = "_MB_" . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// definitions for displaying blocks 
define($constpref."_DIARY","����");
define($constpref."_NOTITLE","�����ȥ�ʤ�");
define($constpref."_EXIST_COMMENTS","�����Ȥ���");
define($constpref."_NO_COMMENTS","�����Ȥʤ�");
define($constpref."_NOCNAME","̤ʬ��");
define($constpref."_CATEGORY_EDIT","���ƥ��꡼���Խ�");
define($constpref."_MORE","��äȸ���");
define($constpref."_COMMENT_LIST","�����Ȱ���");
define($constpref."_DIARY_FRIENDSVIEW","ͧ����������");

define($constpref."_YEAR","ǯ");
define($constpref."_MONTH","��");
define($constpref."_DAY","��");
define($constpref."_W_SUN","��");
define($constpref."_W_MON","��");
define($constpref."_W_TUE","��");
define($constpref."_W_WED","��");
define($constpref."_W_THR","��");
define($constpref."_W_FRY","��");
define($constpref."_W_SAT","��");
define($constpref."_CALWEEK","��,��,��,��,��,��,��");
define($constpref."_M_JAN","1��");
define($constpref."_M_FEB","2��");
define($constpref."_M_MAR","3��");
define($constpref."_M_APR","4��");
define($constpref."_M_MAY","5��");
define($constpref."_M_JUN","6��");
define($constpref."_M_JUL","7��");
define($constpref."_M_AUG","8��");
define($constpref."_M_SEP","9��");
define($constpref."_M_OCT","10��");
define($constpref."_M_NOV","11��");
define($constpref."_M_DEC","12��");
define($constpref."_CTITLE","�Υ�������");
define($constpref."_BEFORE_MONTH","���η�");
define($constpref."_NEXT_MONTH","���η�");

define($constpref."_OTHER","�����֥���");
define($constpref."_NEWDIARY","��������");
define($constpref."_NEWPHOTO","��������");

// definitions for displaying d3comment blocks 
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

define($constpref."_B_ORDERPOSTED","�������"); 
define($constpref."_B_ORDERRANDOM","���������"); 
define($constpref."_PERSON","���������"); 

}

?>