<?php
// Module Info

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'bulletin' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

// a flag for this language file has already been read or not.
define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref.'_NAME','�˥塼��');

// A brief description of this module
define($constpref.'_DESC','�桼������ͳ�˥����ȤǤ��롢����å���ɥå����Υ˥塼�����������ƥ���ۤ��ޤ�');

// Names of blocks for this module (Not all module has blocks)
define($constpref.'_BNAME1','�˥塼�����ƥ���');
define($constpref.'_BDESC1','');
define($constpref.'_BNAME2','�����Υȥåץ˥塼��');
define($constpref.'_BDESC2','');
define($constpref.'_BNAME3','��������');
define($constpref.'_BDESC3','');
define($constpref.'_BNAME4','�ǿ��˥塼��');
define($constpref.'_BDESC4','');
define($constpref.'_BNAME5','���ƥ����̺ǿ��˥塼��');
define($constpref.'_BDESC5','');
define($constpref.'_BNAME6','�֥�ƥ����女����');
define($constpref.'_BDESC6','');

// Sub menu
define($constpref.'_SMNAME1','�˥塼�����');
define($constpref.'_SMNAME2','����������');

// Admin
define($constpref.'_ADMENU2','���ƥ������');
define($constpref.'_ADMENU3','�������˥塼�����������');
define($constpref.'_ADMENU4','��Ƹ��¤δ���');
define($constpref.'_ADMENU5','�˥塼�������δ���');
define($constpref.'_ADMENU7','news���饤��ݡ���');
define($constpref.'_ADMENU_MYLANGADMIN','�����������');
define($constpref.'_ADMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���');
define($constpref.'_ADMENU_MYBLOCKSADMIN','�֥�å�/���´���');

// Title of config items
define($constpref.'_CONFIG1', '�ȥåץڡ����˷Ǻܤ��뵭����');
define($constpref.'_CONFIG1_D', '�ȥåץڡ�����ɽ�����뵭���ο�����ꤷ�Ƥ���������');
define($constpref.'_CONFIG2', '�ʥӥ��������ܥå�����ɽ������');
define($constpref.'_CONFIG2_D', '���ƥ�������򤹤�ʥӥ��������ܥå����򵭻��ξ�����ɽ������ˤϡ֤Ϥ��פ����򤷤Ƥ���������');
define($constpref.'_CONFIG3','��ơ��Խ��ѥƥ����ȥ��ꥢ�ι⤵');
define($constpref.'_CONFIG3_D', 'submit.php�ڡ����Υƥ����ȥ��ꥢ�ιԿ������ꤷ�ޤ���');
define($constpref.'_CONFIG4','��ơ��Խ��ѥƥ����ȥ��ꥢ����');
define($constpref.'_CONFIG4_D', 'submit.php�ڡ����Υƥ����ȥ��ꥢ�Υ����������ꤷ�ޤ���');
define($constpref.'_CONFIG5','���ա������ν�');
define($constpref.'_CONFIG5_D', 'ʸ���ν񼰤�PHP��date�ؿ���XOOPS��formatTimestamp�ؿ��򻲾Ȥ��Ƥ���������');
define($constpref.'_CONFIG6','��Ƥ�桼��������ƿ���ȿ��');
define($constpref.'_CONFIG6_D', 'submit.php������Ƥ��줿��������ǧ���줿�ݤˡ����Υ桼���Ρ���ƿ��פ˲û����ޤ���');
define($constpref.'_CONFIG7','���ƥ��ꥢ�����󤬤���ǥ��쥯�ȥ�Υѥ�');
define($constpref.'_CONFIG7_D', '���Хѥ��ǻ��ꤷ�ޤ���');
define($constpref.'_CONFIG8','�����ڡ����β�����URL');
define($constpref.'_CONFIG8_D', '�����ѥڡ�����ɽ��������������URL�ǻ��ꤷ�ޤ���');
define($constpref.'_CONFIG9','����̾�򥵥��ȤΥ����ȥ�ˤ���');
define($constpref.'_CONFIG9_D', '��������̾�򥵥��ȤΥ����ȥ���֤������ޤ���SEO���̤�ͭ�����ȸ����Ƥ��ޤ���');
define($constpref.'_CONFIG10','xoops_module_header��RSS��URL��assign����');
define($constpref.'_CONFIG10_D', '');
// 1.01 added
define($constpref.'_CONFIG11','�ְ�������ץ��������ɽ������');
define($constpref.'_CONFIG11_D', '');
define($constpref.'_CONFIG12','��ͧã���Τ餻��ץ��������ɽ������');
define($constpref.'_CONFIG12_D', '');
define($constpref.'_CONFIG13','Tell A Friend�⥸�塼������Ѥ���');
define($constpref.'_CONFIG13_D', '');
define($constpref.'_CONFIG14','RSS�Υ�󥯤�ɽ������');
define($constpref.'_CONFIG14_D', '');
define($constpref.'_CONFIG145','RSS��backend.php�ˤ�feed����(XCL�Τ�)');
define($constpref.'_CONFIG145_D', '');
// 2.00 added
define($constpref.'_CONFIG15','��Ϣ������ǽ��ͭ���ˤ���');
define($constpref.'_CONFIG15_D', '');
define($constpref.'_CONFIG16','���ƥ���κǿ�������ɽ������');
define($constpref.'_CONFIG16_D', '�Ƶ����β���Ʊ�쥫�ƥ���κǿ�����������ɽ������ޤ���');
define($constpref.'_CONFIG17','���ƥ���κǿ������ε�����');
define($constpref.'_CONFIG17_D', '�Ƶ����β���ɽ������Ʊ�쥫�ƥ���κǿ����������ε���������ꤷ�ޤ���');
define($constpref.'_CONFIG18','���ƥ���Υѥ󤯤��ꥹ�Ȥ�ɽ������');
define($constpref.'_CONFIG18_D', '');
define($constpref.'_CONFIG19','common/fckeditor�����Ѥ���');
define($constpref.'_CONFIG19_D', 'HTML�����Ĥ���Ƥ����Խ��Ԥˤ�FCKeditor on XOOPS�����ѤǤ���褦�ˤ��ޤ���');

