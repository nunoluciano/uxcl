<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3diary' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// Module Info

// The name of this module
define($constpref."_DIARY_NAME","D3�������꡼");
define($constpref."_DIARY_DESC","D3�������꡼");

define($constpref."_DIARYLIST","�ǿ�����������");
define($constpref."_FRIENDSDIARY","ͧ�ͤ���������");
define($constpref."_EDIT","�������");
define($constpref."_CATEGORY","���ƥ��꡼");
define($constpref."_COMMENT","�����Ȱ���");
define($constpref."_CONFIG","����������");
define($constpref."_CONFIG_CATEGORY","���ƥ��꡼������");
define($constpref."_YES","�Ϥ�");
define($constpref."_NO","������");
define($constpref."_PHOTOLIST","��������");

// Admin
define($constpref.'_ADMENU_MYLANGADMIN','�����������');
define($constpref.'_ADMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���');
define($constpref.'_ADMENU_MYBLOCKSADMIN','�֥�å�/���´���');
define($constpref.'_ADMENU_IMPORT','����ݡ���');
define($constpref.'_ADMENU_PERMISSION','�ѡ��ߥå�������');

// module config
define($constpref."_MENU_LAYOUT","�����ɥ�˥塼�Υ쥤������");
define($constpref."_MENU_LAYOUTDESC","�������������ʤɤΥ����ɥ�˥塼��ɽ�����");
define($constpref."_MENU_LAYOUT_RIGHT","��¦�˥����ɥ�˥塼��ɽ��");
define($constpref."_MENU_LAYOUT_LEFT","��¦�˥����ɥ�˥塼��ɽ��");
define($constpref."_MENU_LAYOUT_NONE","�����ɥ�˥塼��ɽ�����ʤ��ʥ֥�å�����ѡ�");

define($constpref."_RIGHT_WEIDTH","�����ɥ�˥塼����");
define($constpref."_RIGHT_WEIDTHDESC","�����ɥ�˥塼������pixcelñ�̤����Ϥ��ޤ���<br />�ǥե���Ȥ�140pixcel");

define($constpref."_USENAME","�桼����̾ɽ��");
define($constpref."_USENAMEDESC","�桼����̾ɽ���ˡ�uname�ס�name�פɤ������Ѥ��뤫�����ꤷ�ޤ���<br />xoops�ǥե���Ȥϡ�uname��");
define($constpref."_USENAME_UNAME","��uname�פ����");
define($constpref."_USENAME_NAME","��name�פ����");

define($constpref."_BREADCRUMBS","�ѥ󤯤���ɽ������");
define($constpref."_BREADCRUMBSDESC","�⥸�塼��ڡ��������˥ѥ󤯤���ɽ��������ϡ֤Ϥ��ס�<br/>�ơ��ޤ�xoops_breadcrumbs��������ɽ��������ϡ֤������פ�����");

define($constpref."_PREV_CHARMAX","�ץ�ӥ塼ʸ���κ����");
define($constpref."_PREV_CHARMAXDESC","�֥�å������ɽ���κݤ�ɽ�������<br/>�ץ�ӥ塼ʸ���κ���ʸ����");

define($constpref."_BLK_DNUM","�ꥹ��ɽ���Σ��ڡ�����������");
define($constpref."_BLK_DNUMDESC","�ꥹ��ɽ���������Σ��ڡ������������ɽ�������<br/>���ο��ͤǥڡ���ʬ�䤵��롣");

define($constpref."_PHOTO_MAXSIZE","�̿��κ��祵������KB��");
define($constpref."_PHOTO_MAXSIZEDESC","���åץ��ɤ���̿��κ��祵������<br/>KB�ʥ���Х��ȡˤǻ��ꤷ�Ƥ���������");

