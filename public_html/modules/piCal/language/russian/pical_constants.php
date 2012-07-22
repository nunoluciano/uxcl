<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {

define( 'PICAL_CNST_LOADED' , 1 ) ;

// the language file for jscalendar "DHTML Date/Time Selector"
define('_PICAL_JS_CALENDAR','calendar-ru_win_.js');

// format for jscalendar. see common/jscalendar/doc/html/reference.html
define('_PICAL_JSFMT_YMDN','%e %B %Y %A') ;

// format for date()  see http://jp.php.net/date
define('_PICAL_DTFMT_MINUTE','i') ;

// definition of orders     Y:year  M:month  W:week  D:day  N:dayname  O:operand
define('_PICAL_FMT_MD','%2$s %1$s') ;
define('_PICAL_FMT_YMD','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YMDN','%3$s %2$s %1$s %4$s') ;
define('_PICAL_FMT_YMDO','%4$s%3$s%2$s%1$s') ;
define('_PICAL_FMT_YMW','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YW','%2$s ������ %1$s') ;
define('_PICAL_FMT_DHI','%1$s %2$s:%3$s') ;
define('_PICAL_FMT_HI','%1$s:%2$s') ;

// formats for sprintf()
define('_PICAL_FMT_YEAR_MONTH','%2$s %1$s') ;
define('_PICAL_FMT_YEAR','��� %s') ;
define('_PICAL_FMT_WEEKNO','������ %s') ;

define('_PICAL_ICON_LIST','������ �������') ;
define('_PICAL_ICON_DAILY','����') ;
define('_PICAL_ICON_WEEKLY','������') ;
define('_PICAL_ICON_MONTHLY','�����') ;
define('_PICAL_ICON_YEARLY','���') ;

define('_PICAL_MB_SHOWALLCAT','��� ���������') ;

define('_PICAL_MB_LINKTODAY','�������') ;
define('_PICAL_MB_NOSUBJECT','(��� ��������)') ;

define('_PICAL_MB_PREV_DATE','�����') ;
define('_PICAL_MB_NEXT_DATE','������') ;
define('_PICAL_MB_PREV_WEEK','���������� ������') ;
define('_PICAL_MB_NEXT_WEEK','��������� ������') ;
define('_PICAL_MB_PREV_MONTH','���������� �����') ;
define('_PICAL_MB_NEXT_MONTH','��������� �����') ;
define('_PICAL_MB_PREV_YEAR','���������� ���') ;
define('_PICAL_MB_NEXT_YEAR','��������� ���') ;

define('_PICAL_MB_NOEVENT','��� �������') ;
define('_PICAL_MB_ADDEVENT','�������� �������') ;
define('_PICAL_MB_CONTINUING','(����)') ;
define('_PICAL_MB_RESTEVENT_PRE','���') ;
define('_PICAL_MB_RESTEVENT_SUF','�������') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','����� ����') ;
define('_PICAL_MB_LONG_EVENT','���������� ������') ;
define('_PICAL_MB_LONG_SPECIALDAY','������������ � �.�.') ;

define('_PICAL_MB_PUBLIC','��� ����') ;
define('_PICAL_MB_PRIVATE','���������') ;
define('_PICAL_MB_PRIVATETARGET',' ��� %s') ;

define('_PICAL_MB_LINK_TO_RRULE1ST','������� � 1-�� ������� ') ;
define('_PICAL_MB_RRULE1ST','������ �������') ;

define('_PICAL_MB_EVENT_NOTREGISTER','�� ����������������') ;
define('_PICAL_MB_EVENT_ADMITTED','������������') ;
define('_PICAL_MB_EVENT_NEEDADMIT','� �������� �������������') ;

define('_PICAL_MB_TITLE_EVENTINFO','�������') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','��������� ��������') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','��������������') ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_MB_ORDER_ASC','�� �����������') ;
define('_PICAL_MB_ORDER_DESC','�� ��������') ;
define('_PICAL_MB_SORTBY','�����������:') ;
define('_PICAL_MB_CURSORTEDBY','������� �����������:') ;

define("_PICAL_MB_LABEL_CHECKEDITEMS","��������� �������:");
define("_PICAL_MB_LABEL_OUTPUTICS","");

define("_PICAL_MB_ICALSELECTPLATFORM","�������� ���������");

