<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {

define( 'PICAL_AM_LOADED' , 1 ) ;


// titles
define("_AM_ADMISSION","�������塼��ξ�ǧ");
define("_AM_MENU_EVENTS","ͽ�����");
define("_AM_MENU_CATEGORIES","���ƥ��꡼����");
define("_AM_MENU_CAT2GROUP","���ƥ��꡼�Υ�����������");
define("_AM_ICALENDAR_IMPORT","iCalendar ����ݡ���");
define("_AM_GROUPPERM","���롼�פ�����Ū�ʸ���");
define("_AM_TABLEMAINTAIN","�ơ��֥���ƥʥ󥹡ʥ��åץ��졼�ɡ�");
define("_AM_MYBLOCKSADMIN","piCal�֥�å������롼�״���");

// forms
define("_AM_BUTTON_EXTRACT","���");
define("_AM_BUTTON_ADMIT","��ǧ");
define("_AM_BUTTON_MOVE","��ư");
define("_AM_BUTTON_COPY","���ԡ�");
define("_AM_CONFIRM_DELETE","������Ƥ�����Ǥ���");
define("_AM_CONFIRM_MOVE","�쥫�ƥ��꡼°���������ơ����ꤵ�줿���ƥ��꡼°������Ϳ���ޤ���������Ǥ�����");
define("_AM_CONFIRM_COPY","���ꤵ�줿���ƥ��꡼°������Ϳ���ޤ���������Ǥ�����");
define("_AM_OPT_PAST","���Τ�");
define("_AM_OPT_FUTURE","̤��Τ�");
define("_AM_OPT_PASTANDFUTURE","��������ʤ�");

// format
define("_AM_DTFMT_LIST_ALLDAY",'y-m-d');
define("_AM_DTFMT_LIST_NORMAL",'y-m-d<\b\r />H:i');

// timezones
define("_AM_TZOPT_SERVER",'�����л��֤Ǥ�ɽ��');
define("_AM_TZOPT_GMT",'GMT�Ǥ�ɽ��');
define("_AM_TZOPT_USER",'�桼�����֤Ǥ�ɽ��');

// admission
define("_AM_LABEL_ADMIT","�����å�����ͽ���ǧ����");
define("_AM_MES_ADMITTED","��ǧ���ޤ���");
define("_AM_ADMIT_TH0","User");
define("_AM_ADMIT_TH1","��������");
define("_AM_ADMIT_TH2","��λ����");
define("_AM_ADMIT_TH3","��̾");
define("_AM_ADMIT_TH4","�����֤����");

// iCalendar I/O

define("_AM_LABEL_IMPORTFROMWEB","iCalendar�ǡ�����Web��ͳ����ݡ��� ��http:// �ޤ��� webcal:// ����Ϥޤ�URI�򵭽ҡ�");
define("_AM_LABEL_UPLOADFROMFILE","iCalendar�ǡ����Υ��åץ��� �ʥ�����ե����������");
define("_AM_LABEL_IO_CHECKEDITEMS","�����å�����ͽ���");
define("_AM_LABEL_IO_OUTPUT","iCalendar�����ǽ��Ϥ���");
define("_AM_LABEL_IO_DELETE","�������");
define("_AM_MES_EVENTLINKTOCAT","�Ĥ�ͽ�꤬�����ƥ������Ͽ����ޤ���");
define("_AM_MES_EVENTUNLINKED","�Ĥ�ͽ�꤬���쥫�ƥ���°����������ޤ���");
define("_AM_FMT_IMPORTED","�Ĥ�ͽ�꤬ %s ���饤��ݡ��Ȥ���ޤ���");
define("_AM_MES_DELETED","�Ĥ�ͽ��������ޤ���");
define("_AM_IO_TH0","User");
define("_AM_IO_TH1","��������");
define("_AM_IO_TH2","��λ����");
define("_AM_IO_TH3","��̾");
define("_AM_IO_TH4","�����֤����");
define("_AM_IO_TH5","��ǧ��");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "������Ͽ" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "��Ͽ�ξ�ǧ����" ) ;
define( '_AM_GPERM_G_EDITABLE' , "�ѹ�" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "�ѹ��ξ�ǧ����" ) ;
define( '_AM_GPERM_G_DELETABLE' , "���" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "��ǧ���פκ��" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "¾�ͤΥ쥳���ɤ��ѹ������" ) ;
define( '_AM_CAT2GROUPDESC' , "�ƥ��롼�פˤĤ��ơ�����������ǽ�ʥ��ƥ��꡼�إ����å�������Ʋ�����" ) ;
define( '_AM_GROUPPERMDESC' , "���롼����˥������塼��ˤĤ��Ƥθ��¤�����Ǥ��ޤ�<br />���ε�ǽ�����Ѥ��뤿��ˤϡ���������ˤ����ơ��桼�������¤򡢡֥��롼��������ꤹ��פ����򤹤�ɬ�פ�����ޤ�<br />�ʤ��������ȥ��롼�פ���Ӵ����ԥ��롼�פθ��¤򤳤������ꤷ�Ƥ��̣������ޤ���" ) ;

