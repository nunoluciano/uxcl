<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:47
define('_AM_PICAL_DBUPDATED','Database Updated Successfully!');
define('_AM_PICAL_PERMADDNG','Could not add %s permission to %s for group %s');
define('_AM_PICAL_PERMADDOK','Added %s permission to %s for group %s');
define('_AM_PICAL_PERMRESETNG','Could not reset group permission for module %s');
define('_AM_PICAL_PERMADDNGP','All parent items must be selected.');

// Appended by Xoops Language Checker -GIJOE- in 2005-06-29 17:19:30
define('_AM_PI_TH_OPTIONS','Options (usually blank)');

define( 'PICAL_AM_LOADED' , 1 ) ;


// titles
//define("_AM_CONFIG","������������ ������ piCal");
//define("_AM_GENERALCONF","General Settings of piCal");
define("_AM_ADMISSION","������������� �������");
define("_AM_MENU_EVENTS","�������� �������");
define("_AM_MENU_CATEGORIES","���������");
define("_AM_MENU_CAT2GROUP","����� ���������");
define("_AM_ICALENDAR_IMPORT","������");
define("_AM_GROUPPERM","����� �����");
define("_AM_TABLEMAINTAIN","��������� ������ (���������� ������)");
define("_AM_MYBLOCKSADMIN","�����");

// forms
define("_AM_BUTTON_EXTRACT","�������");
define("_AM_BUTTON_ADMIT","�����������");
define("_AM_BUTTON_MOVE","�����������");
define("_AM_BUTTON_COPY","�����������");
define("_AM_CONFIRM_DELETE","�� �������, ��� ������ ������� �������?");
define("_AM_CONFIRM_MOVE","�� �������, ��� ������ ����������� ������� �� ����� ��������� � ������?");
define("_AM_CONFIRM_COPY","�� �������, ��� ������ �������� ��� ������� � ��� ���������?");
define("_AM_OPT_PAST","���������");
define("_AM_OPT_FUTURE","�������");
define("_AM_OPT_PASTANDFUTURE","��������� � �������");

// format
define("_AM_DTFMT_LIST_ALLDAY",'d.m.y');
define("_AM_DTFMT_LIST_NORMAL",'d.m.y<\b\r />H:i');

// timezones
define('_AM_TZOPT_SERVER','������� ���� �������');
define('_AM_TZOPT_GMT','GMT');
define('_AM_TZOPT_USER','������� ���� ������������');

// admission
define("_AM_LABEL_ADMIT","��������� �������: ");
define("_AM_MES_ADMITTED","������� ���� ������������");
define("_AM_ADMIT_TH0","������������");
define("_AM_ADMIT_TH1","���� ������");
define("_AM_ADMIT_TH2","���� ���������");
define("_AM_ADMIT_TH3","��������");
define("_AM_ADMIT_TH4","������� �������");

// events manager & importing iCalendar

define("_AM_LABEL_IMPORTFROMWEB","������������� � web (������� �����, ������������ � 'http://' ��� 'webcal://')");
define("_AM_LABEL_UPLOADFROMFILE","�������� ������ iCalendar (�������� ���� �� ����� ��������� ������)");
define("_AM_LABEL_IO_CHECKEDITEMS","��������� �������:");
define("_AM_LABEL_IO_OUTPUT","");
define("_AM_LABEL_IO_DELETE","");
define("_AM_MES_EVENTLINKTOCAT","������� ���� ��������� � ���������");
define("_AM_MES_EVENTUNLINKED","������� ���� ������� �� ���������");
define("_AM_FMT_IMPORTED","������� ���� ������������� � '%s'");
define("_AM_MES_DELETED","������� ���� �������");
define("_AM_IO_TH0","������������");
define("_AM_IO_TH1","���� ������");
define("_AM_IO_TH2","���� ���������");
define("_AM_IO_TH3","��������");
define("_AM_IO_TH4","������� �������");
define("_AM_IO_TH5","�������������");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "��������" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "�����-��������" ) ;
define( '_AM_GPERM_G_EDITABLE' , "��������������" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "�����-��������������" ) ;
define( '_AM_GPERM_G_DELETABLE' , "��������" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "�����-��������" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "����� ������� ������" ) ;
define( '_AM_CAT2GROUPDESC' , "�������� ���������, � ������� �������� ������." ) ;
define( '_AM_GROUPPERMDESC' , '�������� ����� ������� ��� ������ ������ ������������� (��������� ��� ��������������� � ������ ����� ��������������).<br />��� ����, ����� ��� ��������� �������� � ����, �������� "��������� � ������ ��� �����" � ������ "����� ������������" � ������������ ������.<br /><br />��������/�������������� - ����������� ���������/������������� ��������� ������� ������ ��� ���� ��� ����� ������ �������������.<br />�����-��������/�������������� - ����������� ���������/������������� ��������� ������� ��� ���� ������������ ����� �������������.' ) ;

