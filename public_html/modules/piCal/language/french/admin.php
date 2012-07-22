<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {


// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:48
define('_AM_PICAL_DBUPDATED','Database Updated Successfully!');
define('_AM_PICAL_PERMADDNG','Could not add %s permission to %s for group %s');
define('_AM_PICAL_PERMADDOK','Added %s permission to %s for group %s');
define('_AM_PICAL_PERMRESETNG','Could not reset group permission for module %s');
define('_AM_PICAL_PERMADDNGP','All parent items must be selected.');

define( 'PICAL_AM_LOADED' , 1 ) ;

// titles
define("_AM_ADMISSION","Ev&egrave;nements approuv&eacute;s");
define("_AM_MENU_EVENTS","Gestionnaire d'&eacute;v&egrave;nements");
define("_AM_MENU_CATEGORIES","Gestionnaire de cat&eacute;gories");
define("_AM_MENU_CAT2GROUP","Permissions des cat&eacute;gories");
define("_AM_ICALENDAR_IMPORT","Imports iCalendar");
define("_AM_GROUPPERM","Permissions Globlales");
define("_AM_TABLEMAINTAIN","Maintenance des tables (Mise &agrave; jour)");
define("_AM_MYBLOCKSADMIN","Admin des blocs et groupes de piCal");

// forms
define("_AM_BUTTON_EXTRACT","Extraire");
define("_AM_BUTTON_ADMIT","Accepter");
define("_AM_BUTTON_MOVE","D&eacute;placer");
define("_AM_BUTTON_COPY","Copier");
define("_AM_CONFIRM_DELETE","Supprimer le(s) &eacute;v&egrave;nement(s) OK?");
define("_AM_CONFIRM_MOVE","Retirer le lien de l'ancienne cat&eacute;gorie et ajouter un lien dans la cat&eacute;gorie sp&eacute;cifi&eacute;e OK?");
define("_AM_CONFIRM_COPY","Ajouter un lien dans la cat&eacute;gorie sp&eacute;cifi&eacute;e OK?");
define('_AM_OPT_PAST','Pass&eacute;s');
define('_AM_OPT_FUTURE','Futurs');
define('_AM_OPT_PASTANDFUTURE','Pass&eacute;s&Futurs');

// format
define("_AM_DTFMT_LIST_ALLDAY",'y-m-d');
define("_AM_DTFMT_LIST_NORMAL",'y-m-d<\b\r />H:i');

// timezones
define('_AM_TZOPT_SERVER','A l\'heure du fuseau horaire du serveur');
define('_AM_TZOPT_GMT','A l\'heure GMT');
define('_AM_TZOPT_USER','A l\'heure du fuseau horaire de l\'utilisateur');

define("_AM_FMT_SERVER_TZ_ALL","Les Fuseau Horaire du Serveur (heure d'hiver) est: %+2.1f<br />Le Fuseau Horaire du Serveur (heure d'&eacute;t&eacute;) est : %+2.1f<br />Le Nom de la zone du serveur est: %s<br />La valeur issue de la configuration de XOOPS est: %+2.1f<br />La valeur que Pical utilise est: %+2.1f<br />");


// admission
define("_AM_LABEL_ADMIT","Les &eacute;v&egrave;nements v&eacute;rifi&eacute;s sont au statut : &agrave; approuver ");
define("_AM_MES_ADMITTED","Ev&egrave;nement(s) a(ont) &eacute;t&eacute; approuv&eacute;(s)");
define("_AM_ADMIT_TH0","Utilisateur");
define("_AM_ADMIT_TH1","Heure de d&eacute;but");
define("_AM_ADMIT_TH2","Heure de fin");
define("_AM_ADMIT_TH3","Titre");
define("_AM_ADMIT_TH4","P&eacute;riodicit&eacute;");

// events manager & importing iCalendar

define("_AM_LABEL_IMPORTFROMWEB","Importer les donn&eacute;es d'iCalendar &agrave; partir du web (Rentrer l'URL en commençant par 'http://' ou 'webcal://')");
define("_AM_LABEL_UPLOADFROMFILE","T&eacute;l&eacute;charger les donn&eacute;es d'iCalendar (S&eacute;lectionner un fichier en local sur votre machine)");
define("_AM_LABEL_IO_CHECKEDITEMS","Les &eacute;v&egrave;nements v&eacute;rifi&eacute;s sont : ");
define("_AM_LABEL_IO_OUTPUT"," &agrave; exporter dans iCalendar");
define("_AM_LABEL_IO_DELETE"," &agrave; supprimer ");
define("_AM_MES_EVENTLINKTOCAT","&eacute;v&egrave;nement(s) ont &eacute;t&eacute; li&eacute;(s) &agrave; cette cat&eacute;gorie");
define("_AM_MES_EVENTUNLINKED","&eacute;v&egrave;nement(s) ont eu leur(s) lien(s) supprim&eacute; de l'ancienne cat&eacute;gorie");
define("_AM_FMT_IMPORTED","&eacute;v&egrave;nement(s) ont &eacute;t&eacute; import&eacute;(s) depuis '%s'");
define("_AM_MES_DELETED","&eacute;v&egrave;nement(s) ont &eacute;t&eacute; supprim&eacute;(s)");
define("_AM_IO_TH0","Utilisateur");
define("_AM_IO_TH1","Date et heure de d&eacute;but");
define("_AM_IO_TH2","Date et heure de fin");
define("_AM_IO_TH3","Titre");
define("_AM_IO_TH4","R&egrave;gles");
define("_AM_IO_TH5","Admission");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "peut ajouter" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "super ajout" ) ;
define( '_AM_GPERM_G_EDITABLE' , "peut &eacute;diter" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "super &eacute;dition" ) ;
define( '_AM_GPERM_G_DELETABLE' , "peut supprimer" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "super suppression" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "peut modifier les autres" ) ;
define( '_AM_CAT2GROUPDESC' , "Cochez les cat&eacute;gories auxquelles vous pouvez acc&eacute;der" ) ;
define( '_AM_GROUPPERMDESC' , "S&eacute;lectionner les actions que tous les groupes sont autoris&eacute;s &agrave; faire<br/>Si vous avez besoin de ce dispositif, d&eacute;finissez d'abord les 'Droits Utilisateurs' &agrave; Sp&eacute;cifier dans les permissions des groupes.<br />Les r&eacute;glages des groupes administrateurs et invit&eacute;s seront ignor&eacute;s." ) ;