define($constpref.'_COM_DIRNAME','���������礹��d3forum��dirname');
define($constpref.'_COM_FORUM_ID','���������礹��ե��������ֹ�');
define($constpref.'_COM_VIEW','�����������ɽ����ˡ');
define($constpref.'_COM_ORDER','�����������ɽ�����');
define($constpref.'_COM_POSTSNUM','����������Υե�å�ɽ���ˤ��������ɽ�����');

// by yoshis
define( $constpref.'_ADMENU_CATEGORYACCESS' , '���ƥ��꡼������������' ) ;
define($constpref.'_IMAGES_DIR','���᡼���ե�����ǥ��쥯�ȥ�');
define($constpref.'_IMAGES_DIRDSC','���Υ⥸�塼���ѤΥ��᡼������Ǽ���줿�ǥ��쥯�ȥ��⥸�塼��ǥ��쥯�ȥ꤫������Хѥ��ǻ��ꤷ�ޤ����ǥե���Ȥ�images�Ǥ���');

// Text for notifications
define($constpref.'_GLOBAL_NOTIFY', '�⥸�塼������');
define($constpref.'_GLOBAL_NOTIFYDSC', '�˥塼���⥸�塼�����Τˤ��������Υ��ץ����');

define($constpref.'_STORY_NOTIFY', 'ɽ����Υ˥塼������');
define($constpref.'_STORY_NOTIFYDSC', 'ɽ����Υ˥塼���������Ф������Υ��ץ����');

define($constpref.'_GLOBAL_NEWCATEGORY_NOTIFY', '�������ƥ���');
define($constpref.'_GLOBAL_NEWCATEGORY_NOTIFYCAP', '�������ƥ��꤬�������줿�������Τ���');
define($constpref.'_GLOBAL_NEWCATEGORY_NOTIFYDSC', '�������ƥ��꤬�������줿�������Τ���');
define($constpref.'_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: �������ƥ��꤬��������ޤ���');

define($constpref.'_GLOBAL_STORYSUBMIT_NOTIFY', '�����˥塼����ƾ�ǧ�Ԥ�');
define($constpref.'_GLOBAL_STORYSUBMIT_NOTIFYCAP', '������ǧ�Ԥ��˥塼������Ƥ����ä��������Τ���');
define($constpref.'_GLOBAL_STORYSUBMIT_NOTIFYDSC', '������ǧ�Ԥ��˥塼������Ƥ����ä��������Τ���');
define($constpref.'_GLOBAL_STORYSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ������ǧ�Ԥ��˥塼������Ƥ�����ޤ���');

define($constpref.'_GLOBAL_NEWSTORY_NOTIFY', '�����˥塼�������Ǻ�');
define($constpref.'_GLOBAL_NEWSTORY_NOTIFYCAP', '�����˥塼���������Ǻܤ��줿�������Τ���');
define($constpref.'_GLOBAL_NEWSTORY_NOTIFYDSC', '�����˥塼���������Ǻܤ��줿�������Τ���');
define($constpref.'_GLOBAL_NEWSTORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: �����˥塼�����Ǻܤ���ޤ���');

define($constpref.'_STORY_APPROVE_NOTIFY', '�˥塼�������ξ�ǧ');
define($constpref.'_STORY_APPROVE_NOTIFYCAP', '���Υ˥塼����������ǧ���줿�������Τ���');
define($constpref.'_STORY_APPROVE_NOTIFYDSC', '���Υ˥塼����������ǧ���줿�������Τ���');
define($constpref.'_STORY_APPROVE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: �˥塼����������ǧ����ޤ���');

// added 2.01
define($constpref.'_NOTIFY5_TITLE', '�������������');
define($constpref.'_NOTIFY5_CAPTION', '���ε����˥����Ȥ��Ĥ���������Τ���');
define($constpref.'_NOTIFY5_DESC', '���ε����˥����Ȥ��Ĥ���������Τ���');
define($constpref.'_NOTIFY5_SUBJECT', '[{X_SITENAME}] {X_MODULE}: �����Ȥ���Ƥ�����ޤ���');

}
?>