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
define('_PICAL_DTFMT_TIME','H:i') ;

// set your locale
define('_PICAL_LOCALE','sv_SE') ;
// format for strftime()  see http://jp.php.net/strftime
define('_PICAL_STRFFMT_DATE','%x') ;
define('_PICAL_STRFFMT_DATE_FOR_BLOCK','%d %b') ;
define('_PICAL_STRFFMT_TIME','%H:%M') ;

define('_PICAL_FMT_MD','%2$s %1$s') ;
define('_PICAL_FMT_YMD','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YMW','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YEAR_MONTH','%2$s %1$s') ;
define('_PICAL_FMT_YEAR','<font size="-1">��r </font>%s') ;

define('_PICAL_ICON_DAILY','Dags Vy') ;
define('_PICAL_ICON_WEEKLY','Vecko Vy') ;
define('_PICAL_ICON_MONTHLY','M��ads Vy') ;
define('_PICAL_ICON_YEARLY','��rs Vy') ;

define('_PICAL_MB_LINKTODAY','Idag') ;
define('_PICAL_MB_NOSUBJECT','(Ingen rubrik)') ;

define('_PICAL_MB_PREV_DATE','Imorgon') ;
define('_PICAL_MB_NEXT_DATE','N��ta dag') ;
define('_PICAL_MB_PREV_WEEK','F��ra Veckan') ;
define('_PICAL_MB_NEXT_WEEK','N��ta Vecka') ;
define('_PICAL_MB_PREV_MONTH','F��ra M��aden') ;
define('_PICAL_MB_NEXT_MONTH','N��ta M��ad') ;
define('_PICAL_MB_PREV_YEAR','F��ra ��ret') ;
define('_PICAL_MB_NEXT_YEAR','N��ta ��r') ;

define('_PICAL_MB_NOEVENT','Inga H��delser') ;
define('_PICAL_MB_ADDEVENT','L��g till') ;
define('_PICAL_MB_CONTINUING','(forts)') ;
define('_PICAL_MB_RESTEVENT_PRE','') ;
define('_PICAL_MB_RESTEVENT_SUF','h��delser') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','Heldagsh��delse') ;
define('_PICAL_MB_LONG_EVENT','Visa med linje') ;
define('_PICAL_MB_LONG_SPECIALDAY','Jubileum mm.') ;

define('_PICAL_MB_PUBLIC','Allm��') ;
define('_PICAL_MB_PRIVATE','Privat') ;
define('_PICAL_MB_PRIVATETARGET',' emellan %s') ;

define('_PICAL_MB_LINK_TO_RRULE1ST','G� till f��sta h��delsen ') ;
define('_PICAL_MB_RRULE1ST','Detta �� f��sta h��delsen') ;

define('_PICAL_MB_EVENT_NOTREGISTER','Inte Registrerad') ;
define('_PICAL_MB_EVENT_ADMITTED','Godk��d') ;
define('_PICAL_MB_EVENT_NEEDADMIT','V��tar p� Godk��nade') ;

define('_PICAL_MB_TITLE_EVENTINFO','Schema') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','Detaljer') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','Editera') ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_TH_SUMMARY','H��delse') ;
define('_PICAL_TH_STARTDATETIME','Start Datum & Tid') ;
define('_PICAL_TH_ENDDATETIME','Slut Datum & Tid') ;
define('_PICAL_TH_ALLDAYOPTIONS','Heldagsval') ;
define('_PICAL_TH_LOCATION','Plats') ;
define('_PICAL_TH_CONTACT','Kontaktperson') ;
define('_PICAL_TH_SUBMITTER','Inl��nare') ;
define('_PICAL_TH_CLASS','Klass') ;
define('_PICAL_TH_DESCRIPTION','Beskrivning') ;
define('_PICAL_TH_RRULE','Regler f�� upprepning') ;
define('_PICAL_TH_ADMISSIONSTATUS','Status') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','(Infoga Nummer)') ;
define('_PICAL_NTC_EXTRACTLIMIT','** Endast %s upprepningar lagras som mest.') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(%s h��delser beh��er godk��nas)') ;

define('_PICAL_OPT_PRIVATEMYSELF','Endast mig sj��v') ;
define('_PICAL_OPT_PRIVATEGROUP','grupp %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(ogiltig grupp)') ;

define('_PICAL_CNFM_SAVEAS_YN','��r det OK att spara som en ny h��delse ?') ;
define('_PICAL_CNFM_DELETE_YN','��r det OK att radera denna h��delse ?') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Fel: EventID hittades inte') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"Fel: Ni har inte r��tighet att visa") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"Fel: Ni har inte r��tighet att generera iCalendar") ;
define('_PICAL_ERR_LACKINDISPITEM','F��tet %s �� tomt.<br />G� tillbaka genom att klicka p� knapp i webbl��aren') ;

