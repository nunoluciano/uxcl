<?php

// CSS EXPORT
define('_MD_DBCSS_H2INPORT','CSS import');
define('_MD_DBCSS_LABEL_INPORT','Select the CSS file to import.');
define('_MD_DBCSS_LABEL_CSS_DIR','Upload destination (specify a directory)');
define('_MD_DBCSS_CSS_NODIR','The directory defined in "Uploading destination" was not found.');
define('_MD_DBCSS_CSS_NOWRITABLE','Change to writable, please, the settings of directory defined in  "Upload destination". ');
define('_MD_DBCSS_CSS_DIR_NONE','The directory defined in "Uploading destination" was not found. ');
define('_MD_DBCSS_INPORTDESC','The import can be easily done by making the CSS file DB template. <br />The up-loaded CSS file is saved in the default template set.<br>Moreover, it is also possible to select an arbitrary template set in addition to default and to do the import.<br />Please use it for the directory after writing and permitting at the up-loading destination. ');
define('_MD_DBCSS_CSS_DIR_NOWRITABLE','Please confirm the permissions of directory at the up-loading destination.');
define('_MD_DBCSS_INSERTTEMPLATEERROR','The error occurred, and it was not possible to save to DB. File name: %s');
define('_MD_DBCSS_INPORTED','import was completed.');
define('_MD_DBCSS_UPLOADERROR','Failed to upload. Extension');
define('_MD_DBCSS_UPLOADEXITERROR','Impossible to upload.');
define('_MD_DBCSS_UPLOADE_ERROR','Failed to upload.');
define('_MD_DBCSS_UPLOADED','updated was completed.');
define('_MD_DBCSS_H2EXPORT','CSS export');
define('_MD_DBCSS_TH_CSSNAME','Template name');
define('_MD_DBCSS_TH_ORIGINALFILE','Original file');
define('_MD_DBCSS_TH_TPLSETS','Template set');
define('_MD_DBCSS_LABEL_SELECTTPLSETS','Select the Template Set:');
define('_MD_DBCSS_BTN_EXPORT','Export');
define('_MD_DBCSS_CONFIRM_EXPORT','May I export?');
define('_MD_DBCSS_EXPORTTED','The export was completed.');
define('_MD_DBCSS_EXPORT_ERROR','Failed to export.');
define('_MD_DBCSS_EXPORT_CHECK_NONE','Please specify the exporting template.');
define('_MD_DBCSS_EXPORT_DIR_NONE','The directory to export was not found.');
define('_MD_DBCSS_EXPORT_DIR_NONEWRITABLE','Please set write  permissions of the directory to export.');
define('_MD_DBCSS_EXPORT_DIR','Defaul Directory to export');
define('_MD_DBCSS_EXPORTDESC','The CSS template saved into DB can be exported as CSS file. <br />Please use it after specifying the directory by "General setting" the export ahead, and 
writing and permitting.<br /> When the directory is saved the export each template ahead, it fills in by the form similar to a general setting, and it transmits.');
define('_MD_DBCSS_EXPORT_NODIR','The directory to export was not found.');
define('_MD_DBCSS_EXPORT_NOWRITABLE','Please write and set permissions of the directory to export.');
define('_MD_DBCSS_MYEXPORT_DIR','Directory to Export');
define('_MD_DBCSS_LABEL_EXPORT_DIR','Export each template.');
define('_MD_DBCSS_BTN_COPYTPL','Copy execution');
define('_MD_DBCSS_LABEL_COPYTPLSETS','Copy destination');
define('_MD_DBCSS_COPY_CHECK_NONE','Please specify the Template Set of template to copy and destination.');
define('_MD_DBCSS_COPYED','The copy was completed.');
define('_MD_DBCSS_COPYTEMPLATEERROR','It failed in the copy. ID: %s');
define('_MD_DBCSS_COPYABORT','The copy process was interrupted because the original and destination are the same.');
define('_MD_DBCSS_CONFIRM_COPY','May I copy it?');
define('_MD_DBCSS_LABEL_TPLRIGHTCHECKED','The checked template:');
define('_MD_DBCSS_CONFIRM_DELETETPL','May I delete the template?');
define('_MD_DBCSS_DELETE_CHECK_NONE','Please specify the deleted template.');
define('_MD_DBCSS_H2DOWNLOAD','CSS download');
define('_MD_DBCSS_BTN_ZIPDOWNLOAD','zip');
define('_MD_DBCSS_BTN_TARDOWNLOAD','tar.gz');
define('_MD_DBCSS_LABEL_DOWNLOADTPLSETS','Download each Template Set');
define('_MD_DBCSS_DOWNLOADERROR','Please select the Template Set to download.');
define('_MD_DBCSS_MYTPLSFORM_EDIT','Template edit');
define('_MD_DBCSS_MYTPLSFORM_BTN_MODIFYCONT','Update and still editing');
define('_MD_DBCSS_MYTPLSFORM_BTN_MODIFYEND','Update and Save');
define('_MD_DBCSS_MYTPLSFORM_BTN_RESET','Reset');
define('_MD_DBCSS_MYTPLSFORM_UPDATED','Updating the Template.');

// META tag management
define('_MD_DBCSS_H2METALINK','META tag management');
define('_MD_DBCSS_TH_MID','MID');
define('_MD_DBCSS_TH_MODULE','Modules');
define('_MD_DBCSS_TH_DIRNAME','Directory');
define('_MD_DBCSS_TH_EDIT','Edit');
define('_MD_DBCSS_METAEDITDESC','As for the item made an empty column, the value set by a general setting is 
applied. ');
define('_MD_DBCSS_METAEDITBLOCKDESC','The item set here is reflected only in the module that sets "META tag hook block<br />Make a directory XOOPS_TRUST_PATH/cache and change the mode writable.". ');
define('_MD_DBCSS_METAKEY','Meta Keywords');
define('_MD_DBCSS_METAKEYDESC','The keywords meta tag is a series of keywords that represents the content of your site. Type in keywords with each separated by a comma or a space. (Ex. XOOPS, PHP, mySQL, portal system)');
define('_MD_DBCSS_METADESC','Meta Description');
define('_MD_DBCSS_METADESCDESC','The description meta tag is a general description of what is contained in your web page');
define('_MD_DBCSS_METAROBOTS','Meta Robots');
define('_MD_DBCSS_METAROBOTSDESC','The Robots Tag declares to search engines what content to index and spider');
define('_MD_DBCSS_METARATING','Meta Rating');
define('_MD_DBCSS_METARATINGDESC','The rating meta tag defines your site age and content rating');
define('_MD_DBCSS_METAAUTHOR','Meta Author');
define('_MD_DBCSS_METAAUTHORDESC','The author meta tag defines the name of the author of the document being read. Supported data formats include the name, email address of the webmaster, company name or URL.');
define('_MD_DBCSS_METACACHE_TIME','At the file cash date');
define('_MD_DBCSS_METANOCACHE','File cash unmaking');
define('_MD_DBCSS_METAEDITTITLE','META tag Edit');
define('_MD_DBCSS_BTN_SUBMITEDITING','Save');
define('_MD_DBCSS_BTN_CANSEL','Cancel');
define('_MD_DBCSS_MSG_CONFIRMDELETECONTENT','May I delete the content of registration?');
define('_MD_DBCSS_NO_DATA','There is no saved data.');
define('_MD_DBCSS_MODULE_NOTFOUND','The module is not found.');
define('_MD_DBCSS_REGSTERED','Saving. ');
define('_MD_DBCSS_DELETED','Deleted. ');
define('_MD_DBCSS_NONDELETED','There is no deleted data.');
define('_MD_DBCSS_LABEL_PERPAGE','Number of modules displayed on page 1:');

// SCRIPT tag management
define('_MD_DBCSS_H2SCRIPTLINK','External script tag edit');
define('_MD_DBCSS_NEW','New making');
define('_MD_DBCSS_TH_CONTENTSACTIONS','Action');
define('_MD_DBCSS_TH_ID','ID');
define('_MD_DBCSS_TH_TITLE','Title');
define('_MD_DBCSS_TH_CREATED','At the date');
define('_MD_DBCSS_LABEL_CONTENTSRIGHTCHECKED','The checked data:');
define('_MD_DBCSS_BTN_DELETE','Delete');
define('_MD_DBCSS_BTN_COPY','Save as... ');
define('_MD_DBCSS_SCRIPTEDITBLOCKDESC','Necessary tag for an external script in head of theme.html can be inserted. <br />The problem of security there, too and being able to set here are only the scripts that exist in XOOPS URL or less. <br />The item set here is reflected only in the page that sets "SCRIPT tag hook block". ');
define('_MD_DBCSS_CONFIRM_DELETE','May I delete the content of registration?');
define('_MD_DBCSS_MSG_CONFIRMCOPYCONTENT','Save the content as another data?');
define('_MD_DBCSS_SCRIPTEDITTITLE','External script tag edit');
define('_MD_DBCSS_SCRIPTBODY','Passing of external script<br /><br />It specifies it by passing at the installation destination of XOOPS. Please change line and fill it in every one line when there are two or more external scripts.<br /><br />Setting example: Javascript/exsample.js(the first / unnecessary)');
define('_MD_DBCSS_SCRIPTCSS','Css of external script<br /><br />Necessary CSS for an external script is specified by passing at the installation destination of XOOPS. (Please change line and fill it in every one line when there are two or more CSS. )<br /><br />Setting example: Javascript/exsample.css(the first / unnecessary)');
define('_MD_DBCSS_SCRIPTCACHE_TIME','At the file cash date');
define('_MD_DBCSS_SCRIPTNOCACHE','File cash unmaking');
define('_MD_DBCSS_SUBJECT','Please input the title. ');
define('_MD_DBCSS_BODY','Please input passing an external script. ');

// ERROR MESSEAGE
define('_MD_DBCSS_ERROR_MESSEAGE','The error occurred ID: %s');
define('_MD_DBCSS_ERROR_MESSEAGE_NOID','The error occurred.');

?>