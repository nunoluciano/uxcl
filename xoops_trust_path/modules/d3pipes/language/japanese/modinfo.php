<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3pipes' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","D3 PIPES");

// A brief description of this module
define($constpref."_DESC","RSS���Υ��󥸥���������ͳ���ߤ˰�������Υ⥸�塼��");

// admin menus
define($constpref.'_ADMENU_PIPE','�ѥ��״���') ;
define($constpref.'_ADMENU_CACHE','����å������') ;
define($constpref.'_ADMENU_CLIPPING','�ڤ�ȴ������') ;
define($constpref.'_ADMENU_JOINT','���祤��Ƚ������') ;
define($constpref.'_ADMENU_JOINTCLASS','���祤��ȥ��饹�������') ;
define($constpref.'_ADMENU_MYLANGADMIN','�����������') ;
define($constpref.'_ADMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','�֥�å�����/������������') ;
define($constpref.'_ADMENU_MYPREFERENCES','��������') ;

// blocks
define($constpref.'_BNAME_ASYNC','��Ʊ���ѥ��װ����֥�å�') ;
define($constpref.'_BNAME_SYNC','Ʊ���ѥ��װ����֥�å�') ;

// configs
define($constpref.'_INDEXTOTAL','�⥸�塼��ȥåפ�ɽ������ǿ��إåɥ饤������');
define($constpref.'_INDEXEACH','�⥸�塼��ȥåפ�ɽ������ǿ��إåɥ饤��ˣ��ѥ��פ������ĥ�äƤ�������');
define($constpref.'_INDEXKEEPPIPE','�⥸�塼��ȥåפǤϲ�ǽ�ʸ¤��̤Υѥ���̾��ɽ������');
define($constpref.'_ENTRIESAPIPE','�ġ��Υѥ��ץڡ�����ɽ�����륨��ȥ��');
define($constpref.'_ENTRIESAPAGE','�ƥѥ��פ��ڤ�ȴ������ɽ�����ڡ�����ɽ�����륨��ȥ��');
define($constpref.'_ENTRIESARSS','�ƥѥ��פ�RSS/ATOM�ǽ��Ϥ��륨��ȥ��');
define($constpref.'_ENTRIESSMAP','�����ȥޥå�XML���ϤǤκ��票��ȥ��');
define($constpref.'_ARCB_FETCHED','�ڤ�ȴ����ư������������ʼ������١�����');
define($constpref.'_ARCB_FETCHEDDSC','����ȥ���ڤ�ȴ���Ȥ�����¸���������鲿���Ǻ�����뤫����ꤷ�ޤ�����ư������ʤ�����0����ꤷ�ޤ����ޤ��������Ȥ�ϥ��饤��°�����Ĥ��������ȤϺ������ޤ��󡣤����ƺ����������ڤ�ȴ��������������Ū�˺�����Ƥ���������');
define($constpref.'_INTERNALENC','�������󥳡��ǥ���');
define($constpref.'_FETCHCACHELT','������������å������ (��)');
define($constpref.'_REDIRECTWARN','������URI�Υ�����쥯�ȤˤĤ��Ʒٹ𤹤�');
define($constpref.'_SNP_MAXREDIRS','������URI�κ��������쥯�Ȳ��');
define($constpref.'_SNP_MAXREDIRSDSC','�տޤ��ʤ�������쥯�Ȥ��򤱤뤿��ˤ⡢�������ٱ��Ѥ����ꤷ�Ƥ����顢������0�ˤ��뤳�Ȥ򤪴��ᤷ�ޤ�');
define($constpref.'_SNP_PROXYHOST','���������˷�ͳ����Proxy�Υۥ���̾');
define($constpref.'_SNP_PROXYHOSTDSC','FQDN�ǻ��ꡣProxy�����Ѥ��ʤ����϶���ˤ��Ƥ�������');
define($constpref.'_SNP_PROXYPORT','���������˷�ͳ����Proxy�Υݡ����ֹ�');
define($constpref.'_SNP_PROXYUSER','���������˷�ͳ����Proxy�Υ桼��̾');
define($constpref.'_SNP_PROXYPASS','���������˷�ͳ����Proxy�Υѥ����');
define($constpref.'_SNP_CURLPATH','curl�Υѥ� (�ǥե���Ȥ�/usr/bin/curl)');
define($constpref.'_TIDY_PATH','tidy�Υѥ� (�ǥե���Ȥ�/usr/bin/tidy)');
define($constpref.'_XSLTPROC_PATH','xsltproc�Υѥ� (�ǥե���Ȥ�/usr/bin/xsltproc)');
define($constpref.'_UPING_SERVERS','����Ping������');
define($constpref.'_UPING_SERVERSDSC','http����Ϥޤ�RPC����ɥݥ���Ȥ򣱹Ԥˣ��Ĥ��ĵ��Ҥ��ޤ�<br />URL�κǸ�ˡ����ڡ����Ƕ��ڤä�E�����줿��硢extendedPing���������ޤ���');
define($constpref.'_UPING_SERVERSDEF',"http://blogsearch.google.co.jp/ping/RPC2 E\nhttp://api.my.yahoo.co.jp/RPC2\nhttp://rpc.technorati.com/rpc/ping\nhttp://ping.bloggers.jp/rpc/\nhttp://www.blogpeople.net/servlet/weblogUpdates E");
define($constpref.'_CSS_URI','�⥸�塼����CSS��URI');
define($constpref.'_CSS_URIDSC','���Υ⥸�塼�����Ѥ�CSS�ե������URI�����Хѥ��ޤ������Хѥ��ǻ��ꤷ�ޤ����ǥե���Ȥ�{mod_url}/index.php?page=main_css�Ǥ���');
define($constpref.'_IMAGES_DIR','���᡼���ե�����ǥ��쥯�ȥ�');
define($constpref.'_IMAGES_DIRDSC','���Υ⥸�塼���ѤΥ��᡼������Ǽ���줿�ǥ��쥯�ȥ��⥸�塼��ǥ��쥯�ȥ꤫������Хѥ��ǻ��ꤷ�ޤ����ǥե���Ȥ�images�Ǥ���');
define($constpref.'_COM_DIRNAME','���������礹��d3forum��dirname');
define($constpref.'_COM_FORUM_ID','���������礹��ե��������ֹ�');
define($constpref.'_COM_VIEW','�����������ɽ����ˡ');
define($constpref.'_COM_ORDER','�����������ɽ�����');
define($constpref.'_COM_POSTSNUM','����������Υե�å�ɽ���ˤ��������ɽ�����');
define($constpref.'_BACKEND_PIPE_ID','backend.php �˽��Ϥ���ѥ��פ��ֹ� (0: ̵��)');

}


?>