// Table Maintenance
define( '_AM_MB_SUCCESSUPDATETABLE' , "�ơ��֥빽¤�Υ��åץ��졼�ɤ��������ޤ���" ) ;
define( '_AM_MB_FAILUPDATETABLE' , "�ơ��֥빽¤�Υ��åץ��졼�ɤ˼��Ԥ��ޤ���" ) ;
define( '_AM_NOTICE_NOERRORS' , "0.6�����˥��åץ��졼�ɺѡ����顼�⤢��ޤ���" ) ;
define( '_AM_ALRT_CATTABLENOTEXIST' , "���ƥ��꡼�ơ��֥뤬¸�ߤ��ޤ���<br />\n���Υơ��֥��������Ƥ�����Ǥ�����" ) ;
define( '_AM_ALRT_OLDTABLE' , "ͽ��ơ��֥�ι�¤���Ť��褦�Ǥ���<br />\n���ޤ������åץ��졼�ɤ��ޤ�����" ) ;
define( '_AM_ALRT_TOOOLDTABLE' , "�ơ��֥륨�顼�Ǥ���<br />\n�����餯��piCal 0.3�����Υơ��֥���Ȼפ��ޤ���<br />\n�ޤ��ϡ�0.4��0.5�˥��åץ��졼�ɤ��Ƥ���������" ) ;
define( '_AM_FMT_SERVER_TZ_ALL' , "���Υ����Ф��ߵ������ॾ����: %+2.1f<br />���Υ����ФβƵ������ॾ����: %+2.1f<br />�����ФΥ����ॾ����̾: %s<br />XOOPS�Ǥ�������: %+2.1f<br />piCal�Ǥκ�����: %+2.1f<br />" ) ;
define( '_AM_TH_SERVER_TZ_COUNT' , "ͽ��Ŀ�" ) ;
define( '_AM_TH_SERVER_TZ_VALUE' , "�����ॾ����" ) ;
define( '_AM_TH_SERVER_TZ_VALUE_TO' , "�ѹ���(-14.0���14.0)" ) ;
define( '_AM_JSALRT_SERVER_TZ' , "��������Ԥ����˥ǡ����ΥХå����åפ�侩���ޤ�" ) ;
define( '_AM_NOTICE_SERVER_TZ' , "���Ȥ��Υ����Ф������ޡ�������(Day Light Saving)��¸�ߤ����ϰ�Ȥ��ƥ��åȥ��åפ���Ƥ����硢0.8̤���ΥС���������Ͽ��������ˤ�ꡢ����������Υ����ॾ����Τ��줬ȯ�����Ƥ��뤳�Ȥ�����ޤ������ξ��Ϸ褷�Ƥ��Υܥ���򲡤��ʤ��Ǥ�������" ) ;
define( '_AM_MB_SUCCESSTZUPDATE' , "�ƥ��٥�ȤˤĤ��ơ����Υ����ФΥ����ॾ����˹�碌�ޤ���" ) ;