define('_PICAL_BTN_JUMP','G� till') ;
define('_PICAL_BTN_NEWINSERTED','Infoga') ;
define('_PICAL_BTN_SUBMITCHANGES','Spara ��dring') ;
define('_PICAL_BTN_SAVEAS','Spara kopia') ;
define('_PICAL_BTN_DELETE','Radera') ;
define('_PICAL_BTN_EDITEVENT','Editera') ;
define('_PICAL_BTN_RESET','Rensa') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;

define('_PICAL_RR_EVERYDAY','Varje dag') ;
define('_PICAL_RR_EVERYWEEK','Varje vecka') ;
define('_PICAL_RR_EVERYMONTH','Varje m��ad') ;
define('_PICAL_RR_EVERYYEAR','Varje ��') ;
define('_PICAL_RR_FREQDAILY','Dagligen') ;
define('_PICAL_RR_FREQWEEKLY','Veckovis') ;
define('_PICAL_RR_FREQMONTHLY','M��adsvis') ;
define('_PICAL_RR_FREQYEARLY','��rsvis') ;
define('_PICAL_RR_FREQDAILY_PRE','Var ') ;
define('_PICAL_RR_FREQWEEKLY_PRE','Var ') ;
define('_PICAL_RR_FREQMONTHLY_PRE','Var ') ;
define('_PICAL_RR_FREQYEARLY_PRE','Var ') ;
define('_PICAL_RR_FREQDAILY_SUF','dag(ar)') ;
define('_PICAL_RR_FREQWEEKLY_SUF','vecka') ;
define('_PICAL_RR_FREQMONTHLY_SUF','M��ad') ;
define('_PICAL_RR_FREQYEARLY_SUF','��r') ;
define('_PICAL_RR_PERDAY','varje %s dagar') ;
define('_PICAL_RR_PERWEEK','varje %s veckor') ;
define('_PICAL_RR_PERMONTH','varje %s m��ader') ;
define('_PICAL_RR_PERYEAR','varje %s ��') ;
define('_PICAL_RR_COUNT','<br />%s g��ger') ;
define('_PICAL_RR_UNTIL','<br />framtill %s') ;
define('_PICAL_RR_R_NORRULE','Inte ��erkommande') ;
define('_PICAL_RR_R_YESRRULE','��terkommande') ;
define('_PICAL_RR_OR','eller') ;
define('_PICAL_RR_S_NOTSELECTED','-inget valt-') ;
define('_PICAL_RR_S_SAMEASBDATE','Samma som start datum') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','Ingen slutdatum') ;
define('_PICAL_RR_R_USECOUNT_PRE','upprepningar') ;
define('_PICAL_RR_R_USECOUNT_SUF','g��ger') ;
define('_PICAL_RR_R_USEUNTIL','framtill') ;


// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:01
define('_PICAL_FMT_YW','Vecka%2$s %1$s');
define('_PICAL_FMT_WEEKNO','Vecka %s');
define('_PICAL_ICON_LIST','List Vy');
define('_PICAL_MB_SHOWALLCAT','Alla Kategorier');
define('_PICAL_MB_ORDER_ASC','Stigande');
define('_PICAL_MB_ORDER_DESC','Fallande');
define('_PICAL_MB_SORTBY','Sorterad efter:');
define('_PICAL_MB_CURSORTEDBY','H��delserna �� sorterade efter:');
define('_PICAL_TH_CATEGORIES','Kategorier');
define('_PICAL_TH_LASTMODIFIED','Senast ��drad');
define('_PICAL_BTN_PRINT','Skriv ut');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-17 18:09:09
define('_PICAL_FMT_YMDO','%4$s%3$s%2$s%1$s');
define('_PICAL_MB_LABEL_CHECKEDITEMS','Markerade h��delser ');
define('_PICAL_MB_LABEL_OUTPUTICS','kommer att bli exporterade till iCalendar');
define('_PICAL_MB_ICALSELECTPLATFORM','V��j plattform');
define('_PICAL_MB_OP_AFTER','Efter');
define('_PICAL_MB_OP_BEFORE','F��e');
define('_PICAL_MB_OP_ON','P�');
define('_PICAL_MB_OP_ALL','Alla');
define('_PICAL_BTN_IMPORT','Importera!');
define('_PICAL_BTN_UPLOAD','Ladda upp!');
define('_PICAL_BTN_EXPORT','Exportera!');
define('_PICAL_BTN_EXTRACT','Packa upp');
define('_PICAL_BTN_ADMIT','Till��');
define('_PICAL_BTN_MOVE','Flytta');
define('_PICAL_BTN_COPY','Kopiera');

}

?>