define($constpref."_PHOTO_USERESIZE","�̿��ν̾���¸");
define($constpref."_PHOTO_USERESIZEDESC","��Ͽ���줿�̿���ư�̾�������¸�Ǥ��ޤ���<br/>��ư�̾�����Ⱥ����դ�640px�ˤʤ�ޤ���");
define($constpref."_PHOTO_USERESIZE_Y","�̾���¸����");
define($constpref."_PHOTO_USERESIZE_N","�̾���¸���ʤ�");

define($constpref."_PHOTO_THUMBSIZE","�̿��Υ���ͥ��륵����");
define($constpref."_PHOTO_THUMBSIZEDESC","���åץ��ɤ���̿��Υ���ͥ���ʽ̾�ɽ���˥�������<br/>�ʥԥ�����ˤǻ��ꤷ�Ƥ���������");
// define($constpref."_PHOTO_RESIZEMAX","�̿��ν̾����κ��祵����");
// define($constpref."_PHOTO_RESIZEMAXDESC","��Ͽ���줿�̿���ư�̾�����Ȥ��ˡ��ġ����κ��祵����px�ʥԥ�����ˤ���ꤷ�ޤ�");

define($constpref."_PHOTO_MAXPICS","�̿��κ���Ǻܲ�ǽ���");
define($constpref."_PHOTO_MAXPICSDESC","���åץ��ɲ�ǽ�ʼ̿��κ��������ꤷ�Ƥ���������");
define($constpref."_PHOTO_USEINFO","�Ƽ̿����������դ���");
define($constpref."_PHOTO_USEINFODESC","�̿�������ʸ���ղä���������YES�����򤷤Ƥ���������");

define($constpref."_USE_AVATAR","���Х�����ɽ������");
define($constpref."_USE_AVATARDESC","�ƿͥ����ɥС���diarylist�ǥ��Х�����ɽ������������򤷤ޤ���");

define($constpref."_USE_OPEN_CAT","���ƥ��꡼��θ��¡������֥������ON/OFF");
define($constpref."_USE_OPEN_CATDESC","���ƥ��꡼��θ������ꡦ�����֥������桼������������Ĥ����硢ON�����򡣡���öON�����򤷤����OFF���᤹�ˤϡ����桼�����Υ��ƥ��꡼������ᤷ�Ƥ���Ԥ�ɬ�פ�����ޤ���");
define($constpref."_USE_OPEN_CAT_N","���ƥ��꡼��θ��¡������֥����ꡧOFF");
define($constpref."_USE_OPEN_CAT_Y","���ƥ��꡼��θ��¡������֥����ꡧON");
define($constpref."_USE_OPEN_CAT_G","���ƥ��꡼��θ��¡����롼�׻���ޤǲ�ǽ�������֥����ꡧON");
define($constpref."_USE_OPEN_CAT_P","���ƥ��꡼��θ��¡����롼�ס����л���ޤǲ�ǽ�������֥����ꡧON");

define($constpref."_USE_OPEN_ENTRY","������θ��������ON/OFF");
define($constpref."_USE_OPEN_ENTRYDESC","������θ��������桼������������Ĥ����硢ON�����򡡰�öON�����򤷤����OFF���᤹�ˤϡ����桼�����ε������������ᤷ�Ƥ���Ԥ�ɬ�פ�����ޤ���");
define($constpref."_USE_OPEN_ENTRY_N","������θ������ꡧOFF");
define($constpref."_USE_OPEN_ENTRY_Y","������θ������ꡧON");
define($constpref."_USE_OPEN_ENTRY_G","������θ������ꡧ���롼�׻���ޤǲ�ǽ");
define($constpref."_USE_OPEN_ENTRY_P","������θ������ꡧ���롼�ס����л���ޤǲ�ǽ");