// Categories
define( '_AM_CAT_TH_TITLE' , '���ƥ���̾' ) ;
define( '_AM_CAT_TH_DESC' , '���ƥ��������' ) ;
define( '_AM_CAT_TH_PARENT' , '�ƥ��ƥ���' ) ;
define( '_AM_CAT_TH_OPTIONS' , '���ץ����' ) ;
define( '_AM_CAT_TH_LASTMODIFY' , '�ǽ�������' ) ;
define( '_AM_CAT_TH_OPERATION' , '���' ) ;
define( '_AM_CAT_TH_ENABLED' , 'ͭ��' ) ;
define( '_AM_CAT_TH_WEIGHT' , 'ɽ����' ) ;
define( '_AM_CAT_TH_SUBMENU' , '���֥�˥塼�ؤ�ɽ��' ) ;
define( '_AM_BTN_UPDATE' , '����' ) ;
define( '_AM_MENU_CAT_EDIT' , '���ƥ��꡼�ν���' ) ;
define( '_AM_MENU_CAT_NEW' , '�����ƥ��꡼����Ͽ' ) ;
define( '_AM_MB_MAKESUBCAT' , '���֥��ƥ��꡼' ) ;
define( '_AM_MB_MAKETOPCAT' , '�ȥåץ�٥�˥��ƥ��꡼�򿷵�����' ) ;
define( '_AM_MB_CAT_INSERTED' , '�����ƥ��꡼����Ͽ����ޤ���' ) ;
define( '_AM_MB_CAT_UPDATED' , '���ƥ��꡼����������ޤ���' ) ;
define( '_AM_FMT_CAT_DELETED' , '%s �ĤΥ��ƥ��꡼���������ޤ���' ) ;
define( '_AM_FMT_CAT_BATCHUPDATED' , '%s ���Υ��ƥ��꡼����������ޤ���' ) ;
define( '_AM_FMT_CATDELCONFIRM' , '���ƥ��꡼̾ %s �������Ƥ�����Ǥ�����' ) ;
// Plugins
define( '_AM_PI_UPDATED' , '��������ޤ���' ) ;
define( '_AM_PI_TH_TYPE' , 'Ŭ����' ) ;
define( '_AM_PI_TH_OPTIONS' , '���ץ����(�̾�϶���)' ) ;
define( '_AM_PI_TH_TITLE' , 'ɽ��̾' ) ;
define( '_AM_PI_TH_DIRNAME' , '�оݥ⥸�塼��' ) ;
define( '_AM_PI_TH_FILE' , '���ѥץ饰����' ) ;
define( '_AM_PI_TH_DOTGIF' , '�ɥåȲ���' ) ;
define( '_AM_PI_TH_OPERATION' , '���' ) ;
define( '_AM_PI_ENABLED' , 'ͭ��' ) ;
define( '_AM_PI_DELETE' , '���' ) ;
define( '_AM_PI_NEW' , '����' ) ;
define( '_AM_PI_VIEWYEARLY' , 'ǯ�֥ӥ塼' ) ;
define( '_AM_PI_VIEWMONTHLY' , '��֥ӥ塼' ) ;
define( '_AM_PI_VIEWWEEKLY' , '���֥ӥ塼' ) ;
define( '_AM_PI_VIEWDAILY' , '����ӥ塼' ) ;

// groupperm
//define("_MD_AM_DBUPDATED","�ǡ����١����򹹿����ޤ���");
//define('_MD_AM_PERMADDNG', '���롼�ס��ѡ��ߥå������ɲä˼��Ԥ��ޤ����ʥѡ��ߥå����̾��%s �оݥ����ƥࡧ%s �оݥ��롼�ס�%s��');
//define('_MD_AM_PERMADDOK','���롼�ס��ѡ��ߥå������ɲä��ޤ����ʥѡ��ߥå����̾��%s �оݥ����ƥࡧ%s �оݥ��롼�ס�%s��');
//define('_MD_AM_PERMRESETNG','��%s�ץ⥸�塼��Υ��롼�ס��ѡ��ߥå��������ν�����˼��Ԥ��ޤ���');
//define('_MD_AM_PERMADDNGP', '���Υ����ƥ�ξ�̥����ƥ����Ƥ˥ѡ��ߥå�����Ϳ����ɬ�פ�����ޤ�');
// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:48
define('_AM_PICAL_DBUPDATED','�ǡ����١����򹹿����ޤ���');
define('_AM_PICAL_PERMADDNG','���롼�ס��ѡ��ߥå������ɲä˼��Ԥ��ޤ����ʥѡ��ߥå����̾��%s �оݥ����ƥࡧ%s �оݥ��롼�ס�%s��');
define('_AM_PICAL_PERMADDOK','���롼�ס��ѡ��ߥå������ɲä��ޤ����ʥѡ��ߥå����̾��%s �оݥ����ƥࡧ%s �оݥ��롼�ס�%s��');
define('_AM_PICAL_PERMRESETNG','��%s�ץ⥸�塼��Υ��롼�ס��ѡ��ߥå��������ν�����˼��Ԥ��ޤ���');
define('_AM_PICAL_PERMADDNGP','���Υ����ƥ�ξ�̥����ƥ����Ƥ˥ѡ��ߥå�����Ϳ����ɬ�פ�����ޤ�');


}

?>