<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2006-11-05 06:41:40
define('_MI_PROXYSETTINGS','Proxy settings (host:port:user:pass)');

// Appended by Xoops Language Checker -GIJOE- in 2006-02-15 05:31:20
define('_MI_PICAL_ADMENU_MYTPLSADMIN','Templates');

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define("_MI_PICAL_NAME", "piCal");

// A brief description of this module
define("_MI_PICAL_DESC", "Module Gestion d'un Calendrier avec Ev&egrave;nemens Programm&eacute;s");

// Appended by Xoops Language Checker -GIJOE- in 2005-01-08 04:36:49
define('_MI_PICAL_DEFAULTLOCALE','france');

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL", "Mini Calendrier");
define("_MI_PICAL_BNAME_MINICAL_DESC", "Affiche le bloc mini calendrier");
define('_MI_PICAL_BNAME_MINICALEX','MiniCalendarEx');
define('_MI_PICAL_BNAME_MINICALEX_DESC','Mini Calendrier Extensible &agrave; syst&egrave;me de plugin');
define("_MI_PICAL_BNAME_MONTHCAL", "Calendrier Mensuel");
define("_MI_PICAL_BNAME_MONTHCAL_DESC", "Affichage complet du calendrier mensuel");
define("_MI_PICAL_BNAME_TODAYS", "Ev&egrave;nements aujourd'hui");
define("_MI_PICAL_BNAME_TODAYS_DESC", "Affiche les &eacute;v&egrave;nements du jour");
define("_MI_PICAL_BNAME_THEDAYS", "Ev&egrave;nements du %s");
define("_MI_PICAL_BNAME_THEDAYS_DESC", "Affiche les &eacute;v&egrave;nements du jour indiqu&eacute;");
define("_MI_PICAL_BNAME_COMING", "Ev&egrave;nements &agrave; venir");
define("_MI_PICAL_BNAME_COMING_DESC", "Affiche les &eacute;v&egrave;nnements &agrave; venir");
define("_MI_PICAL_BNAME_AFTER", "Ev&egrave;nements apr&egrave;s le %s");
define("_MI_PICAL_BNAME_AFTER_DESC", "Affiche les &eacute;v&egrave;nements apr&egrave;s la date indiqu&eacute;e");
define("_MI_PICAL_BNAME_NEW", "Ev&egrave;nements nouvellement post&eacute;s");
define("_MI_PICAL_BNAME_NEW_DESC", "Affiche les «±v«²nements tri«±s de fa«®on, plus r«±cent en premier");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","Soumettre");

//define("_MI_PICAL_ADMENU1","");


// Title of config items
define("_MI_USERS_AUTHORITY", "Droits Utilisateurs");
define("_MI_GUESTS_AUTHORITY", "Droits Invit&eacute;s");
define("_MI_DEFAULT_VIEW", "Vue par d&eacute;faut au centre");
define("_MI_MINICAL_TARGET", "La page s'affiche au centre quand la date du mini calendrier est cliqu&eacute;e");
define("_MI_COMING_NUMROWS", "Le nombre d'&eacute;v&eacute;nements dans le bloc des &eacute;v&eacute;nements &agrave; venir");
define("_MI_SKINFOLDER", "Nom des chemins de skin");
define('_MI_PICAL_LOCALE','Localisation (regarder les fichiers dans locales/*.php)');
define("_MI_SUNDAYCOLOR", "Couleur du Dimanche");
define("_MI_WEEKDAYCOLOR", "Couleur des jours de la semaine");
define("_MI_SATURDAYCOLOR", "Couleur du Samedi");
define("_MI_HOLIDAYCOLOR", "Couleur des vacances");
define("_MI_TARGETDAYCOLOR", "Couleur du jour s&eacute;lectionn&eacute;");
define("_MI_SUNDAYBGCOLOR", "Couleur de fond du Dimanche");
define("_MI_WEEKDAYBGCOLOR", "Couleur de fond des jours de la semaine");
define("_MI_SATURDAYBGCOLOR", "Couleur de fond du Samedi");
define("_MI_HOLIDAYBGCOLOR", "Couleur de fond des vacances");
define("_MI_TARGETDAYBGCOLOR", "Couleur de fond du jour s&eacute;lectionn&eacute;");
define("_MI_CALHEADCOLOR", "Couleur de l'ent&ecirc;te du calendrier");
define("_MI_CALHEADBGCOLOR", "Couleur de fond de l'ent&ecirc;te du calendrier");
define("_MI_CALFRAMECSS", "Style du cadre du calendrier");
define("_MI_CANOUTPUTICS", "Permission d'extraire des fichiers ics");
define("_MI_MAXRRULEEXTRACT", "Limite sup&eacute;rieure d'extraction des &eacute;v&egrave;nements par p&eacute;riodicit&eacute;.(compteur)");
define("_MI_WEEKSTARTFROM", "Jour de d&eacute;but de la semaine");
define("_MI_WEEKNUMBERING", "Nombre de r&egrave;gles pour les semaines");
define("_MI_DAYSTARTFROM", "Bordure pour s&eacute;parer les jours");
define('_MI_TIMEZONE_USING','Fuseau Horaire Serveur');
define('_MI_USE24HOUR','Journ&eacute;e de 24heures (et non pas de 12 heures)');
define("_MI_NAMEORUNAME" , "Affichage du Nom de l'auteur de l'&eacute;v&egrave;nement" ) ;
define("_MI_DESCNAMEORUNAME" , "S&eacute;lectionner quel 'nom' sera affich&eacute;" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "Autoriser les invit&eacute;s &agrave; ajouter des &eacute;v&egrave;nements");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "ne peut pas ajouter");
define("_MI_OPT_AUTH_WAIT", "peut ajouter mais sera mod&eacute;r&eacute;");
define("_MI_OPT_AUTH_POST", "peut ajouter sans mod&eacute;ration");
define("_MI_OPT_AUTH_BYGROUP", "sp&eacute;cifi&eacute; dans les permissions de groupes");
define("_MI_OPT_MINI_PHPSELF", "page courante");
define("_MI_OPT_MINI_MONTHLY", "calendrier mensuel");
define("_MI_OPT_MINI_WEEKLY", "calendrier hebdomadaire");
define("_MI_OPT_MINI_DAILY", "calendrier journalier");
define("_MI_OPT_MINI_LIST", "Liste d'&eacute;v&egrave;nements");
define("_MI_OPT_CANOUTPUTICS", "peut extraire");
define("_MI_OPT_CANNOTOUTPUTICS", "ne peut pas extraire");
define("_MI_OPT_STARTFROMSUN", "Dimanche");
define("_MI_OPT_STARTFROMMON", "Lundi");
define("_MI_OPT_WEEKNOEACHMONTH", "Pour chaque mois");
define("_MI_OPT_WEEKNOWHOLEYEAR", "Par ann&eacute;e enti&egrave;re");
define("_MI_OPT_USENAME" , "Nom r&eacute;el" ) ;
define("_MI_OPT_USEUNAME" , "Nom de Login" ) ;
define('_MI_OPT_TZ_USEXOOPS','Valeur param&eacute;tr&eacute;e dans la configuration XOOPS');
define('_MI_OPT_TZ_USEWINTER','Valeur donn&eacute;e par le serveur = heure d\'hiver (recommand&eacute;)');
define('_MI_OPT_TZ_USESUMMER','Valeur donn&eacute;e par le serveur = heure d\'&eacute;t&eacute;');