define($constpref."_USE_FRIEND","ͧ�͵�ǽ�⥸�塼��Ȥ�Ϣ��ON/OFF");
define($constpref."_USE_FRIENDDESC","�����ϰϤ�ͧ�ͤޤǤȤ���ޤ�뵡ǽ��Ȥ����ɤ���<br/><br/>��xsns��myfriend�⥸�塼��򥤥󥹥ȡ��뤷�Ƥ��ʤ�<br/>���ϡ�ON����ˤ��ʤ��Ǥ���������");
define($constpref."_USE_FRIEND_N","ͧ�͵�ǽ�Ȥ�Ϣ�ȡ�OFF");
define($constpref."_USE_XSNS_Y","xsns�Ȥ�Ϣ�ȡ�ON");
define($constpref."_USE_MYFRIENDS_Y","myfriends�Ȥ�Ϣ�ȡ�ON");

define($constpref."_FRIEND_DIRNAME","ͧ�͵�ǽ�⥸�塼��Υǥ��쥯�ȥ�̾");
define($constpref."_FRIEND_DIRNAMEDESC","ͧ�͵�ǽ�Ȥ�Ϣ�Ȥ�Ԥ���硢ͧ�͵�ǽ�⥸�塼��Υǥ��쥯�ȥ�̾�����Ϥ��Ƥ���������");

define($constpref."_EXCERPTOK","�����ȥ롦������ʬ�ϱ�����ǽ");
define($constpref."_EXCERPTOKDESC","����ñ�̤Ǹ��¤Τʤ������Ԥˡ��ֲ��񤭡װʳ���<br/>���������ȥ롦������ʬ�򥪡��ץ�ˤ����ϰϤ����򤷤ޤ���");
define($constpref."_EXCERPTOK_NOUSE","�������¤�̵�������ϥ����ȥ롦�����ɽ�����ʤ�");
//define($constpref."_EXCERPTOK_BYPERSON","�ƿͤ��������Τ�����˰Ѿ�����");
define($constpref."_EXCERPTOK_FORMEMBER","��������С��ޤǥ����ץ�ˤ���");
define($constpref."_EXCERPTOK_FORGUEST","�����Ȥޤǥ����ץ�ˤ���");

define($constpref."_DISP_EXCERPTCOM","�����ȥ롦������ʬ�Τ߱�����ǽ�ξ��Υ�����ɽ��");
define($constpref."_DISP_EXCERPTCOMDESC","�����Ȥ�ɽ��������ϡ֤Ϥ��ס�<br/>��ɽ���ˤ��Ƥ������ϡ֤������פ�����");

define($constpref."_USE_TAG","������ǽ��ON/OFF");
define($constpref."_USE_TAGDESC","������ǽ����Ѥ����硢�������饦�ɤ�ɽ������ڡ��������򤷤Ƥ���������");
define($constpref."_USE_TAG_N","������ǽ��OFF");
define($constpref."_USE_TAG_INDEXONLY","�������饦�ɤ�ƿͤ�INDEX�ڡ�����ɽ��");
define($constpref."_USE_TAG_ALSODIARYLIST","�������饦�ɤ�ƿͤ�INDEX�ڡ��������桼��������LIST�ڡ�����ɽ��");
define($constpref."_USE_TAG_BLOCK","�������饦�ɤ�ᥤ��ڡ�����ɽ�����ʤ����֥�å�ɽ������ѡ�");

