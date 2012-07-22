<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2005-05-17 17:34:01
define('_PICAL_BTN_DELETE_ONE','Remove just one');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:14
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
define('_PICAL_LOCALE','it_IT') ;
// format for strftime()  see http://jp.php.net/strftime
define('_PICAL_STRFFMT_DATE','%d %b %Y (%a)') ;
define('_PICAL_STRFFMT_DATE_FOR_BLOCK','%d %b') ;
define('_PICAL_STRFFMT_TIME','%H:%M') ;

// definition of orders     Y:year  M:month  W:week  D:day  O:operand
define('_PICAL_FMT_MD','%2$s %1$s') ;
define('_PICAL_FMT_YMD','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YMDO','%4$s%3$s%2$s%1$s') ;
define('_PICAL_FMT_YMW','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YW','SETTIMANA%2$s %1$s') ;
define('_PICAL_FMT_YEAR_MONTH','%2$s %1$s') ;
define('_PICAL_FMT_YEAR','<font size="-1">ANNO </font>%s') ;
define('_PICAL_FMT_WEEKNO','SETTIMANA %s') ;

define('_PICAL_ICON_LIST','Elenco') ;
define('_PICAL_ICON_DAILY','Giornaliero') ;
define('_PICAL_ICON_WEEKLY','Settimanale') ;
define('_PICAL_ICON_MONTHLY','Mensile') ;
define('_PICAL_ICON_YEARLY','Annuale') ;

define('_PICAL_MB_SHOWALLCAT','Tutte le categorie') ;

define('_PICAL_MB_LINKTODAY','Oggi') ;
define('_PICAL_MB_NOSUBJECT','(senza titolo)') ;

define('_PICAL_MB_PREV_DATE','Ieri') ;
define('_PICAL_MB_NEXT_DATE','Domani') ;
define('_PICAL_MB_PREV_WEEK','Settimana Precedente') ;
define('_PICAL_MB_NEXT_WEEK','Settimana Successiva') ;
define('_PICAL_MB_PREV_MONTH','Mese Precedente') ;
define('_PICAL_MB_NEXT_MONTH','Mese Successivo') ;
define('_PICAL_MB_PREV_YEAR','Anno Precedente') ;
define('_PICAL_MB_NEXT_YEAR','Anno Successivo') ;

define('_PICAL_MB_NOEVENT','Nessun evento') ;
define('_PICAL_MB_ADDEVENT','Aggiungi un evento') ;
define('_PICAL_MB_CONTINUING','(continua)') ;
define('_PICAL_MB_RESTEVENT_PRE','altri') ;
define('_PICAL_MB_RESTEVENT_SUF','eventi') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','Tutto-il-giorno') ;
define('_PICAL_MB_LONG_EVENT','Mostra come barra') ;
define('_PICAL_MB_LONG_SPECIALDAY','Anniversario, ecc.') ;

define('_PICAL_MB_PUBLIC','Pubblica') ;
define('_PICAL_MB_PRIVATE','Privato') ;
define('_PICAL_MB_PRIVATETARGET',' per %s') ;

define('_PICAL_MB_LINK_TO_RRULE1ST','Vai al primo evento ') ;
define('_PICAL_MB_RRULE1ST','Questo è il primo evento') ;

define('_PICAL_MB_EVENT_NOTREGISTER','Non Registrato') ;
define('_PICAL_MB_EVENT_ADMITTED','Approvato') ;
define('_PICAL_MB_EVENT_NEEDADMIT','In attesa di approvazione') ;

define('_PICAL_MB_TITLE_EVENTINFO','Pianificazione eventi') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','Lista dettagliata') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','Modifica') ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_MB_ORDER_ASC','ascendente') ;
define('_PICAL_MB_ORDER_DESC','discendente') ;
define('_PICAL_MB_SORTBY','Ordina per:') ;
define('_PICAL_MB_CURSORTEDBY','Eventi ordinati per:') ;

define("_PICAL_MB_LABEL_CHECKEDITEMS","Gli eventi selezionati sono:");
define("_PICAL_MB_LABEL_OUTPUTICS","da esportare in iCalendar");

define("_PICAL_MB_ICALSELECTPLATFORM","Seleziona la piattaforma");

define('_PICAL_TH_SUMMARY','Sommario') ;
define('_PICAL_TH_STARTDATETIME','DataOra Inizio') ;
define('_PICAL_TH_ENDDATETIME','DataOra Fine') ;
define('_PICAL_TH_ALLDAYOPTIONS','Opzioni di tutto-il-giorno') ;
define('_PICAL_TH_LOCATION','Luogo') ;
define('_PICAL_TH_CONTACT','Contatto') ;
define('_PICAL_TH_CATEGORIES','Categorie') ;
define('_PICAL_TH_SUBMITTER','Inviato da') ;
define('_PICAL_TH_CLASS','Tipologia') ;
define('_PICAL_TH_DESCRIPTION','Descrizione') ;
define('_PICAL_TH_RRULE','Ricorrenza') ;
define('_PICAL_TH_ADMISSIONSTATUS','Stato') ;
define('_PICAL_TH_LASTMODIFIED','Ultima modifica') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','(Inserisci il numero)') ;
define('_PICAL_NTC_EXTRACTLIMIT','** Solo %s eventi sono estratti al massimo.') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(%s eventi da approvare)') ;