// Admin Menus
define("_MI_PICAL_ADMENU0", "Validation d'Ev&egrave;nements");
define("_MI_PICAL_ADMENU1", "Gestionnaire d'Ev&egrave;nements");
define("_MI_PICAL_ADMENU_CAT", "Gestionnaire de Cat&eacute;gories");
define("_MI_PICAL_ADMENU_CAT2GROUP", "Permissions des Cat&eacute;gories");
define("_MI_PICAL_ADMENU2", "Permissions Globales");
define("_MI_PICAL_ADMENU_TM", "Maintenance des Tables");
define("_MI_PICAL_ADMENU_ICAL", "Imports iCalendar");
define('_MI_PICAL_ADMENU_PLUGINS','Gestionnaire de Plugins');
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','Administration des Blocs&Groupes');

//d3comment integration
define("_MI_COM_DIRNAME","Comment integration directory");
define("_MI_COM_DIRNAMEDSC","When use D3-comment integration system. <br/>write your d3forum (html) directory <br/>If you do not use comments or use xoops comment system, leave this in empty.");
define("_MI_COM_FORUM_ID","d3forum_id");
define("_MI_COM_FORUM_IDDSC","When you set above integration diredtory, write forum_id");
define("_MI_COM_ORDER","Order of comment integration");
define("_MI_COM_ORDERDSC","When you set comment integration, select display order of comment posts");
define("_MI_COM_VIEW","View of comment-integration");
define("_MI_COM_VIEWDSC","select flat or thread");
define("_MI_COM_POSTSNUM","'Max posts displayed in comment integration");

// Text for notifications
define('_MI_PICAL_GLOBAL_NOTIFY', 'Globale');
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'Options de notifications globales de piCal.');
define('_MI_PICAL_CATEGORY_NOTIFY', 'Cat&eacute;gorie');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', 'Options de notifications s\'appliquant &agrave; cette categorie.');
define('_MI_PICAL_EVENT_NOTIFY', 'Ev&egrave;nement');
define('_MI_PICAL_EVENT_NOTIFYDSC', 'Options de notifications s\'appliquant &agrave; cet &eacute;v&egrave;nement.');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', 'Nouvel Ev&egrave;nement');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', 'Notifiez-moi quand un nouvel &eacute;v&egrave;nement est cr&eacute;&eacute;.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', 'Recevoir une notification quand un nouvel &eacute;v&egrave;nement est cr&eacute;&eacute;.');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvel &eacute;v&egrave;nement');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'Nouvel &eacute;v&egrave;nement dans la cat&eacute;gorie');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'Notifiez moi quand un nouvel &eacute;v&egrave;nement est cr&eacute;&eacute; dans la Cat&eacute;gorie.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'Recevoir une notification quand un nouvel &eacute;v&egrave;nement est cr&eacute;&eacute; dans la Cat&eacute;gorie.');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvel &eacute;v&egrave;nement dans {CATEGORY_TITLE}');

}

?>
