<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","�������塼���ե�������");

// Default Locale
define("_MI_PICAL_DEFAULTLOCALE","japan");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","�ߥ˥�������");
define("_MI_PICAL_BNAME_MINICAL_DESC","�����ʥ���������ɽ��");
define("_MI_PICAL_BNAME_MINICALEX","��ĥ�ߥ˥�������");
define("_MI_PICAL_BNAME_MINICALEX_DESC","�ץ饰�����ĥ����ǽ�ʥߥ˥���������ɽ��");
define("_MI_PICAL_BNAME_MONTHCAL","���̥ե륵������������");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","���̥ե륵��������������ɽ��");
define("_MI_PICAL_BNAME_TODAYS","������ͽ��");
define("_MI_PICAL_BNAME_TODAYS_DESC","������ͽ���ɽ��");
define("_MI_PICAL_BNAME_THEDAYS","%s ��ͽ��");
define("_MI_PICAL_BNAME_THEDAYS_DESC","���������ǻ��ꤵ�줿����ͽ���ɽ��");
define("_MI_PICAL_BNAME_COMING","�����ͽ��");
define("_MI_PICAL_BNAME_COMING_DESC","�����ʹߤ�ͽ���ɽ��");
define("_MI_PICAL_BNAME_AFTER","%s �ʹߤ�ͽ��");
define("_MI_PICAL_BNAME_AFTER_DESC","���������ǻ��ꤵ�줿���ʹߤ�ͽ���ɽ��");
define("_MI_PICAL_BNAME_NEW","������ͽ��");
define("_MI_PICAL_BNAME_NEW_DESC","��������Ͽ���줿ͽ���ɽ��");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","������Ͽ");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "���̥桼���θ���");
define("_MI_GUESTS_AUTHORITY", "�����Ȥθ���");
define("_MI_DEFAULT_VIEW", "�ǥե���ȤΥ�������ɽ������");
define("_MI_MINICAL_TARGET", "�ߥ˥������������դ򥯥�å���������ư��");
define("_MI_COMING_NUMROWS", "�����ͽ��֥�å��Ǥ�ɽ��ͽ����");
define("_MI_SKINFOLDER", "������ե����̾");
define("_MI_PICAL_LOCALE", "�ϰ�����ե����� (locales/*.php)");
define("_MI_SUNDAYCOLOR", "��������ʸ����");
define("_MI_WEEKDAYCOLOR", "ʿ����ʸ����");
define("_MI_SATURDAYCOLOR", "��������ʸ����");
define("_MI_HOLIDAYCOLOR", "������ʸ����");
define("_MI_TARGETDAYCOLOR", "�о�����ʸ����");
define("_MI_SUNDAYBGCOLOR", "���������طʿ�");
define("_MI_WEEKDAYBGCOLOR", "ʿ�����طʿ�");
define("_MI_SATURDAYBGCOLOR", "���������طʿ�");
define("_MI_HOLIDAYBGCOLOR", "�������طʿ�");
define("_MI_TARGETDAYBGCOLOR", "�о������طʿ�");
define("_MI_CALHEADCOLOR", "�إå���ʸ����");
define("_MI_CALHEADBGCOLOR", "�إå����طʿ�");
define("_MI_CALFRAMECSS", "���������ե졼��Υ�������");
define("_MI_CANOUTPUTICS", "ics�ե�������Ϥε��ġ��Ե���");
define("_MI_MAXRRULEEXTRACT", "�����֤�����Ÿ����¿� (COUNT)");
define("_MI_WEEKSTARTFROM", "���γ�������");
define("_MI_WEEKNUMBERING", "���ο�����");
define("_MI_DAYSTARTFROM", "��������ڤ����");
define("_MI_TIMEZONE_USING", "�����ФΥ����ॾ�������");
define("_MI_USE24HOUR", "24�������Ȥ���ʤ������ʤ顢12��������");
define("_MI_NAMEORUNAME" , "��Ƽ�̾��ɽ��" ) ;
define("_MI_DESCNAMEORUNAME" , "������̾���ϥ�ɥ�̾�����򤷤Ʋ�����" ) ;
define("_MI_PROXYSETTINGS" , "�ץ�������(host:port:user:pass)" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "�����Ȥ�ͽ����ɲäǤ��뤫�ɤ���");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "��Ͽ�Բ�");
define("_MI_OPT_AUTH_WAIT", "��Ͽ�ġ��׾�ǧ");
define("_MI_OPT_AUTH_POST", "��Ͽ�ġ���ǧ����");
define("_MI_OPT_AUTH_BYGROUP", "���롼��������ꤹ��");
define("_MI_OPT_MINI_PHPSELF", "���ߤΥڡ����򤽤Τޤ�ɽ��");
define("_MI_OPT_MINI_MONTHLY", "����Υ���������ᥤ���ɽ��");
define("_MI_OPT_MINI_WEEKLY", "����Υ���������ᥤ���ɽ��");
define("_MI_OPT_MINI_DAILY", "���������Υ���������ᥤ���ɽ��");
define("_MI_OPT_MINI_LIST", "ͽ���������");
define("_MI_OPT_CANNOTOUTPUTICS", "���϶ػ�");
define("_MI_OPT_CANOUTPUTICS", "���ϵ���");
define("_MI_OPT_STARTFROMSUN", "������");
define("_MI_OPT_STARTFROMMON", "������");
define("_MI_OPT_WEEKNOEACHMONTH", "���");
define("_MI_OPT_WEEKNOWHOLEYEAR", "ǯ���̻�");
define("_MI_OPT_USENAME" , "�ϥ�ɥ�̾" ) ;
define("_MI_OPT_USEUNAME" , "������̾" ) ;
define("_MI_OPT_TZ_USEXOOPS" , "XOOPS�Ǥ�������" ) ;
define("_MI_OPT_TZ_USEWINTER" , "�����Ф�������줿�߻��֡ʿ侩��" ) ;
define("_MI_OPT_TZ_USESUMMER" , "�����Ф�������줿�ƻ���" ) ;