define('_PICAL_OPT_PRIVATEMYSELF','solo per me') ;
define('_PICAL_OPT_PRIVATEGROUP','gruppo %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(gruppo invalido)') ;

define('_PICAL_MB_OP_AFTER','Dopo') ;
define('_PICAL_MB_OP_BEFORE','Prima') ;
define('_PICAL_MB_OP_ON','il') ;
define('_PICAL_MB_OP_ALL','tutto') ;

define('_PICAL_CNFM_SAVEAS_YN','Confermi salvataggio come un altro evento?') ;
define('_PICAL_CNFM_DELETE_YN','Confermi eliminazione di questo evento?') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Errore: EventID non trovato') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"Errore: Non hai i privilegi per visualizzare") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"Errore: Non hai i privilegi per esportare iCalendar") ;
define('_PICAL_ERR_LACKINDISPITEM','L\'evento %s è vuoto.<br />Premi il pulsante \'indietro\' del browser!') ;

define('_PICAL_BTN_JUMP','Vai') ;
define('_PICAL_BTN_NEWINSERTED','Nuovo inserimento') ;
define('_PICAL_BTN_SUBMITCHANGES',' Modifica! ') ;
define('_PICAL_BTN_SAVEAS','Salva come') ;
define('_PICAL_BTN_DELETE','Cancella') ;
define('_PICAL_BTN_EDITEVENT','Modifica') ;
define('_PICAL_BTN_RESET','Reimposta') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;
define('_PICAL_BTN_PRINT','Stampa') ;
define("_PICAL_BTN_IMPORT","Importa!");
define("_PICAL_BTN_UPLOAD","Upload!");
define("_PICAL_BTN_EXPORT","Esporta!");
define("_PICAL_BTN_EXTRACT","Estrai");
define("_PICAL_BTN_ADMIT","Approva");
define("_PICAL_BTN_MOVE","Muovi");
define("_PICAL_BTN_COPY","Copia");

define('_PICAL_RR_EVERYDAY','Tutti i giorni') ;
define('_PICAL_RR_EVERYWEEK','Tutte le settimane') ;
define('_PICAL_RR_EVERYMONTH','Tutti i mesi') ;
define('_PICAL_RR_EVERYYEAR','Tutti gli anni') ;
define('_PICAL_RR_FREQDAILY','Giornaliero') ;
define('_PICAL_RR_FREQWEEKLY','Settimanale') ;
define('_PICAL_RR_FREQMONTHLY','Mensile') ;
define('_PICAL_RR_FREQYEARLY','Annuale') ;
define('_PICAL_RR_FREQDAILY_PRE','Ogni') ;
define('_PICAL_RR_FREQWEEKLY_PRE','Ogni') ;
define('_PICAL_RR_FREQMONTHLY_PRE','Ogni') ;
define('_PICAL_RR_FREQYEARLY_PRE','Ogni') ;
define('_PICAL_RR_FREQDAILY_SUF','giorni') ;
define('_PICAL_RR_FREQWEEKLY_SUF','settimane') ;
define('_PICAL_RR_FREQMONTHLY_SUF','mesi') ;
define('_PICAL_RR_FREQYEARLY_SUF','anni') ;
define('_PICAL_RR_PERDAY','ogni %s giorni') ;
define('_PICAL_RR_PERWEEK','ogni %s settimane') ;
define('_PICAL_RR_PERMONTH','ogni %s mesi') ;
define('_PICAL_RR_PERYEAR','ogni %s anni') ;
define('_PICAL_RR_COUNT','<br />%s volte') ;
define('_PICAL_RR_UNTIL','<br />fino al %s') ;
define('_PICAL_RR_R_NORRULE','Non Ricorrente') ;
define('_PICAL_RR_R_YESRRULE','Ricorrente') ;
define('_PICAL_RR_OR','or') ;
define('_PICAL_RR_S_NOTSELECTED','-non selezionato-') ;
define('_PICAL_RR_S_SAMEASBDATE','Stessa della data di inizio') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','Nessuna condizione di fine evento') ;
define('_PICAL_RR_R_USECOUNT_PRE','ripeti') ;
define('_PICAL_RR_R_USECOUNT_SUF','volte') ;
define('_PICAL_RR_R_USEUNTIL','fino al') ;

}

?>
