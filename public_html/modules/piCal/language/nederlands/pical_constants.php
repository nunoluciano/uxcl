<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2005-05-17 17:34:00
define('_PICAL_BTN_DELETE_ONE','Remove just one');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:13
define('_PICAL_JS_CALENDAR','calendar-en.js');
define('_PICAL_JSFMT_YMDN','%d %B %Y (%A)');
define('_PICAL_DTFMT_MINUTE','i');
define('_PICAL_FMT_YMDN','%3$s %2$s %1$s %4$s');
define('_PICAL_FMT_DHI','%1$s %2$s:%3$s');
define('_PICAL_FMT_HI','%1$s:%2$s');
define('_PICAL_TH_TIMEZONE','Time Zone');

define( 'PICAL_CNST_LOADED' , 1 ) ;


// format for date()  see http://jp.php.net/date
define('_PICAL_DTFMT_TIME','a g:i') ;

// set your locale
define('_PICAL_LOCALE','nl_NL') ;
// format for strftime()  see http://jp.php.net/strftime
define('_PICAL_STRFFMT_DATE','%x') ;

define('_PICAL_FMT_MD','%2$s %1$s') ;
define('_PICAL_FMT_YMD','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YMW','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YEAR_MONTH','%2$s %1$s') ;
define('_PICAL_FMT_YEAR','<font size="-1">Jaar </font>%s') ;

define('_PICAL_ICON_DAILY','Dagvoorstelling') ;
define('_PICAL_ICON_WEEKLY','Weekvoorstelling') ;
define('_PICAL_ICON_MONTHLY','Maandvoorstelling') ;
define('_PICAL_ICON_YEARLY','Jaarvoorstelling') ;

define('_PICAL_MB_LINKTODAY','Vandaag') ;
define('_PICAL_MB_NOSUBJECT','(geen onderwerp)') ;

define('_PICAL_MB_PREV_DATE','Gisteren') ;
define('_PICAL_MB_NEXT_DATE','Morgen') ;
define('_PICAL_MB_PREV_WEEK','Vorige week') ;
define('_PICAL_MB_NEXT_WEEK','Volgende week') ;
define('_PICAL_MB_PREV_MONTH','Vorige maand') ;
define('_PICAL_MB_NEXT_MONTH','Volgende maand') ;
define('_PICAL_MB_PREV_YEAR','Vorige jaar') ;
define('_PICAL_MB_NEXT_YEAR','Volgend jaar') ;

define('_PICAL_MB_NOEVENT','Geen activiteiten') ;
define('_PICAL_MB_ADDEVENT','Activiteiten toevoegen') ;
define('_PICAL_MB_CONTINUING','(lopende)') ;
define('_PICAL_MB_RESTEVENT_PRE','meer') ;
define('_PICAL_MB_RESTEVENT_SUF','info') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','Volledige dag') ;
define('_PICAL_MB_LONG_EVENT','Als balk voorstellen') ;
define('_PICAL_MB_LONG_SPECIALDAY','Verjaardag, etc.') ;

define('_PICAL_MB_PUBLIC','publiek') ;
define('_PICAL_MB_PRIVATE','privé') ;
define('_PICAL_MB_PRIVATETARGET',' %s') ;

define('_PICAL_MB_LINK_TO_RRULE1ST','Naar 1ste activiteit springen') ;
define('_PICAL_MB_RRULE1ST','Dat is de 1ste activiteit') ;

define('_PICAL_MB_EVENT_NOTREGISTER','niet geregistreerd') ;
define('_PICAL_MB_EVENT_ADMITTED','goedgekeurd') ;
define('_PICAL_MB_EVENT_NEEDADMIT','wacht op goedkeuring') ;

define('_PICAL_MB_TITLE_EVENTINFO','Activiteitsplanner') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','Detailweergave') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','Editeerweergave') ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_TH_SUMMARY','Titel') ;
define('_PICAL_TH_STARTDATETIME','Begin') ;
define('_PICAL_TH_ENDDATETIME','Einde') ;
define('_PICAL_TH_ALLDAYOPTIONS','Volledige dag') ;
define('_PICAL_TH_LOCATION','Plaats') ;
define('_PICAL_TH_CONTACT','Verantwoordelijke') ;
define('_PICAL_TH_CLASS','Klasse') ;
define('_PICAL_TH_DESCRIPTION','Omschrijving') ;
define('_PICAL_TH_RRULE','Terugkeerpatroon') ;
define('_PICAL_TH_ADMISSIONSTATUS','Status') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','(Getal ingeven)') ;
define('_PICAL_NTC_EXTRACTLIMIT','-> max. %s activiteiten worden ingegeven') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(Activiteiten die nog op goedkeuring wachten: %s )') ;

define('_PICAL_OPT_PRIVATEMYSELF','alleen ikzelf') ;
define('_PICAL_OPT_PRIVATEGROUP','Groep %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(ungeldige groep)') ;

define('_PICAL_CNFM_SAVEAS_YN','Ingave opslaan - OK?') ;
define('_PICAL_CNFM_DELETE_YN','Ingave verwijderen -OK?') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Error: EventID niet gevonden') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"Error: geen rechten") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"Error: geen rechten voor iCalender output") ;
define('_PICAL_ERR_LACKINDISPITEM','Ingave %s is leeg.<br />Ga terug') ;