define('_PICAL_TH_SUMMARY','��������') ;
define('_PICAL_TH_TIMEZONE','������� ����') ;
define('_PICAL_TH_STARTDATETIME','���� ������') ;
define('_PICAL_TH_ENDDATETIME','���� ���������') ;
define('_PICAL_TH_ALLDAYOPTIONS','������� ������ ����� ����?') ;
define('_PICAL_TH_LOCATION','�����') ;
define('_PICAL_TH_CONTACT','��������') ;
define('_PICAL_TH_CATEGORIES','���������') ;
define('_PICAL_TH_SUBMITTER','�����') ;
define('_PICAL_TH_CLASS','�������') ;
define('_PICAL_TH_DESCRIPTION','��������') ;
define('_PICAL_TH_RRULE','������� �������') ;
define('_PICAL_TH_ADMISSIONSTATUS','������') ;
define('_PICAL_TH_LASTMODIFIED','���� ���������� ���������') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','���� ������') ;
define('_PICAL_NTC_EXTRACTLIMIT','** ������ %s ������� ���� max.') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(%s ���������� �����������)') ;

define('_PICAL_OPT_PRIVATEMYSELF','����') ;
define('_PICAL_OPT_PRIVATEGROUP','������ %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(������������ ������)') ;

define('_PICAL_MB_OP_AFTER','�����') ;
define('_PICAL_MB_OP_BEFORE','��') ;
define('_PICAL_MB_OP_ON','�') ;
define('_PICAL_MB_OP_ALL','���') ;

define('_PICAL_CNFM_SAVEAS_YN','�� ������ ��������� ��� ��������� ������?') ;
define('_PICAL_CNFM_DELETE_YN','�� ������ ������� ������?') ;

define('_PICAL_ERR_INVALID_EVENT_ID','������: ������� �� �������') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"������: � ��� ��� ���� �� ��������") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"������: � ��� ��� ���� �������� � iCalendar") ;
define('_PICAL_ERR_LACKINDISPITEM','����� %s ����.<br />������� ������ �����') ;

define('_PICAL_BTN_JUMP','�������') ;
define('_PICAL_BTN_NEWINSERTED','�������') ;
define('_PICAL_BTN_SUBMITCHANGES',' ��������! ') ;
define('_PICAL_BTN_SAVEAS','��������� ���') ;
define('_PICAL_BTN_DELETE','������� ��� �����') ;
define('_PICAL_BTN_DELETE_ONE','������� ��� �������') ;
define('_PICAL_BTN_EDITEVENT','�������������') ;
define('_PICAL_BTN_RESET','��������') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;
define('_PICAL_BTN_PRINT','������') ;
define("_PICAL_BTN_IMPORT","�������������!");
define("_PICAL_BTN_UPLOAD","���������!");
define("_PICAL_BTN_EXPORT","��������������!");
define("_PICAL_BTN_EXTRACT","��������");
define("_PICAL_BTN_ADMIT","��������");
define("_PICAL_BTN_MOVE","�����������");
define("_PICAL_BTN_COPY","����������");

define('_PICAL_RR_EVERYDAY','���������') ;
define('_PICAL_RR_EVERYWEEK','�����������') ;
define('_PICAL_RR_EVERYMONTH','����������') ;
define('_PICAL_RR_EVERYYEAR','��������') ;
define('_PICAL_RR_FREQDAILY','���������') ;
define('_PICAL_RR_FREQWEEKLY','�����������') ;
define('_PICAL_RR_FREQMONTHLY','����������') ;
define('_PICAL_RR_FREQYEARLY','��������') ;
define('_PICAL_RR_FREQDAILY_PRE','������') ;
define('_PICAL_RR_FREQWEEKLY_PRE','������') ;
define('_PICAL_RR_FREQMONTHLY_PRE','������') ;
define('_PICAL_RR_FREQYEARLY_PRE','������') ;
define('_PICAL_RR_FREQDAILY_SUF','����') ;
define('_PICAL_RR_FREQWEEKLY_SUF','������') ;
define('_PICAL_RR_FREQMONTHLY_SUF','�����') ;
define('_PICAL_RR_FREQYEARLY_SUF','���') ;
define('_PICAL_RR_PERDAY','������ %s ����') ;
define('_PICAL_RR_PERWEEK','������ %s ������') ;
define('_PICAL_RR_PERMONTH','������ %s �������') ;
define('_PICAL_RR_PERYEAR','������ %s ���') ;
define('_PICAL_RR_COUNT','<br />%s ���') ;
define('_PICAL_RR_UNTIL','<br />�� %s') ;
define('_PICAL_RR_R_NORRULE','�� �����������') ;
define('_PICAL_RR_R_YESRRULE','�����������') ;
define('_PICAL_RR_OR','���') ;
define('_PICAL_RR_S_NOTSELECTED','---') ;
define('_PICAL_RR_S_SAMEASBDATE','��� �� ����') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','��� ������� ���������') ;
define('_PICAL_RR_R_USECOUNT_PRE','��������') ;
define('_PICAL_RR_R_USECOUNT_SUF','���') ;
define('_PICAL_RR_R_USEUNTIL','��') ;


}

?>