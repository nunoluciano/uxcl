<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {

define( 'PICAL_CNST_LOADED' , 1 ) ;

// the language file for jscalendar "DHTML Date/Time Selector"
define('_PICAL_JS_CALENDAR','calendar-jp.js') ;

// format for jscalendar. see common/jscalendar/doc/html/reference.html
define('_PICAL_JSFMT_YMDN','%Yǯ %B %d�� (%A)') ;

// format for date()  see http://jp.php.net/date
define('_PICAL_DTFMT_MINUTE','iʬ') ;

// orders of formatted elements   Y:year  M:month  W:week  D:day  O:operand
define('_PICAL_FMT_MD','%1$s%2$s') ;
define('_PICAL_FMT_YMD','%1$sǯ %2$s %3$s') ;
define('_PICAL_FMT_YMDN','%1$sǯ %2$s %3$s (%4$s)') ;
define('_PICAL_FMT_YMDO','%1$s%2$s%3$s%4$s') ;
define('_PICAL_FMT_YMW','%1$sǯ %2$s %3$s') ;
define('_PICAL_FMT_YW','%1$sǯ ��%2$s��') ;
define('_PICAL_FMT_DHI','%1$s %2$s%3$s') ;
define('_PICAL_FMT_HI','%1$s%2$s') ;

// formats for sprintf()
define('_PICAL_FMT_YEAR_MONTH','%1$sǯ %2$s') ;
define('_PICAL_FMT_YEAR','%sǯ') ;
define('_PICAL_FMT_WEEKNO','��%s��') ;

define('_PICAL_ICON_LIST','ͽ�����ɽ��') ;
define('_PICAL_ICON_DAILY','����ɽ��') ;
define('_PICAL_ICON_WEEKLY','��ɽ��') ;
define('_PICAL_ICON_MONTHLY','��ɽ��') ;
define('_PICAL_ICON_YEARLY','ǯ��ɽ��') ;

define('_PICAL_MB_SHOWALLCAT','�����ƥ��꡼ɽ��') ;

define('_PICAL_MB_LINKTODAY','�㺣����') ;
define('_PICAL_MB_NOSUBJECT','�ʷ�̾�ʤ���') ;

define('_PICAL_MB_PREV_DATE','����') ;
define('_PICAL_MB_NEXT_DATE','����') ;
define('_PICAL_MB_PREV_WEEK','�轵') ;
define('_PICAL_MB_NEXT_WEEK','����') ;
define('_PICAL_MB_PREV_MONTH','����') ;
define('_PICAL_MB_NEXT_MONTH','���') ;
define('_PICAL_MB_PREV_YEAR','��ǯ') ;
define('_PICAL_MB_NEXT_YEAR','��ǯ') ;

define('_PICAL_MB_NOEVENT','ͽ��ʤ�') ;
define('_PICAL_MB_ADDEVENT','ͽ����ɲ�') ;
define('_PICAL_MB_CONTINUING','�ʷ�³���') ;
define('_PICAL_MB_RESTEVENT_PRE','¾') ;
define('_PICAL_MB_RESTEVENT_SUF','��') ;
define('_PICAL_MB_TIMESEPARATOR','��') ;

define('_PICAL_MB_ALLDAY_EVENT','�������٥��') ;
define('_PICAL_MB_LONG_EVENT','Ĺ�����٥��') ;
define('_PICAL_MB_LONG_SPECIALDAY','��ǰ����������') ;

define('_PICAL_MB_PUBLIC','����');
define('_PICAL_MB_PRIVATE','�����');
define('_PICAL_MB_PRIVATETARGET',' ������ %s');

define('_PICAL_MB_LINK_TO_RRULE1ST','�ǽ��ͽ�� ') ;
define('_PICAL_MB_RRULE1ST','���ʬ') ;

define('_PICAL_MB_EVENT_NOTREGISTER','̤��Ͽ') ;
define('_PICAL_MB_EVENT_ADMITTED','��ǧ��') ;
define('_PICAL_MB_EVENT_NEEDADMIT','̤��ǧ') ;

define('_PICAL_MB_TITLE_EVENTINFO','ͽ��ɽ') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','�ܺپ���') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','�Խ�') ;

define('_PICAL_MB_HOUR_SUF','��') ;
define('_PICAL_MB_MINUTE_SUF','ʬ') ;

define('_PICAL_MB_ORDER_ASC','����') ;
define('_PICAL_MB_ORDER_DESC','�߽�') ;
define('_PICAL_MB_SORTBY','�¤��ؤ�:') ;
define('_PICAL_MB_CURSORTEDBY','���ߤ��¤���:') ;

define("_PICAL_MB_LABEL_CHECKEDITEMS","�����å�����ͽ���:");
define("_PICAL_MB_LABEL_OUTPUTICS","iCalendar�ǽ��Ϥ���");

define("_PICAL_MB_ICALSELECTPLATFORM","�����оݤ����򤷤Ʋ�����");