define('_PICAL_BTN_JUMP','Ga naar') ;
define('_PICAL_BTN_NEWINSERTED','Nieuwe ingave') ;
define('_PICAL_BTN_SUBMITCHANGES',' Wijzigingen doorvoeren ') ;
define('_PICAL_BTN_SAVEAS','Opslaan als') ;
define('_PICAL_BTN_DELETE','Verwijderen') ;
define('_PICAL_BTN_EDITEVENT','Editeren') ;
define('_PICAL_BTN_RESET','Terugzetten') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;

define('_PICAL_RR_EVERYDAY','Elke dag') ;
define('_PICAL_RR_EVERYWEEK','Elke week') ;
define('_PICAL_RR_EVERYMONTH','Elke maand') ;
define('_PICAL_RR_EVERYYEAR','Elk jaar') ;
define('_PICAL_RR_FREQDAILY','dagelijks') ;
define('_PICAL_RR_FREQWEEKLY','wekelijks') ;
define('_PICAL_RR_FREQMONTHLY','maandelijks') ;
define('_PICAL_RR_FREQYEARLY','jaarlijks') ;
define('_PICAL_RR_FREQDAILY_PRE','Alle') ;
define('_PICAL_RR_FREQWEEKLY_PRE','Alle') ;
define('_PICAL_RR_FREQMONTHLY_PRE','Alle') ;
define('_PICAL_RR_FREQYEARLY_PRE','Alle') ;
define('_PICAL_RR_FREQDAILY_SUF','Dagen') ;
define('_PICAL_RR_FREQWEEKLY_SUF','Weken') ;
define('_PICAL_RR_FREQMONTHLY_SUF','Maanden') ;
define('_PICAL_RR_FREQYEARLY_SUF','Jaren') ;
define('_PICAL_RR_PERDAY','alle %s dagen') ;
define('_PICAL_RR_PERWEEK','alle %s weken') ;
define('_PICAL_RR_PERMONTH','alle %s maanden') ;
define('_PICAL_RR_PERYEAR','alle %s jaren') ;
define('_PICAL_RR_COUNT','<br />%s-keer') ;
define('_PICAL_RR_UNTIL','<br />tot %s') ;
define('_PICAL_RR_R_NORRULE','weerkerend NEEN') ;
define('_PICAL_RR_R_YESRRULE','weerkerend JA') ;
define('_PICAL_RR_OR','of') ;
define('_PICAL_RR_S_NOTSELECTED','-niet geselecteerd-') ;
define('_PICAL_RR_S_SAMEASBDATE','gelijk aan begin') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','Geen einde') ;
define('_PICAL_RR_R_USECOUNT_PRE','Herhalingen') ;
define('_PICAL_RR_R_USECOUNT_SUF','keer') ;
define('_PICAL_RR_R_USEUNTIL','tot') ;



// Appended by Xoops Language Checker -GIJOE- in 2003-12-05 14:18:43
define('_PICAL_TH_SUBMITTER','Submitter');

// Appended by Xoops Language Checker -GIJOE- in 2003-12-26 10:55:16
define('_PICAL_STRFFMT_DATE_FOR_BLOCK','%d %b');
define('_PICAL_STRFFMT_TIME','%H:%M');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:01
define('_PICAL_FMT_YW','WEEK%2$s %1$s');
define('_PICAL_FMT_WEEKNO','WEEK %s');
define('_PICAL_ICON_LIST','List View');
define('_PICAL_MB_SHOWALLCAT','All Categories');
define('_PICAL_MB_ORDER_ASC','ascending');
define('_PICAL_MB_ORDER_DESC','descending');
define('_PICAL_MB_SORTBY','Sort by:');
define('_PICAL_MB_CURSORTEDBY','Events currently sorted by:');
define('_PICAL_TH_CATEGORIES','Categories');
define('_PICAL_TH_LASTMODIFIED','Last Modified');
define('_PICAL_BTN_PRINT','Print');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-17 18:09:08
define('_PICAL_FMT_YMDO','%4$s%3$s%2$s%1$s');
define('_PICAL_MB_LABEL_CHECKEDITEMS','Checked events are:');
define('_PICAL_MB_LABEL_OUTPUTICS','to be exported in iCalendar');
define('_PICAL_MB_ICALSELECTPLATFORM','Select platform');
define('_PICAL_MB_OP_AFTER','After');
define('_PICAL_MB_OP_BEFORE','Before');
define('_PICAL_MB_OP_ON','On');
define('_PICAL_MB_OP_ALL','All');
define('_PICAL_BTN_IMPORT','Import!');
define('_PICAL_BTN_UPLOAD','Upload!');
define('_PICAL_BTN_EXPORT','Export!');
define('_PICAL_BTN_EXTRACT','Extract');
define('_PICAL_BTN_ADMIT','Admit');
define('_PICAL_BTN_MOVE','Move');
define('_PICAL_BTN_COPY','Copy');

}

?>
