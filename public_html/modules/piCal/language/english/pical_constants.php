<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {

define( 'PICAL_CNST_LOADED' , 1 ) ;

// the language file for jscalendar "DHTML Date/Time Selector"
define('_PICAL_JS_CALENDAR','calendar-en.js') ;

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
define('_PICAL_FMT_YW','WEEK%2$s %1$s') ;
define('_PICAL_FMT_DHI','%1$s %2$s:%3$s') ;
define('_PICAL_FMT_HI','%1$s:%2$s') ;

// formats for sprintf()
define('_PICAL_FMT_YEAR_MONTH','%2$s %1$s') ;
define('_PICAL_FMT_YEAR','YEAR %s') ;
define('_PICAL_FMT_WEEKNO','WEEK %s') ;

define('_PICAL_ICON_LIST','List View') ;
define('_PICAL_ICON_DAILY','Daily View') ;
define('_PICAL_ICON_WEEKLY','Weekly View') ;
define('_PICAL_ICON_MONTHLY','Monthly View') ;
define('_PICAL_ICON_YEARLY','Yearly View') ;

define('_PICAL_MB_SHOWALLCAT','All Categories') ;

define('_PICAL_MB_LINKTODAY','Today') ;
define('_PICAL_MB_NOSUBJECT','(No Subject)') ;

define('_PICAL_MB_PREV_DATE','Yesterday') ;
define('_PICAL_MB_NEXT_DATE','Tomorrow') ;
define('_PICAL_MB_PREV_WEEK','Last Week') ;
define('_PICAL_MB_NEXT_WEEK','Next Week') ;
define('_PICAL_MB_PREV_MONTH','Last Month') ;
define('_PICAL_MB_NEXT_MONTH','Next Month') ;
define('_PICAL_MB_PREV_YEAR','Last Year') ;
define('_PICAL_MB_NEXT_YEAR','Next Year') ;

define('_PICAL_MB_NOEVENT','No Events') ;
define('_PICAL_MB_ADDEVENT','Add an Event') ;
define('_PICAL_MB_CONTINUING','(continuing)') ;
define('_PICAL_MB_RESTEVENT_PRE','') ;
define('_PICAL_MB_RESTEVENT_SUF','more item(s)') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','Allday Event') ;
define('_PICAL_MB_LONG_EVENT','Show as Bar') ;
define('_PICAL_MB_LONG_SPECIALDAY','Anniversary etc.') ;

define('_PICAL_MB_PUBLIC','Public') ;
define('_PICAL_MB_PRIVATE','Private') ;
define('_PICAL_MB_PRIVATETARGET',' among %s') ;

define('_PICAL_MB_LINK_TO_RRULE1ST','Jump to the 1st Event ') ;
define('_PICAL_MB_RRULE1ST','This is the 1st Event') ;

define('_PICAL_MB_EVENT_NOTREGISTER','Not Registered') ;
define('_PICAL_MB_EVENT_ADMITTED','Admitted') ;
define('_PICAL_MB_EVENT_NEEDADMIT','Waiting for Admission') ;

define('_PICAL_MB_TITLE_EVENTINFO','Scheduler') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','Detail View') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','Editing View') ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_MB_ORDER_ASC','Ascending') ;
define('_PICAL_MB_ORDER_DESC','Descending') ;
define('_PICAL_MB_SORTBY','Sort by:') ;
define('_PICAL_MB_CURSORTEDBY','Events currently sorted by:') ;

define("_PICAL_MB_LABEL_CHECKEDITEMS","Checked events are:");
define("_PICAL_MB_LABEL_OUTPUTICS","to be exported in iCalendar");

define("_PICAL_MB_ICALSELECTPLATFORM","Select platform");

define('_PICAL_TH_SUMMARY','Summary') ;
define('_PICAL_TH_TIMEZONE','Time Zone') ;
define('_PICAL_TH_STARTDATETIME','Beginning DateTime') ;
define('_PICAL_TH_ENDDATETIME','Finishing DateTime') ;
define('_PICAL_TH_ALLDAYOPTIONS','Allday Options') ;
define('_PICAL_TH_LOCATION','Location') ;
define('_PICAL_TH_CONTACT','Contact') ;
define('_PICAL_TH_CATEGORIES','Categories') ;
define('_PICAL_TH_SUBMITTER','Submitter') ;
define('_PICAL_TH_CLASS','Class') ;
define('_PICAL_TH_DESCRIPTION','Description') ;
define('_PICAL_TH_RRULE','Recur Rules') ;
define('_PICAL_TH_ADMISSIONSTATUS','Status') ;
define('_PICAL_TH_LASTMODIFIED','Last Modified') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','(Input Number)') ;
define('_PICAL_NTC_EXTRACTLIMIT','** Only %s events are extracted if the max.') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(%s items need to be admitted)') ;

