<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'gnavi' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

define($constpref."_NAME","gnavi");

// A brief description of this module
define($constpref."_DESC","GoogleMap���Ѥ������ꥢ�����ɺ����⥸�塼��");

// Names of blocks for this module (Not all module has blocks)
define( $constpref."_BNAME_RECENT","�Ƕ�β���");
define( $constpref."_BNAME_HITS","�͵�����");
define( $constpref."_BNAME_RANDOM","�ԥå����åײ���");
define( $constpref."_BNAME_RECENT_P","�Ƕ�β���(������)");
define( $constpref."_BNAME_HITS_P","�͵�����(������)");
define( $constpref."_BNAME_MENU","��˥塼");
define( $constpref."_BNAME_ARCHIVE","����������");

// Config Items
define( $constpref."_CFG_PHOTOSPATH" , "�����ե��������¸��ǥ��쥯�ȥ�" ) ;
define( $constpref."_CFG_DESCPHOTOSPATH" , "XOOPS���󥹥ȡ����褫��Υѥ������ʺǽ��'/'��ɬ�ס��Ǹ��'/'�����ס�<br />Unix�ǤϤ��Υǥ��쥯�ȥ�ؤν��°����ON�ˤ��Ʋ�����" ) ;
define( $constpref."_CFG_THUMBSPATH" , "����ͥ���ե��������¸��ǥ��쥯�ȥ�" ) ;
define( $constpref."_CFG_DESCTHUMBSPATH" , "�ֲ����ե��������¸��ǥ��쥯�ȥ�פ�Ʊ���Ǥ�" ) ;
define( $constpref."_CFG_IMAGINGPIPE" , "����������Ԥ碌��ѥå���������" ) ;
define( $constpref."_CFG_DESCIMAGINGPIPE" , "�ۤȤ�ɤ�PHP�Ķ���ɸ��Ū�����Ѳ�ǽ�ʤΤ�GD�Ǥ�����ǽŪ������ޤ�<br />��ǽ�Ǥ����ImageMagick��NetPBM�λ��Ѥ򤪴��ᤷ�ޤ�" ) ;
define( $constpref."_CFG_FORCEGD2" , "����GD2�⡼��" ) ;
define( $constpref."_CFG_DESCFORCEGD2" , "����Ū��GD2�⡼�ɤ�ư����ޤ�<br />������PHP�Ǥ϶���GD2�⡼�ɤǥ���ͥ�������˼��Ԥ��ޤ�<br />���������ѥå������Ȥ���GD�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."_CFG_IMAGICKPATH" , "ImageMagick�μ¹ԥѥ�" ) ;
define( $constpref."_CFG_DESCIMAGICKPATH" , "convert��¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ��ꤷ�ޤ���������Ǥ��ޤ��Ԥ����Ȥ�¿���Ǥ��礦��<br />���������ѥå������Ȥ���ImageMagick�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."_CFG_NETPBMPATH" , "NetPBM�μ¹ԥѥ�" ) ;
define( $constpref."_CFG_DESCNETPBMPATH" , "pnmscale����¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ��ꤷ�ޤ���������Ǥ��ޤ��Ԥ����Ȥ�¿���Ǥ��礦��<br />���������ѥå������Ȥ���NetPBM�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."_CFG_POPULAR" , "'POP'�������󤬤Ĥ������ɬ�פʥҥåȿ�" ) ;
define( $constpref."_CFG_NEWDAYS" , "'new'��'update'��������ɽ�����������" ) ;
define( $constpref."_CFG_NEWPHOTOS" , "�ȥåץڡ����ǿ��������Ȥ���ɽ�������" ) ;
define( $constpref."_CFG_DEFAULTORDER" , "���ƥ���ɽ���ǤΥǥե����ɽ����" ) ;
define( $constpref."_CFG_PERPAGE" , "1�ڡ�����ɽ������������" ) ;
define( $constpref."_CFG_DESCPERPAGE" , "�����ǽ�ʿ����� | �Ƕ��ڤäƲ�����<br />��: 10|20|50|100" ) ;
define( $constpref."_CFG_ALLOWNOIMAGE" , "�����Τʤ���Ƥ���Ĥ���" ) ;
define( $constpref."_CFG_MAKETHUMB" , "����ͥ�����������" ) ;
define( $constpref."_CFG_DESCMAKETHUMB" , "���������ʤ��פ������������פ��ѹ��������ˤϡ��֥���ͥ���κƹ��ۡפ�ɬ�פǤ���" ) ;
define( $constpref."_CFG_THUMBSIZE" , "����ͥ������������(pixel)" ) ;
define( $constpref."_CFG_THUMBRULE" , "����ͥ�������ˡ§" ) ;
define( $constpref."_CFG_WIDTH" , "���������" ) ;
define( $constpref."_CFG_DESCWIDTH" , "�������åץ��ɻ��˼�ưĴ�������ᥤ������κ�������<br />GD�⡼�ɤ�TrueColor�򰷤��ʤ����ˤ�ñ�ʤ륵��������" ) ;
define( $constpref."_CFG_HEIGHT" , "���������" ) ;
define( $constpref."_CFG_DESCHEIGHT" , "��������Ʊ����̣�Ǥ�" ) ;
define( $constpref."_CFG_FSIZE" , "����ե����륵����" ) ;
define( $constpref."_CFG_DESCFSIZE" , "���åץ��ɻ��Υե����륵��������(byte)" ) ;
define( $constpref."_CFG_MIDDLEPIXEL" , "���󥰥�ӥ塼�Ǥκ������������" ) ;
define( $constpref."_CFG_DESCMIDDLEPIXEL" , "��x�⤵ �ǻ��ꤷ�ޤ���<br />���� 480x480��" ) ;
define( $constpref."_CFG_LIQUIDIMG" , "ʣ������ɽ�����ν̾�ɽ��" ) ;
define( $constpref."_CFG_DESCLIQUIDIMG" , "�����������������λ��˾嵭���󥰥�ӥ塼�Ǥκ�������������˹�碌�����줾��β�����̾�ɽ�����ޤ���" ) ;
define( $constpref."_CFG_ADDPOSTS" , "��Ƥ������˥�����ȥ��åפ������ƿ�" ) ;
define( $constpref."_CFG_DESCADDPOSTS" , "�ＱŪ�ˤ�0��1�Ǥ�������ͤ�0�ȸ��ʤ���ޤ�" ) ;
define( $constpref."_CFG_CATONSUBMENU" , "���֥�˥塼�ؤΥȥåץ��ƥ��꡼����Ͽ" ) ;
define( $constpref."_CFG_NAMEORUNAME" , "��Ƽ�̾��ɽ��" ) ;
define( $constpref."_CFG_DESCNAMEORUNAME" , "������̾���ϥ�ɥ�̾�����򤷤Ʋ�����" ) ;
define( $constpref."_CFG_INDEXPAGE" , "�⥸�塼��Υȥåץڡ���" ) ;
define( $constpref."_CFG_VIEWCATTYPE" , "����ɽ����ɽ��������" ) ;
define( $constpref."_CFG_COLSOFTABLEVIEW" , "�ơ��֥�ɽ�����Υ�����" ) ;

define( $constpref."_CFG_SHOWPARENT" , "�ƥ��ƥ���ˤ⵭����ɽ������" ) ;
define( $constpref."_CFG_DESCSHOWPARENT" , "���ƥ���ӥ塼�λ��˥��֥��ƥ���ε�����ɽ���������ͭ���ˤ��Ʋ�������" ) ;

define( $constpref."_CFG_ALLOWEDEXTS" , "���åץ��ɵ��Ĥ���ե������ĥ��" ) ;
define( $constpref."_CFG_DESCALLOWEDEXTS" , "�ե�����γ�ĥ�Ҥ�jpg|jpeg|gif|png �Τ褦�ˡ�'|' �Ƕ��ڤä����Ϥ��Ʋ�������<br />���٤ƾ�ʸ���ǻ��ꤷ���ԥꥪ�ɤ���������ʤ��ǲ�������<br />��̣��Ƚ�äƤ������ʳ��ϡ�php��phtml�ʤɤ��ɲä��ʤ��ǲ�����" ) ;
define( $constpref."_CFG_ALLOWEDMIME" , "���åץ��ɵ��Ĥ���MIME������" ) ;
define( $constpref."_CFG_DESCALLOWEDMIME" , "MIME�����פ�image/gif|image/jpeg|image/png �Τ褦�ˡ�'|' �Ƕ��ڤä����Ϥ��Ʋ�������<br />MIME�����פˤ������å���Ԥ�ʤ����ˤϡ����������ˤ��ޤ�" ) ;

define( $constpref."_CFG_BODY_EDITOR" , "��ʸ�Խ����ǥ���" ) ;
define( $constpref."_CFG_DESCBODY_EDITOR" , "�������¤ǻ��ѤǤ��ޤ������� html/common�ե������˥��ǥ����Υ��åץ��ɤ�ɬ�פǤ���" ) ;
define( $constpref."_CFG_ADDINFO" , "������ι����ɲõ�ǽ��ͭ����" ) ;
define( $constpref."_CFG_DESCADDINFO" , "�����˹��ܤ��ɲäǤ��ޤ������㤨�С������⡧5,000�ߡ�,����������ڡ��������������ξ����" ) ;


define( $constpref."_CFG_USEVOTE" , "��ɼ��ǽ�����Ѥ���" ) ;
define( $constpref."_CFG_DESCUSEVOTE" , "�Ƶ����˥桼������ɾ����Ĥ��뤳�Ȥ��Ǥ��ޤ���ɾ����ǤΥ����ȵ�ǽ��ͭ���ˤʤ�ޤ���" ) ;
define( $constpref."_CFG_USEGMAP" , "GoogleMap��ǽ�����Ѥ���" ) ;
define( $constpref."_CFG_DESCGMAP" , "����ƥ�Ĥ˥ޥå״�����ǽ���ɲä��ޤ����ƥڡ����˰��־�����ɲäǤ��ޤ���" ) ;
define( $constpref."_CFG_GMAPKEY" , "GoogleMapAPI Key" ) ;
define( $constpref."_CFG_DESCGMAPKEY" , "GoogleMap����Ѥ���ݤˤ�GoogleMapAPI Key��ɬ�פˤʤ�ޤ�������URL����key��������Ƥ���������<br /><a href='http://www.google.com/apis/maps/signup.html'>http://www.google.com/apis/maps/signup.html</a>" ) ;
define( $constpref."_CFG_DEFLAT" , "GoogleMap�ν��ɽ��������" ) ;
define( $constpref."_CFG_DESCDEFLAT" , "" ) ;
define( $constpref."_CFG_DEFLNG" , "GoogleMap�ν��ɽ��������" ) ;
define( $constpref."_CFG_DESCDEFLNG" , "" ) ;
define( $constpref."_CFG_DEFZOOM" , "GoogleMap�ν��ɽ����������" ) ;
define( $constpref."_CFG_DESCDEFZOOM" , "" ) ;
define( $constpref."_CFG_DEFMTYPE" , "GoogleMap�ν��ɽ�����Ͽޤμ���" ) ;
define( $constpref."_CFG_DESCDEFMTYPE" , "�����̿����Ϸ��ޤ�����Ǥ��ޤ�������˲����������Υޥåפ�����Ǥ��ޤ���" ) ;
define( $constpref."_ICON_BYLID" , "������˥�����������Ǥ��롣���̾�ϥ��ƥ������" ) ;
define( $constpref."_CFG_USE_RSS" , "�����˳�����������RSS�ե����ɤ�ɽ������" ) ;
define( $constpref."_CFG_DESC_USE_RSS" , "ɽ������ե����ɤο������Ϥ��Ʋ�����<br />���ε�ǽ���ɲä�������ϥڡ�����RSS��󥯤����Ϥ���ƥ����ȥܥå�����ɽ�����졢�����ڡ�����ˤϳ��פ�ɽ������ޤ���(Powerd By <a href='http://code.google.com/intl/ja/apis/ajaxfeeds/'>GoogleAjaxFeedAPI</a>)" ) ;
define( $constpref."_CFG_PE_APPKEY" , "PlaceEngineAPI����Ѥ���" ) ;
define( $constpref."_CFG_DESC_PE_APPKEY" , "PlaceEngine�ϡ�Wifi�Ǹ����Ϥ���ꤹ�륵���ӥ��Ǥ������ε�ǽ��ͭ���ˤ���ˤϲ������ɥ쥹�ǥ��ץꥱ������󥭡���������Ʊ������Ϥ��Ʋ�������<br /><a href='http://www.placeengine.com/appk' target='_blank'>http://www.placeengine.com/appk</a><br />��URL�ι��ܤˤϥ⥸�塼��Υ��ɥ쥹�ޤǵ������Ʋ�����<br />(��:http://xoops.iko-ze.net/modules/gnavi)<br />(Powerd By <a href='http://www.koozyt.com/'>Koozyt</a>)" ) ;

define( $constpref."_CFG_MOBILEMAPSIZE" , "����ü����ɽ������GoogleMap��������widthxHeight��" ) ;
define( $constpref."_CFG_DESCMOBILEMAPSIZE" , "240x180 �Τ褦�����Ϥ��Ʋ�������̤���Ϥξ�������Map��������ޤ���" ) ;
define( $constpref."_CFG_MOBILEAGENT" , "����ü��Ƚ����ʸ���������ɽ����" ) ;
define( $constpref."_CFG_DESCMOBILEAGENT" , "����������Ⱦ��󤫤����ü����Ƚ�̤��뤿�������ɽ���������Ʋ�������<BR>���ε�ǽ�ϻŪ�ʼ����Ǥ���GET�ѥ�᡼���ˡ�agent=mobile�פ���ꤹ��ȥ֥饦���Ƿ��Ӥβ��̤�ɽ�������뤳�Ȥ��Ǥ��ޤ��ʥǥХ��ѡˡ�" ) ;
define( $constpref."_CFG_MOBILEENCORDING" , "���ӥڡ�����ʸ�����󥳡���" ) ;
define( $constpref."_CFG_DESCMOBILEENCORDING" , "���Ӥ˽��Ϥ��륨�󥳡��ɤ���ꤷ�Ʋ����������ܤξ��Ͽ侩 <B>SJIS</B> �Ǥ���" ) ;
define( $constpref."_CFG_MOBILEUSEQRC" , "QR�����ɤ���Ѥ���ʥ�����������" ) ;
define( $constpref."_CFG_DESCMOBILEUSEQRC" , "���ʾ���ͤ����Ϥ���ȵ����˷��Ӥ��ɤ߼�뤿���QR�����ɤ���������ޤ���0��̵���Ȥʤꡢ�����ͤ�QR�����ɤΥ������Ȥʤ�ޤ����ʿ侩�ͤ� <B>3</B> ���� <B>4</B> �Ǥ�����<br />QR�����ɤϡֲ����ե��������¸��ǥ��쥯�ȥ�פǻ��ꤷ���ѥ��ʲ��Ρ�qr�פȤ����ǥ��쥯�ȥ����¸����ޤ���QR�����ɤκ����ϵ����ν��ɽ����������Ԥ��ޤ������Τ��ᡢ�����ǥ��������ѹ��������ϡ�qr�ץǥ��쥯�ȥ��������Ŭ�Ѥ��Ƥ���������" ) ;


define( $constpref.'_COM_DIRNAME','���������礹��d3forum��dirname');
define( $constpref.'_COM_FORUM_ID','���������礹��ե��������ֹ�');
define( $constpref.'_COM_VIEW','�����������ɽ����ˡ');

define( $constpref.'_MAP_DRAW','�ޡ�������GeoXML������');
define( $constpref.'_DESC_MAP_DRAW','�ʿ侩�����������Ͽ�ɽ����KML�����褵���ޤ����������Ť����ʤɤ˻�ƤߤƤ���������¿����ä�ư���ˤʤ�ޤ���');
define( $constpref.'_INCLUDE_KML','���� KML �ե������ɽ��');
define( $constpref.'_DESC_INCLUDE_KML','GoogleEarth��ɽ����ǽ��KML�ե�����(.kml,.kmz)�����Ǥ��ޤ������ξ���Ͼ��ɽ������ޤ���<br />���ԤˤĤ����鷺�ġ�"http://"����Ϥޤ�URL�����Ϥ��Ƥ���������<br />�������<br />http://xoops.iko-ze.net/modules/gnavi/kml.php');




define( $constpref."_OPT_USENAME" , "�ϥ�ɥ�̾" ) ;
define( $constpref."_OPT_USEUNAME" , "������̾" ) ;

define( $constpref."_OPT_CALCFROMWIDTH" , "������ͤ����Ȥ��ơ��⤵��ư�׻�" ) ;
define( $constpref."_OPT_CALCFROMHEIGHT" , "������ͤ�⤵�Ȥ��ơ�����ư�׻�" ) ;
define( $constpref."_OPT_CALCWHINSIDEBOX" , "�����⤵���礭������������ͤˤʤ�褦��ư�׻�" ) ;

define( $constpref."_OPT_VIEWLIST" , "����ʸ�եꥹ��ɽ��" ) ;
define( $constpref."_OPT_VIEWTABLE" , "�ơ��֥�ɽ��" ) ;


// Sub menu titles
define( $constpref."_TEXT_SMNAME1","���");
define( $constpref."_TEXT_SMNAME2","��͵�");
define( $constpref."_TEXT_SMNAME3","�ȥåץ��");
define( $constpref."_TEXT_SMNAME4","��ʬ�����");
define( $constpref."_TEXT_SMNAME5","�Ͽޤ�ɽ��");
define( $constpref."_TEXT_SMNAME6","�����ΰ���");

// Names of admin menu items
define( $constpref."_ADMENU_MYCATEGOLY","���ƥ������");
define( $constpref."_ADMENU_MYICON","�����������");
define( $constpref."_ADMENU_MYPHOTOMANAGER","��������");
define( $constpref."_ADMENU_MYLADMISSION","��Ƥ��줿�����ξ�ǧ");
define( $constpref."_ADMENU_MYGROUPPERM","�ƥ��롼�פθ���");
define( $constpref."_ADMENU_MYCHECKCONFIGS","ư������å���");
define( $constpref."_ADMENU_MYBATCH","���������Ͽ");
define( $constpref."_ADMENU_MYREDOTHUMBS","����ͥ���κƹ���");

define( $constpref.'_ADMENU_MYLANGADMIN' , '�����������' ) ;
define( $constpref.'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' ) ;
define( $constpref.'_ADMENU_MYBLOCKSADMIN' , '�֥�å�����/�⥸�塼�륢����������' ) ;
define( $constpref.'_ADMENU_MYPREFERENCES' , '��������' ) ;

// Text for notifications
define( $constpref.'_GLOBAL', '�⥸�塼������');
define( $constpref.'_GLOBALDSC', '�⥸�塼�����Τˤ��������Υ��ץ����');
define( $constpref.'_CATEGORY', '���ƥ��꡼');
define( $constpref.'_CATEGORYDSC', '������Υ��ƥ��꡼���Ф������Υ��ץ����');
define( $constpref.'_ITEM', '����');
define( $constpref.'_ITEMDSC', 'ɽ����ε������Ф������Υ��ץ����');

define( $constpref.'_NOTIFY_GLOBAL_NEWITEM', '�������');
define( $constpref.'_NOTIFY_GLOBAL_NEWITEMCAP', '��������Ƥ��줿�������Τ���');
define( $constpref.'_NOTIFY_GLOBAL_NEWITEMCONTENTCAP', '��������Ƥ��줿�������Τ���');
define( $constpref.'_NOTIFY_GLOBAL_NEWITEMBJ', '[{X_SITENAME}] {X_MODULE}: ��������Ƥ���ޤ���');

define( $constpref.'_NOTIFY_CATEGORY_NEWITEM', '���ƥ�����ο����');
define( $constpref.'_NOTIFY_CATEGORY_NEWITEMCAP', '���Υ��ƥ���˿�������Ƥ��줿�������Τ���');
define( $constpref.'_NOTIFY_CATEGORY_NEWITEMCONTENTCAP', '���Υ��ƥ���˿�������Ƥ��줿�������Τ���');
define( $constpref.'_NOTIFY_CATEGORY_NEWITEMBJ', '[{X_SITENAME}] {X_MODULE}: ��������Ƥ���ޤ���');

}

?>