// Table Maintenance
define( '_AM_MB_SUCCESSUPDATETABLE' , "���������� ������(�) ���������" ) ;
define( '_AM_MB_FAILUPDATETABLE' , "���������� ������(�) ��������� �� �������" ) ;
define( '_AM_NOTICE_NOERRORS' , "� �������� � ������� ������ �� ����������." ) ;
define( '_AM_ALRT_CATTABLENOTEXIST' , "������� ��������� �� ����������.<br />\n������� ������� ���������?" ) ;
define( '_AM_ALRT_OLDTABLE' , "��������� ������� ������� ��������.<br />\n��������?" ) ;
define( '_AM_ALRT_TOOOLDTABLE' , "���������� ������ � �������.<br />\n��������, �� ����������� piCal 0.3x ��� ����� ������ ������.<br />\n���������, ����������, ������� ���������� �� ������ 0.4x ��� 0.5x." ) ;
define( '_AM_FMT_SERVER_TZ_ALL' , "������� ���� ������� (������ �����): %+2.1f<br />������� ���� ������� (������ �����): %+2.1f<br />�������� �������� ����� �������: %s<br />�������� �� ������������ XOOPS: %+2.1f<br />��������, ������������ piCal: %+2.1f<br />" ) ;
define( '_AM_TH_SERVER_TZ_COUNT' , "�������" ) ;
define( '_AM_TH_SERVER_TZ_VALUE' , "������� ����" ) ;
define( '_AM_TH_SERVER_TZ_VALUE_TO' , "�������� (�� -14.0 �� 14.0)" ) ;
define( '_AM_JSALRT_SERVER_TZ' , "�� �������� ������� ����� ������� ������� ����� ����������� ���� ��������" ) ;
define( '_AM_NOTICE_SERVER_TZ' , "���� �� ����� ������� ����������� ������� ���� � ������ �������� � ��������� ������� ���� ���������������� � piCal 0.6x or 0.7x, �� ��������� ��� ������.<br /> ��� ���������, ��� ������� ���������� � -5.0 � -4.0 � EDT." ) ;
define( '_AM_MB_SUCCESSTZUPDATE' , "������� ���� ��� ������� ������." ) ;

// Categories
define( '_AM_CAT_TH_TITLE' , '��������' ) ;
define( '_AM_CAT_TH_DESC' , '��������' ) ;
define( '_AM_CAT_TH_PARENT' , '������������ ���������' ) ;
define( '_AM_CAT_TH_OPTIONS' , '���������' ) ;
define( '_AM_CAT_TH_LASTMODIFY' , '���� ���������� ���������' ) ;
define( '_AM_CAT_TH_OPERATION' , '��������' ) ;
define( '_AM_CAT_TH_ENABLED' , '��������' ) ;
define( '_AM_CAT_TH_WEIGHT' , '���' ) ;
define( '_AM_CAT_TH_SUBMENU' , '���������������� � �������' ) ;
define( '_AM_BTN_UPDATE' , '��������' ) ;
define( '_AM_MENU_CAT_EDIT' , '������������� ���������' ) ;
define( '_AM_MENU_CAT_NEW' , '������� ����� ������������' ) ;
define( '_AM_MB_MAKESUBCAT' , '������������' ) ;
define( '_AM_MB_MAKETOPCAT' , '������� ����� ���������' ) ;
define( '_AM_MB_CAT_INSERTED' , '����� ��������� ������� �������' ) ;
define( '_AM_MB_CAT_UPDATED' , '��������� ������� ���������' ) ;
define( '_AM_FMT_CAT_DELETED' , '%s ��������� �������' ) ;
define( '_AM_FMT_CAT_BATCHUPDATED' , '%s ��������� ���������' ) ;
define( '_AM_FMT_CATDELCONFIRM' , '�� ������������� ������ ������� ��������� %s?' ) ;

// Plugins
define( '_AM_PI_UPDATED' , '������� ���������' ) ;
define( '_AM_PI_TH_TYPE' , '���' ) ;
define( '_AM_PI_TH_TITLE' , '��������:' ) ;
define( '_AM_PI_TH_DIRNAME' , '���������� ������:' ) ;
define( '_AM_PI_TH_FILE' , '���� �������:' ) ;
define( '_AM_PI_TH_DOTGIF' , '��������:' ) ;
define( '_AM_PI_TH_OPERATION' , '��������' ) ;
define( '_AM_PI_ENABLED' , '��������' ) ;
define( '_AM_PI_DELETE' , '�������' ) ;
define( '_AM_PI_NEW' , '�����' ) ;
define( '_AM_PI_VIEWYEARLY' , '��������� �� �����' ) ;
define( '_AM_PI_VIEWMONTHLY' , '��������� �� �������' ) ;
define( '_AM_PI_VIEWWEEKLY' , '��������� �� �������' ) ;
define( '_AM_PI_VIEWDAILY' , '��������� �� ����' ) ;



}

?>