define('_PICAL_OPT_PRIVATEMYSELF','myself only') ;
define('_PICAL_OPT_PRIVATEGROUP','group %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(invalid group)') ;

define('_PICAL_MB_OP_AFTER','After') ;
define('_PICAL_MB_OP_BEFORE','Before') ;
define('_PICAL_MB_OP_ON','On') ;
define('_PICAL_MB_OP_ALL','All') ;

define('_PICAL_CNFM_SAVEAS_YN','Are you OK saving this as another record ?') ;
define('_PICAL_CNFM_DELETE_YN','Are you OK deleting this record ?') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Error: EventID not found') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"Error: You don't have a permission to view this") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"Error: You don't have a permission to output iCalendar") ;
define('_PICAL_ERR_LACKINDISPITEM','Item %s is blank.<br />Push the Back button of your browser!') ;

define('_PICAL_BTN_JUMP','Jump') ;
define('_PICAL_BTN_NEWINSERTED','New Insert') ;
define('_PICAL_BTN_SUBMITCHANGES',' Change it! ') ;
define('_PICAL_BTN_SAVEAS','Save as') ;
define('_PICAL_BTN_DELETE','Remove it') ;
define('_PICAL_BTN_DELETE_ONE','Remove just one') ;
define('_PICAL_BTN_EDITEVENT','Edit it') ;
define('_PICAL_BTN_RESET','Reset') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;
define('_PICAL_BTN_PRINT','Print') ;
define("_PICAL_BTN_IMPORT","Import!");
define("_PICAL_BTN_UPLOAD","Upload!");
define("_PICAL_BTN_EXPORT","Export!");
define("_PICAL_BTN_EXTRACT","Extract");
define("_PICAL_BTN_ADMIT","Admit");
define("_PICAL_BTN_MOVE","Move");
define("_PICAL_BTN_COPY","Copy");

define('_PICAL_RR_EVERYDAY','Everyday') ;
define('_PICAL_RR_EVERYWEEK','Everyweek') ;
define('_PICAL_RR_EVERYMONTH','Everymonth') ;
define('_PICAL_RR_EVERYYEAR','Everyyear') ;
define('_PICAL_RR_FREQDAILY','Daily') ;
define('_PICAL_RR_FREQWEEKLY','Weekly') ;
define('_PICAL_RR_FREQMONTHLY','Monthly') ;
define('_PICAL_RR_FREQYEARLY','Yearly') ;
define('_PICAL_RR_FREQDAILY_PRE','Every') ;
define('_PICAL_RR_FREQWEEKLY_PRE','Every') ;
define('_PICAL_RR_FREQMONTHLY_PRE','Every') ;
define('_PICAL_RR_FREQYEARLY_PRE','Every') ;
define('_PICAL_RR_FREQDAILY_SUF','day(s)') ;
define('_PICAL_RR_FREQWEEKLY_SUF','week(s)') ;
define('_PICAL_RR_FREQMONTHLY_SUF','Month(s)') ;
define('_PICAL_RR_FREQYEARLY_SUF','Year(s)') ;
define('_PICAL_RR_PERDAY','every %s days') ;
define('_PICAL_RR_PERWEEK','every %s weeks') ;
define('_PICAL_RR_PERMONTH','every %s months') ;
define('_PICAL_RR_PERYEAR','every %s years') ;
define('_PICAL_RR_COUNT','<br />%s times') ;
define('_PICAL_RR_UNTIL','<br />until %s') ;
define('_PICAL_RR_R_NORRULE','Recur No') ;
define('_PICAL_RR_R_YESRRULE','Recur Yes') ;
define('_PICAL_RR_OR','or') ;
define('_PICAL_RR_S_NOTSELECTED','-not selected-') ;
define('_PICAL_RR_S_SAMEASBDATE','Same as beginning date') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','No ending conditions') ;
define('_PICAL_RR_R_USECOUNT_PRE','repeats') ;
define('_PICAL_RR_R_USECOUNT_SUF','times') ;
define('_PICAL_RR_R_USEUNTIL','until') ;


}

?>