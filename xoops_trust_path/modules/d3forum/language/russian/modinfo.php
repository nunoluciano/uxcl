<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3forum' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {






// Appended by Xoops Language Checker -GIJOE- in 2007-09-28 15:55:31
define($constpref.'_DEFAULT_OPTIONS','Default checked in post form');
define($constpref.'_DEFAULT_OPTIONSDSC','List checked options separated by comma(,).<br />eg) smiley,xcode,br,number_entity<br />You can add these options: special_entity html attachsig u2t_marked');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-27 16:50:40
define($constpref.'_BODY_EDITOR','Body Editor');
define($constpref.'_BODY_EDITORDSC','WYSIWYG editor will be enabled under only forums allowing HTML. With forums escaping HTML specialchars, xoopsdhtml will be displayed automatically.');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-26 17:55:46
define($constpref.'_ADMENU_POSTHISTORIES','Histories');

// Appended by Xoops Language Checker -GIJOE- in 2007-05-18 17:34:37
define($constpref.'_ADMENU_MYLANGADMIN','Languages');
define($constpref.'_SHOW_BREADCRUMBS','Display breadcrumbs');
define($constpref.'_ANTISPAM_GROUPS','Groups should be checked anti-SPAM');
define($constpref.'_ANTISPAM_GROUPSDSC','Usually set all blank.');
define($constpref.'_ANTISPAM_CLASS','Class name of anti-SPAM');
define($constpref.'_ANTISPAM_CLASSDSC','Default value is "default". If you disable anti-SPAM against guests even, set it blank');

// Appended by Xoops Language Checker -GIJOE- in 2007-03-26 11:39:16
define($constpref.'_ADMENU_MYTPLSADMIN','Templates');
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocks/Permissions');
define($constpref.'_ADMENU_MYPREFERENCES','Preferences');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","�����");

// A brief description of this module
define($constpref."_DESC","������ ������");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME_LIST_TOPICS","����");
define($constpref."_BDESC_LIST_TOPICS","��� ������������ ����. �� ������ ���������� ��������� ��� �����������.");
define($constpref."_BNAME_LIST_POSTS","��������");
define($constpref."_BNAME_LIST_FORUMS","������");

define($constpref.'_ADMENU_CATEGORYACCESS','����� ���������');
define($constpref.'_ADMENU_FORUMACCESS','����� �������');
define($constpref.'_ADMENU_ADVANCEDADMIN','����. ���.');

// configurations
define($constpref.'_TOP_MESSAGE','�������� � ��������� ������');
define($constpref.'_TOP_MESSAGEDEFAULT','<h1 class="d3f_title">������</h1><p class="d3f_welcome">����� ���������� � ��������� ���������, �������� ��������� � �����, ������� ������ ��������, �� ������ �����.</p>');
define($constpref.'_ALLOW_HTML','��������� HTML');
define($constpref.'_ALLOW_HTMLDSC','�� ���������� � ���� ����� � ��������������. ������� ���� ����� ����� ��������������� ���� ����������� ��� �������������� ����� ������� � �������� ��������.');
define($constpref.'_ALLOW_TEXTIMG','��������� ����������� ������� �������� � ����������');
define($constpref.'_ALLOW_TEXTIMGDSC','��������� ������ ���� ����� ��������������� ������ ������������ ��� ����, ����� ������ ip-����� ��� �� ����������� ������ ������.');
define($constpref.'_ALLOW_SIG','��������� �������');
define($constpref.'_ALLOW_SIGDSC','');
define($constpref.'_ALLOW_SIGIMG','��������� ����������� ������� �������� � �������');
define($constpref.'_ALLOW_SIGIMGDSC','��������� ������ ���� ����� ��������������� ������ ������������ ��� ����, ����� ������ ip-����� ��� �� ����������� ������ ������.');
define($constpref.'_USE_VOTE','������������ �����������');
define($constpref.'_USE_SOLVED','������������ ����������� ������ ����');
define($constpref.'_ALLOW_MARK','��������� �������� ����');
define($constpref.'_ALLOW_HIDEUID','��������� ������������������ ������������� ��������� ��������� ��������');
define($constpref.'_POSTS_PER_TOPIC','������������ ���������� ��������� � ����');
define($constpref.'_POSTS_PER_TOPICDSC','');
define($constpref.'_HOT_THRESHOLD','����� ��� ������� ���');
define($constpref.'_HOT_THRESHOLDDSC','');
define($constpref.'_TOPICS_PER_PAGE','���������� ��� �� �������� ��� ��������� ������');
define($constpref.'_TOPICS_PER_PAGEDSC','');
define($constpref.'_VIEWALLBREAK','���������� ��� �� �������� ��� ��������� �������������� �������');
define($constpref.'_VIEWALLBREAKDSC','');
define($constpref.'_SELFEDITLIMIT','��������� �������� ����������������� �������������� (���)');
define($constpref.'_SELFEDITLIMITDSC','����� ��������� ������������ ������������� ����������� ��������� ���������� plus value as seconds. ����� ��������� - �������� ��� 0.');
define($constpref.'_SELFDELLIMIT','��������� �������� ��� ����������������� �������� (���)');
define($constpref.'_SELFDELLIMITDSC','����� ��������� ������������� ������� ����������� ��������� ���������� plus value as seconds. ����� ��������� - ���������� 0. � ����� ������ ����� ����������� ��������� �� ����� ���� �������.');
define($constpref.'_CSS_URI','URI ��� CSS ������� ������');
define($constpref.'_CSS_URIDSC','����� ������������ ������������� ��� ���������� ����. �� ���������: index.css');
define($constpref.'_IMAGES_DIR','������� ��� ������ ��������');
define($constpref.'_IMAGES_DIRDSC','��������� ������������� ���� � ���������� ������. �� ���������: images');
define($constpref.'_ANONYMOUS_NAME','��� ���������� ������������');
define($constpref.'_ANONYMOUS_NAMEDSC','');
define($constpref.'_ICON_MEANINGS','�������� ������');
define($constpref.'_ICON_MEANINGSDSC','������� �������������� �������� ������. ������ �������� ������ ���� ��������� �������� (|). ������ �������� ������������� ����� "posticon0.gif".');
define($constpref.'_ICON_MEANINGSDEF','���|�����|����������|��������|�����|������|������|������');
define($constpref.'_GUESTVOTE_IVL','����������� ���������� ��������������');
define($constpref.'_GUESTVOTE_IVLDSC','���������� ��� �������� � 0, ����� ��������� ���������� ��������� �������������. ������ ����� � ���� ���� �������� ����� (� ��������), �������� �������� ��������� ����������� � ����� �� IP.');