// Admin Menus
define("_MI_PICAL_ADMENU0","�������塼��ξ�ǧ");
define("_MI_PICAL_ADMENU1","ͽ�����");
define("_MI_PICAL_ADMENU_CAT","���ƥ��꡼����");
define("_MI_PICAL_ADMENU_CAT2GROUP","���ƥ��꡼�Υ�����������");
define("_MI_PICAL_ADMENU2","���롼�פ�����Ū�ʸ���");
define("_MI_PICAL_ADMENU_TM","�ơ��֥���ƥʥ�");
define("_MI_PICAL_ADMENU_PLUGINS","�ץ饰�������");
define("_MI_PICAL_ADMENU_ICAL","iCalendar�Υ���ݡ���");
define('_MI_PICAL_ADMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���');
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','�֥�å������롼�״���');

// Text for notifications
define('_MI_PICAL_GLOBAL_NOTIFY', '�⥸�塼������');
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'piCal�⥸�塼�����Τˤ��������Υ��ץ����');
define('_MI_PICAL_CATEGORY_NOTIFY', '���ƥ��꡼');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', '������Υ��ƥ��꡼���Ф������Υ��ץ����');
define('_MI_PICAL_EVENT_NOTIFY', 'ͽ��');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'ɽ�����ͽ����Ф������Υ��ץ����');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', '����ͽ����Ͽ');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', '������ͽ�꤬��Ͽ���줿�������Τ���');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', '������ͽ�꤬��Ͽ���줿�������Τ���');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ������ͽ�꤬��Ͽ����ޤ���');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', '���ƥ�����ο�ͽ����Ͽ');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', '���Υ��ƥ���˿�ͽ�꤬��Ͽ���줿�������Τ���');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', '���Υ��ƥ���˿�ͽ�꤬��Ͽ���줿�������Τ���');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ������ͽ�꤬��Ͽ����ޤ���');

//d3comment integration
define("_MI_COM_DIRNAME","���������礹��d3forum��dirname");
define("_MI_COM_DIRNAMEDSC","d3forum�Υ��������絡ǽ����Ѥ������<br/>�ե�������html¦�ǥ��쥯�ȥ�̾����ꤷ�ޤ���<br/>xoops�����Ȥ���Ѥ�����䥳���ȵ�ǽ��̵���ˤ�����϶���Ǥ���");
define("_MI_COM_FORUM_ID","���������礹��ե��������ֹ�");
define("_MI_COM_FORUM_IDDSC","��������������򤷤���硢forum_id��ɬ�����ꤷ�Ƥ���������");
define("_MI_COM_ORDER","�����������ɽ�����");
define("_MI_COM_ORDERDSC","��������������򤷤����Ρ������Ȥο������硿�Ť�������Ǥ��ޤ���");
define("_MI_COM_VIEW","�����������ɽ����ˡ");
define("_MI_COM_VIEWDSC","�ե�å�ɽ��������å�ɽ���������򤷤ޤ���");
define("_MI_COM_POSTSNUM","����������Υե�å�ɽ���ˤ��������ɽ�����");

}

?>