define($constpref."_BODY_EDITOR","��ʸ�Խ����ꥢ�μ���");
define($constpref."_BODY_EDITORDSC","simple��BBcode���������ɽ�����ޤ��󡣡�BBcode���Ϥ�����ϡ���xoopsdhtml�פ������Ǥ���");
define($constpref."_BODY_HTMLEDITOR","��ʸHTML���ǥ����ܥ����ɽ��");
define($constpref."_BODY_HTMLEDITORDSC","HTML�ε��Ĥ�֥ѡ��ߥå��������ץ��ֲ��̤ǹԤ����������common/FCKeditor�פ����򤹤�ȡ�FCKeditor�ܥ���ɽ������ޤ���");
define($constpref."_HTMLPR_EXCEPT","HTMLPurifier�ˤ�붯���񤭴����򤷤ʤ����롼��");
define($constpref."_HTMLPR_EXCEPTDSC","�����˻��ꤵ��ơ֤��ʤ��ץ��롼�פˤ��HTML��Ƥϡ�Protector3.14�ʾ����°���Ƥ���HTMLPurifier�ˤ�äƶ���Ū��������̵�Ǥ�HTML�˽񤭴������ޤ�����������HTMLPurifier���Ρ�PHP�С������5�ʾ�Ǥʤ��ȵ�ǽ���ޤ���");
define($constpref."_GTICKET_SET_TIME","���������ե�����Υ����åȥ����ॢ���Ȼ���(��)");
define($constpref."_GTICKET_SET_TIMEDSC","�ե������ɽ�����Ƥ��饿���ॢ���Ȥˤʤ�ޤǤλ������ꡣ<br />�����ॢ���ȤˤʤäƤ�������������ƤǤ��ޤ���");

define($constpref."_USE_UPDATEPING","����ping��������" );
define($constpref."_USE_UPDATEPING_DSC","����ping�����ε��Ĥ���ꤷ�ޤ���" );
define($constpref."_UPDATEPING","����ping�����С�" );
define($constpref."_UPDATEPING_DSC","����ping�����С�����ꤷ�ޤ������ԤǶ��ڤ�ޤ���" );
define($constpref."_UPDATEPING_SERVERS","http://ping.rss.drecom.jp/\nhttp://blog.goo.ne.jp/XMLRPC" );
define($constpref."_ENC_FROM" , "RSS�ե����ɤؤ��Ѵ��Ѥ��������󥳡���");
define($constpref."_ENC_FROMDSC" , "�̾��'default'��OK�Ǥ�����RSS�ե����ɤ�ʸ������������ϡ�'xoops_chrset'��'auto'�򤪻����������");
define($constpref.'_PERM_CLASS' , '�������½������饹̾');
define($constpref.'_PERM_CLASSDSC' , '�������½����򥪡��С��饤�ɤ��������˻��ꡣ�ǥե���Ȥ�d3diaryPermission');

define($constpref.'_USE_MAILPOST' , '�᡼��ˤ����Ƥ��ǽ�ˤ���');
define($constpref.'_USE_MAILPOSTDSC' , '�᡼��ˤ����Ƥ��ǽ�ˤ�����ϡ�yes�פ����򤷡��ѡ��ߥå����ǥ��롼�פ˵��Ĥ�Ϳ���ޤ���');
define($constpref."_POP3_SERVER","�����᡼�륵����");
define($constpref."_POP3_SERVER_DESC","�����᡼���POP3������̾");
define($constpref."_POP3_PORT","�����ݡ����ֹ�");
define($constpref."_POP3_PORT_DESC","pop3�����ФϤ����Ƥ�110�Ǥ����������Ф˹�碌�Ƥ���������");
define($constpref."_POP3_APOP","APOP�Ź沽ǧ�ڤ���Ѥ���");
define($constpref."_POP3_APOP_DESC","APOP�Ź沽ǧ�ڤ���Ѥ��뤫�ɤ����������Ф�����˹�碌�Ƥ���������");
define($constpref."_POST_EMAIL_ADDRESS","������ѥ᡼�륢�������ID");
define($constpref."_POST_EMAIL_ADDRESS_DESC","������ѤΥ᡼�륢�������ID�����ꤷ�Ʋ�������");
define($constpref."_POST_EMAIL_PASSWORD","������ѥ᡼�륢�ɥ쥹�Υѥ����");
define($constpref."_POST_EMAIL_PASSWORD_DESC","������ѥ᡼�륢�ɥ쥹�Υѥ���ɤ����ꤷ�Ʋ�������");
define($constpref."_POST_EMAIL_FULLADD","�᡼�������襢�ɥ쥹");
define($constpref."_POST_EMAIL_FULLADDDSC","������ѤΥ᡼�������襢�ɥ쥹�������ڡ����ؤ�ɽ���Ѥǡ�����ˤϻȤ��ޤ���");
define($constpref."_POST_DETECT_ORDER","�᡼��ʸ���󥨥󥳡��ɸ��н����");
define($constpref."_POST_DETECT_ORDERDSC","�᡼��ʸ���󥨥󥳡��ɤθ��н����ꤷ�ޤ���<br />�����'auto'���̣���������ʸ�����������硢'ISO-2022-JP, UTF-8, UTF-7, ASCII, EUC-JP, JIS, SJIS, eucJP-win, SJIS-win'���椫����󤷤Ƥߤޤ���<br />�㡧'ISO-2022-JP, UTF-8, JIS, EUC-JP, eucJP-win, SJIS'");