define('_PICAL_TH_SUMMARY','��̾') ;
define('_PICAL_TH_TIMEZONE','�����ॾ����') ;
define('_PICAL_TH_STARTDATETIME','��������') ;
define('_PICAL_TH_ENDDATETIME','��λ����') ;
define('_PICAL_TH_ALLDAYOPTIONS','�������ץ����') ;
define('_PICAL_TH_LOCATION','���') ;
define('_PICAL_TH_CONTACT','Ϣ����') ;
define('_PICAL_TH_CATEGORIES','���ƥ��꡼') ;
define('_PICAL_TH_SUBMITTER','��Ƽ�');
define('_PICAL_TH_CLASS','�쥳����ɽ��');
define('_PICAL_TH_DESCRIPTION','�ܺ�') ;
define('_PICAL_TH_RRULE','�����֤�') ;
define('_PICAL_TH_ADMISSIONSTATUS','����') ;
define('_PICAL_TH_LASTMODIFIED','�ǽ�������') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','(���ջ���)') ;
define('_PICAL_NTC_EXTRACTLIMIT','��Ÿ����� %s ��') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(̤��ǧ %s ��)') ;

define('_PICAL_OPT_PRIVATEMYSELF','��ʬ�Τ�');
define('_PICAL_OPT_PRIVATEGROUP','%s ���롼��');
define('_PICAL_OPT_PRIVATEINVALID','(̵���ʥ��롼��)');

define('_PICAL_MB_OP_AFTER','�ʹߤ�ͽ��') ;
define('_PICAL_MB_OP_BEFORE','������ͽ��') ;
define('_PICAL_MB_OP_ON','�ˤ�����ͽ��') ;
define('_PICAL_MB_OP_ALL','���ջ���̵��') ;

define('_PICAL_CNFM_SAVEAS_YN','�̷�Ȥ�����Ͽ���ޤ���') ;
define('_PICAL_CNFM_DELETE_YN','������Ƥ�����Ǥ���') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Error: ��������ͽ��Ϥ���ޤ���') ;
define('_PICAL_ERR_NOPERM_TO_SHOW','Error: ɽ���Ǥ��ޤ���') ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS','Error: iCalendar�������ϵ��Ĥ���Ƥ��ޤ���') ;
define('_PICAL_ERR_LACKINDISPITEM','%s ��̤���ϤǤ�<br />�֥饦���Υܥ������äƤ�������') ;

define('_PICAL_BTN_JUMP','Jump') ;
define('_PICAL_BTN_NEWINSERTED','������Ͽ') ;
define('_PICAL_BTN_SUBMITCHANGES','���ѡ�����') ;
define('_PICAL_BTN_SAVEAS','�̷���Ͽ') ;
define('_PICAL_BTN_DELETE','���') ;
define('_PICAL_BTN_DELETE_ONE','�����') ;
define('_PICAL_BTN_EDITEVENT','�Խ�') ;
define('_PICAL_BTN_RESET','�ꥻ�å�') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;
define('_PICAL_BTN_PRINT','����') ;
define("_PICAL_BTN_IMPORT","����ݡ��ȼ¹�");
define("_PICAL_BTN_UPLOAD","���åץ��ɼ¹�");
define("_PICAL_BTN_EXPORT","����");
define("_PICAL_BTN_EXTRACT","���");
define("_PICAL_BTN_ADMIT","��ǧ");
define("_PICAL_BTN_MOVE","��ư");
define("_PICAL_BTN_COPY","���ԡ�");

define('_PICAL_RR_EVERYDAY','����') ;
define('_PICAL_RR_EVERYWEEK','�轵') ;
define('_PICAL_RR_EVERYMONTH','���') ;
define('_PICAL_RR_EVERYYEAR','��ǯ') ;
define('_PICAL_RR_FREQDAILY','����ñ��') ;
define('_PICAL_RR_FREQWEEKLY','��ñ��') ;
define('_PICAL_RR_FREQMONTHLY','��ñ��') ;
define('_PICAL_RR_FREQYEARLY','ǯñ��') ;
define('_PICAL_RR_FREQDAILY_PRE','') ;
define('_PICAL_RR_FREQWEEKLY_PRE','') ;
define('_PICAL_RR_FREQMONTHLY_PRE','') ;
define('_PICAL_RR_FREQYEARLY_PRE','') ;
define('_PICAL_RR_FREQDAILY_SUF','�����Ȥ�') ;
define('_PICAL_RR_FREQWEEKLY_SUF','�����Ȥ�') ;
define('_PICAL_RR_FREQMONTHLY_SUF','����Ȥ�') ;
define('_PICAL_RR_FREQYEARLY_SUF','ǯ���Ȥ�') ;
define('_PICAL_RR_PERDAY','%s ��������') ;
define('_PICAL_RR_PERWEEK','%s ��������') ;
define('_PICAL_RR_PERMONTH','%s �����') ;
define('_PICAL_RR_PERYEAR','%s ǯ������') ;
define('_PICAL_RR_COUNT','<br />%s ��') ;
define('_PICAL_RR_UNTIL','<br />%s �ޤ�') ;
define('_PICAL_RR_R_NORRULE','�����֤�̵��') ;
define('_PICAL_RR_R_YESRRULE','�����֤�����') ;
define('_PICAL_RR_OR','�ޤ���') ;
define('_PICAL_RR_S_NOTSELECTED','-̤����-') ;
define('_PICAL_RR_S_SAMEASBDATE','��������Ʊ��') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','��λ���̵��') ;
define('_PICAL_RR_R_USECOUNT_PRE','�������') ;
define('_PICAL_RR_R_USECOUNT_SUF','��') ;
define('_PICAL_RR_R_USEUNTIL','��λ���ˤ�����') ;


}

?>