// Notify Categories
define($constpref.'_NOTCAT_TOPIC', '������� ����'); 
define($constpref.'_NOTCAT_TOPICDSC', '����������� ��� ������ ����');
define($constpref.'_NOTCAT_FORUM', '������� �����'); 
define($constpref.'_NOTCAT_FORUMDSC', '����������� ��� ������� ������');
define($constpref.'_NOTCAT_CAT', '������� ���������');
define($constpref.'_NOTCAT_CATDSC', '����������� ������ ���������');
define($constpref.'_NOTCAT_GLOBAL', '������� ������');
define($constpref.'_NOTCAT_GLOBALDSC', '����������� ������� ������');

// Each Notifications
define($constpref.'_NOTIFY_TOPIC_NEWPOST', '����� ��������� � ����');
define($constpref.'_NOTIFY_TOPIC_NEWPOSTCAP', '���������� ���� � ���� ����� ���������� � ������ ����');
define($constpref.'_NOTIFY_TOPIC_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{TOPIC_TITLE} ����� ��������� � ����');

define($constpref.'_NOTIFY_FORUM_NEWPOST', '����� ��������� � ������');
define($constpref.'_NOTIFY_FORUM_NEWPOSTCAP', '���������� ���� � ���� ����� ���������� � ������ ������.');
define($constpref.'_NOTIFY_FORUM_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} ����� ��������� � ������');

define($constpref.'_NOTIFY_FORUM_NEWTOPIC', '����� ���� � ������');
define($constpref.'_NOTIFY_FORUM_NEWTOPICCAP', '���������� ���� � ���� ����� ����� � ������ ������.');
define($constpref.'_NOTIFY_FORUM_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{FORUM_TITLE} ����� ���� � ������');

define($constpref.'_NOTIFY_CAT_NEWPOST', '����� ��������� � ���������');
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP', '���������� ���� � ���� ����� ���������� � ���������.');
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} ����� ��������� � ���������');

define($constpref.'_NOTIFY_CAT_NEWTOPIC', '����� ���� � ���������');
define($constpref.'_NOTIFY_CAT_NEWTOPICCAP', '���������� ���� � ���� ����� ����� � ������ ���������.');
define($constpref.'_NOTIFY_CAT_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} ����� ���� � ���������');

define($constpref.'_NOTIFY_CAT_NEWFORUM', '����� ����� � ���������');
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP', '���������� ���� � ���� ����� ������� � ������ ���������.');
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} ����� ����� � ���������');

define($constpref.'_NOTIFY_GLOBAL_NEWPOST', '����� ��������� (���������)');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP', '��������� ���� � ����� ����� ����������.');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}: ����� ���������');

define($constpref.'_NOTIFY_GLOBAL_NEWTOPIC', '����� ���� (���������)');
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICCAP', '��������� ���� � ����� ����� �����.');
define($constpref.'_NOTIFY_GLOBAL_NEWTOPICSBJ', '[{X_SITENAME}] {X_MODULE}: ����� ����');

define($constpref.'_NOTIFY_GLOBAL_NEWFORUM', '����� ����� (���������)');
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMCAP', '��������� ���� � ����� ����� �������.');
define($constpref.'_NOTIFY_GLOBAL_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}: ����� �����');

define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULL', '����� ��������� (������ �����)');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLCAP', '��������� ���� � ����� ����� ���������� (������� ������ ����� � �����������).');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTFULLSBJ', '[{X_SITENAME}] {POST_TITLE}');
define($constpref.'_NOTIFY_GLOBAL_WAITING', '����� ��������');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP', '��������� ���� � ����� ����������, ��������� ���������. ������ ��� ���������������');
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ', '[{X_SITENAME}] {X_MODULE}: ������� ���������');

}

?>