define($constpref."_USE_SIMPLECOMMENT","�����Ȥ�ɽ���⡼��");
define($constpref."_USE_SIMPLECOMMENTDESC","�����XOOPSɸ��Υ����Ȥ�Ȥ�����ˡ�<br/>�ʰ�Ū�ʥ����ȥե������Ȥ����Ȥ��Ǥ��ޤ���<br/><br/>���ʰץե�����ξ�硢ƿ̾��ƤϤǤ��ޤ���");
define($constpref."_USE_SIMPLECOMMENT_Y","�ʰ�Ū�ʥ����ȥ⡼�ɤ�Ȥ�");
define($constpref."_USE_SIMPLECOMMENT_N","XOOPS��ɸ�ॳ���ȵ�ǽ��Ȥ�");

//d3comment integration
define($constpref."_COM_DIRNAME","���������礹��d3forum��dirname");
define($constpref."_COM_DIRNAMEDSC","d3forum�Υ��������絡ǽ����Ѥ������<br/>�ե�������html¦�ǥ��쥯�ȥ�̾����ꤷ�ޤ���<br/>xoops�����Ȥ���Ѥ�����䥳���ȵ�ǽ��̵���ˤ�����϶���Ǥ���");
define($constpref."_COM_FORUMID","���������礹��ե��������ֹ�");
define($constpref."_COM_FORUMIDDSC","��������������򤷤���硢forum_id��ɬ�����ꤷ�Ƥ���������");
define($constpref."_COM_ORDER","�����������ɽ�����");
define($constpref."_COM_ORDERDSC","��������������򤷤����Ρ������Ȥο������硿�Ť�������Ǥ��ޤ���");
define($constpref."_COM_VIEW","�����������ɽ����ˡ");
define($constpref."_COM_VIEWDSC","�ե�å�ɽ��������å�ɽ���������򤷤ޤ���");
define($constpref."_COM_POSTSNUM","����������Υե�å�ɽ���ˤ��������ɽ�����");
define($constpref."_COM_ANCHOR","����������ε������󥫡�");
define($constpref."_COM_ANCHORDSC","�������󥫡��Υǥե���Ȥϡ�post_path�פǤ���<br />�����ȥ���åɤ�ʬ�䤷�Ƥ��Ϣ�����ݤƤ��post_id�פ�Ȥ���硢<br />d3forum¦�Υƥ�ץ졼�Ȥ��Խ������������ѹ����ޤ��������Ϣư�Ϥ��ޤ��󡣡�");
define($constpref."_USE_COM_ANCHOR_UNIQUEPATH","d3forum�ǥե���ȤΡ�post_path�פ�Ȥ�");
define($constpref."_USE_COM_ANCHOR_POSTNUM","��post_id�פ�Ȥ�");

//notifications
define($constpref."_GLOBAL_NOTIFY","���Τ�����");
define($constpref."_GLOBAL_NOTIFYDSC","���Τ�����");
define($constpref."_BLOGGER_NOTIFY","������С�������");
define($constpref."_BLOGGER_NOTIFYDSC","������С�������");

