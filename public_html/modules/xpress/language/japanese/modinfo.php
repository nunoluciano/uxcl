<?php
if( ! defined( 'XP2_MODINFO_LANG_INCLUDED' ) ) {
	define( 'XP2_MODINFO_LANG_INCLUDED' , 1 ) ;

	// The name of this module admin menu
	define("_MI_XP2_MENU_SYS_INFO","�����ƥ����");
	define("_MI_XP2_MENU_BLOCK_ADMIN","�֥�å�����");
	define("_MI_XP2_MENU_BLOCK_CHECK","�֥�å������å�");
	define("_MI_XP2_MENU_WP_ADMIN","WordPress����");
	define("_MI_XP2_MOD_ADMIN","�⥸�塼�����");

	// The name of this module
	define("_MI_XP2_NAME","�֥�");

	// A brief description of this module
	define("_MI_XP2_DESC","WordPressME��XOOPS�⥸�塼�벽������ΤǤ���");

	// Sub menu titles
	define("_MI_XP2_MENU_POST_NEW","�������");
	define("_MI_XP2_MENU_EDIT","�Խ�");
	define("_MI_XP2_MENU_ADMIN","WordPress����");
	define("_MI_XP2_MENU_XPRESS","XPressME����");
	define("_MI_XP2_MENU_TO_MODULE","�⥸�塼���");
	define("_MI_XP2_TO_UPDATE","���åץǡ���");

	// Module Config
	define("_MI_LIBXML_PATCH","�֥�å���libxml2 �Х����Ф���ѥå�����Ŭ������");
	define("_MI_LIBXML_PATCH_DESC","libxml2 Ver 2.70-2.72�ˤ�'<'��'>'�����������Х�������ޤ���
XPressME��libxml2�ΥС�������ưŪ�˼�������ɬ�פǤ���Хѥå���Ŭ������ޤ���
XPressME��libxml2�ΥС�����������Ǥ��ʤ���硢���Υ��ץ����Ƕ���Ū�˥ѥå���Ŭ�������뤳�Ȥ��Ǥ��ޤ���");
	
	define("_MI_MEMORY_LIMIT","�⥸�塼��˺����ɬ�פʥ���(MB)");
	define("_MI_MEMORY_LIMIT_DESC","php.ini��memory_limit�ͤ������ͤ�꾮�����Ȥ�����ǽ�Ǥ����ini_set('memory_limit', Value);��¹Ԥ�memory_limit������ꤹ��");

	// Block Name
	define("_MI_XP2_BLOCK_COMMENTS","�Ƕ�Υ�����");
	define("_MI_XP2_BLOCK_CONTENT","�Ƕ�ε�������");
	define("_MI_XP2_BLOCK_POSTS","�Ƕ�ε���");
	define("_MI_XP2_BLOCK_CALENDER","��������");
	define("_MI_XP2_BLOCK_POPULAR","�͵������ꥹ��");
	define("_MI_XP2_BLOCK_ARCHIVE","����������");
	define("_MI_XP2_BLOCK_AUTHORS","��Ƽ�");
	define("_MI_XP2_BLOCK_PAGE","�ڡ���");
	define("_MI_XP2_BLOCK_SEARCH","����");
	define("_MI_XP2_BLOCK_TAG","�������饦��");
	define("_MI_XP2_BLOCK_CATEGORY","���ƥ��꡼");
	define("_MI_XP2_BLOCK_META","�᥿����");
	define("_MI_XP2_BLOCK_SIDEBAR","�����ɥС�");
	define("_MI_XP2_BLOCK_WIDGET","���������å�");
	define("_MI_XP2_BLOCK_ENHANCED","��ĥ�֥�å�");
	define("_MI_XP2_BLOCK_BLOG_LIST","�֥��ꥹ��");
	define("_MI_XP2_BLOCK_GLOBAL_POSTS","�Ƕ�ε���(���֥�)");
	define("_MI_XP2_BLOCK_GLOBAL_COMM","�Ƕ�Υ�����(���֥�)");
	define("_MI_XP2_BLOCK_GLOBAL_POPU","�͵������ꥹ��(���֥�)");

	// Notify Categories
	define('_MI_XP2_NOTCAT_GLOBAL', '�֥�����');
	define('_MI_XP2_NOTCAT_GLOBALDSC', '�֥����Τˤ��������Υ��ץ����');
	define('_MI_XP2_NOTCAT_CAT', '������Υ��ƥ���');
	define('_MI_XP2_NOTCAT_CATDSC', '������Υ��ƥ�����Ф������Υ��ץ����');
	define('_MI_XP2_NOTCAT_AUTHOR', '���������Ƽ�'); 
	define('_MI_XP2_NOTCAT_AUTHORDSC', '���������ƼԤ��Ф������Υ��ץ����');
	define('_MI_XP2_NOTCAT_POST', 'ɽ����ε���'); 
	define('_MI_XP2_NOTCAT_POSTDSC', 'ɽ����ε������Ф������Υ��ץ����');

	// Each Notifications
	define('_MI_XP2_NOTIFY_GLOBAL_WAITING', '��ǧ�Ԥ�');
	define('_MI_XP2_NOTIFY_GLOBAL_WAITINGCAP', '��ǧ���פ�����ơ��Խ����Ԥ�줿�������Τ��ޤ�������������');
	define('_MI_XP2_NOTIFY_GLOBAL_WAITINGSBJ', '[{X_SITENAME}] {X_MODULE}: ��ǧ�Ԥ�');

	define('_MI_XP2_NOTIFY_GLOBAL_NEWPOST', '�������');
	define('_MI_XP2_NOTIFY_GLOBAL_NEWPOSTCAP', '���Υ֥����ΤΤ����줫�˵�������Ƥ����ä��������Τ���');
	define('_MI_XP2_NOTIFY_GLOBAL_NEWPOSTSBJ', '[{XPRESS_BLOG_NAME}]����: "{XPRESS_POST_TITLE}"');

	define('_MI_XP2_NOTIFY_GLOBAL_NEWCOMMENT', '���������');
	define('_MI_XP2_NOTIFY_GLOBAL_NEWCOMMENTCAP', '���Υ֥����ΤΤ����줫�˥����Ȥ���Ƥ����ä��������Τ���');
	define('_MI_XP2_NOTIFY_GLOBAL_NEWCOMMENTSBJ', '[{XPRESS_BLOG_NAME}]������: "{XPRESS_POST_TITLE}"');

	define('_MI_XP2_NOTIFY_CAT_NEWPOST', '���򥫥ƥ���ؤε������');
	define('_MI_XP2_NOTIFY_CAT_NEWPOSTCAP', '���Υ��ƥ���˵�����Ƥ����ä��������Τ���');
	define('_MI_XP2_NOTIFY_CAT_NEWPOSTSBJ', '[{XPRESS_BLOG_NAME}]����: "{XPRESS_POST_TITLE}" (���:���ƥ���="{XPRESS_CAT_TITLE}")');

	define('_MI_XP2_NOTIFY_CAT_NEWCOMMENT', '���򥫥ƥ���ؤΥ��������');
	define('_MI_XP2_NOTIFY_CAT_NEWCOMMENTCAP', '���Υ��ƥ���˥�������Ƥ����ä��������Τ���');
	define('_MI_XP2_NOTIFY_CAT_NEWCOMMENTSBJ', '[{XPRESS_BLOG_NAME}]������: (����"{XPRESS_POST_TITLE}") (���:���ƥ���="{XPRESS_CAT_TITLE}")');

	define('_MI_XP2_NOTIFY_AUT_NEWPOST', '������ƼԤˤ�뵭�����');
	define('_MI_XP2_NOTIFY_AUT_NEWPOSTCAP', '������ƼԤ��鵭����Ƥ����ä��������Τ���');
	define('_MI_XP2_NOTIFY_AUT_NEWPOSTSBJ', '[{XPRESS_BLOG_NAME}]����: "{XPRESS_POST_TITLE}" (���:��Ƽ�="{XPRESS_AUTH_NAME}")');

	define('_MI_XP2_NOTIFY_AUT_NEWCOMMENT', '������ƼԵ����ؤΥ��������');
	define('_MI_XP2_NOTIFY_AUT_NEWCOMMENTCAP', '������ƼԤˤ�뵭���إ�������Ƥ����ä��������Τ���');
	define('_MI_XP2_NOTIFY_AUT_NEWCOMMENTSBJ', '[{XPRESS_BLOG_NAME}]������: (����"{XPRESS_POST_TITLE}") (���:��Ƽ�="{XPRESS_AUTH_NAME}")');

	define('_MI_XP2_NOTIFY_POST_EDITPOST', '�����ѹ�');
	define('_MI_XP2_NOTIFY_POST_EDITPOSTCAP', 'ɽ����ε������ѹ������ä��������Τ���');
	define('_MI_XP2_NOTIFY_POST_EDITPOSTSBJ', '[{XPRESS_BLOG_NAME}]����: "{XPRESS_POST_TITLE}"�ѹ� (���:��������)');

	define('_MI_XP2_NOTIFY_POST_NEWCOMMENT', '�����ؤΥ��������');
	define('_MI_XP2_NOTIFY_POST_NEWCOMMENTCAP', 'ɽ����ε����˥����Ȥ���Ƥ����ä��������Τ���');
	define('_MI_XP2_NOTIFY_POST_NEWCOMMENTSBJ', '[{XPRESS_BLOG_NAME}]������: (����"{XPRESS_POST_TITLE}") (���:��������)');

}
?>