// Table Maintenance
define( '_AM_MB_SUCCESSUPDATETABLE' , "La mise &agrave; jour de la(des) table(s) a &eacute;t&eacute; effectu&eacute;e avec succ&egrave;s" ) ;
define( '_AM_MB_FAILUPDATETABLE' , "La mise &agrave; jour de la(des) table(s) a &eacute;chou&eacute;" ) ;
define( '_AM_NOTICE_NOERRORS' , "Aucune erreur d&eacute;tect&eacute;e dans les tables et les enregistrements." ) ;
define( '_AM_ALRT_CATTABLENOTEXIST' , "La table cat&eacute;gories n'existe pas.<br />\nVoulez-vous cr&eacute;er cette table ?" ) ;
define( '_AM_ALRT_OLDTABLE' , "La structure de la table &egrave;venements est ancienne.<br />\nVoulez-vous mettre &agrave; jour la table ?" ) ;
define( '_AM_ALRT_TOOOLDTABLE' , "La table retourne une erreur.<br />\nPeut-&ecirc;tre utilisiez vous piCal 0.3x ou pr&eacute;c&eacute;dent.<br />\nPremi&egrave;rement, Mettez &agrave; jour vers 0.4x or 0.5x." ) ;
define( '_AM_FMT_WRONGSTZ' , "Il y a %s &eacute;v&egrave;nement(s) qui sont enregistr&eacute;(s) avec un mauvais fuseau horaire.<br />Voulez-vous les r&eacute;parer ?" ) ;
define('_AM_TH_SERVER_TZ_COUNT','Ev&egrave;nements');
define('_AM_TH_SERVER_TZ_VALUE','Fuseau Horaire');
define('_AM_TH_SERVER_TZ_VALUE_TO','Modifications (-14.0¡+14.0)');
define('_AM_JSALRT_SERVER_TZ','N\'oubliez pas de sauvegarder la table des &eacute;v&egrave;nements avant de r&eacute;aliser cette op&eacute;ration');
define('_AM_NOTICE_SERVER_TZ','Si votre serveur d&eacute;finit les fuseaux horaires  avec l\'heure d\'&eacute;t&eacute; (= sauvegarde &agrave; l\'heure solaire) et que quelques &eacute;v&egrave;nements &eacute;taient enregistr&eacute;s sous piCal 0.6x ou 0.7x, n\'appuyer pas sur ce bouton.<br />eg) Il est naturel d\'afficher les deux -5.0 et -4.0 en EDT (Eastern Daylight Time)');
define('_AM_MB_SUCCESSTZUPDATE','Les &eacute;v&egrave;nements ont &eacute;t&eacute; modifi&eacute;s avec leur(s fuseau(x) horaires(s).');