define($constpref."_GLOBAL_NEWENTRY_NOTIFY","�����ο������");
define($constpref."_GLOBAL_NEWENTRY_NOTIFYCAP","�������Τǿ�����Ƥ����ä������Τ��ޤ�");
define($constpref."_GLOBAL_NEWENTRY_NOTIFYDSC","�������Τǿ�����Ƥ����ä������Τ���");
define($constpref."_GLOBAL_NEWENTRY_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE}:�����������");

define($constpref."_BLOGGER_NEWENTRY_NOTIFY","������С������������");
define($constpref."_BLOGGER_NEWENTRY_NOTIFYCAP","���οͤ������ǿ�����Ƥ����ä������Τ��ޤ�");
define($constpref."_BLOGGER_NEWENTRY_NOTIFYDSC","���οͤ������ǿ�����Ƥ����ä������Τ���");
define($constpref."_BLOGGER_NEWENTRY_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE}:�����������");

define($constpref."_BLOGGER_COMMENT_NOTIFY","������С��������ؤΥ�����[d3�������������]");
define($constpref."_BLOGGER_COMMENT_NOTIFYCAP","���οͤ������ؤΥ����Ȥ����ä������Τ��ޤ�");
define($constpref."_BLOGGER_COMMENT_NOTIFYDSC","���οͤ������ؤΥ����Ȥ����ä������Τ���");
define($constpref."_BLOGGER_COMMENT_NOTIFYSBJ","[{X_SITENAME}] {X_MODULE}:����������");

define($constpref."_ENTRY_NOTIFY","���������ʵ����ˤؤΥ�����");
define($constpref."_ENTRY_NOTIFYDSC","���������ʵ����ˤؤΥ����Ȥ����ä�������");

// Block
define($constpref."_BLOCK_NEWENTRY","�����������֥�");
define($constpref."_BLOCK_NEWENTRYDSC","���女��ƥ�� - �������֥�");
define($constpref."_BLOCK_BLOGGER","������Ƽԥꥹ��");
define($constpref."_BLOCK_BLOGGERDSC","������Ƽԥꥹ��");
define($constpref."_BLOCK_D3COMPOSTS","������������ƥꥹ��");
define($constpref."_BLOCK_D3COMPOSTSDSC","d3������������Τ�ͭ���Ǥ�");
define($constpref."_BLOCK_D3COMTOPICS","���������ȥȥԥå�");
define($constpref."_BLOCK_D3COMTOPICSDSC","d3������������Τ�ͭ���Ǥ�");
define($constpref."_BLOCK_PERSON","��Ƽ�");
define($constpref."_BLOCK_PERSONDSC","������Ƽԥ֥�å�");
define($constpref."_BLOCK_CALENDAR","��������");
define($constpref."_BLOCK_CALENDARDSC","�����Υ��������֥�å�");
define($constpref."_BLOCK_CATEGORY","���ƥ��꡼");
define($constpref."_BLOCK_CATEGORYDSC","�����Υ��ƥ���֥�å�");
define($constpref."_BLOCK_ENTRY","��������");
define($constpref."_BLOCK_ENTRYDSC","�����ο���֥�å�");
define($constpref."_BLOCK_COMMENT","���女����");
define($constpref."_BLOCK_COMMENTDSC","���������Ȥο���֥�å�");
define($constpref."_BLOCK_MLIST","��ɽ��");
define($constpref."_BLOCK_MLISTDSC","������ɽ���֥�å�");
define($constpref."_BLOCK_FRIENDS","ͧ�ͥꥹ��");
define($constpref."_BLOCK_FRIENDSDSC","����ͧ�ͥꥹ�ȥ֥�å�");
define($constpref."_BLOCK_TAGCROUD","�������饦��");
define($constpref."_BLOCK_TAGCROUDDSC","�������饦�ɥ֥�å�");
define($constpref."_BLOCK_PHOTOS","����ɽ��");
define($constpref."_BLOCK_PHOTOSDSC","����ɽ���֥�å�");

//others
define($constpref."_BLOGGER","���������");

}
?>