// Categories
define( '_AM_CAT_TH_TITLE' , 'Titre' ) ;
define( '_AM_CAT_TH_DESC' , 'Description' ) ;
define( '_AM_CAT_TH_PARENT' , 'Cat&eacute;gorie parente' ) ;
define( '_AM_CAT_TH_OPTIONS' , 'Options' ) ;
define( '_AM_CAT_TH_LASTMODIFY' , 'Derni&egrave;re modification' ) ;
define( '_AM_CAT_TH_OPERATION' , 'Operation' ) ;
define( '_AM_CAT_TH_ENABLED' , 'permettre' ) ;
define( '_AM_CAT_TH_WEIGHT' , 'Poids' ) ;
define( '_AM_CAT_TH_SUBMENU' , 'Enregistrer dans un sous-menu' ) ;
define( '_AM_BTN_UPDATE' , 'Mise &agrave; jour' ) ;
define( '_AM_MENU_CAT_EDIT' , 'Editer une Cat&eacute;gorie' ) ;
define( '_AM_MENU_CAT_NEW' , 'Cr&eacute;er une nouvelle Categorie' ) ;
define( '_AM_MB_MAKESUBCAT' , 'Sous-cat&eacute;gorie' ) ;
define( '_AM_MB_MAKETOPCAT' , 'Cr&eacute;er une cat&eacute;gorie dans un niveau sup&eacute;rieur' ) ;
define( '_AM_MB_CAT_INSERTED' , 'Nouvelle cat&eacute;gorie cr&eacute;&eacute;e' ) ;
define( '_AM_MB_CAT_UPDATED' , 'Cat&eacute;gorie mise &agrave; jour' ) ;
define( '_AM_FMT_CAT_DELETED' , '%s Cat&eacute;gories supprim&eacute;s' ) ;
define( '_AM_FMT_CAT_BATCHUPDATED' , '%s Cat&eacute;gories mises &agrave; jour' ) ;
define( '_AM_FMT_CATDELCONFIRM' , 'Voulez-vous suprimer ces cat&eacute;gories ?' ) ;


// Plugins
define('_AM_PI_UPDATED','Les Plugins sont &agrave; jour');
define('_AM_PI_TH_TYPE','Type');
define( '_AM_PI_TH_OPTIONS' , 'Options (Habituellement &agrave; blanc)' ) ;
define('_AM_PI_TH_TITLE','Titre');
define('_AM_PI_TH_DIRNAME','R&eacute;pertoire du Module');
define('_AM_PI_TH_FILE','Fichier du Plugin');
define('_AM_PI_TH_DOTGIF','Dot GIF');
define('_AM_PI_TH_OPERATION','Op&eacute;ration');
define('_AM_PI_ENABLED','Activ&eacute;');
define('_AM_PI_DELETE','Supprimer');
define('_AM_PI_NEW','Nouveau');
define('_AM_PI_VIEWYEARLY','Vue Ann&eacute;e');
define('_AM_PI_VIEWMONTHLY','Vue Mois');
define('_AM_PI_VIEWWEEKLY','Vue Semaine');
define('_AM_PI_VIEWDAILY','Vue Jour');

}

?>