<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {






// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:48
define('_AM_PICAL_DBUPDATED','Database Updated Successfully!');
define('_AM_PICAL_PERMADDNG','Could not add %s permission to %s for group %s');
define('_AM_PICAL_PERMADDOK','Added %s permission to %s for group %s');
define('_AM_PICAL_PERMRESETNG','Could not reset group permission for module %s');
define('_AM_PICAL_PERMADDNGP','All parent items must be selected.');

// Appended by Xoops Language Checker -GIJOE- in 2005-06-29 17:19:32
define('_AM_PI_TH_OPTIONS','Options (usually blank)');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-24 19:05:06
define('_AM_TZOPT_SERVER','As server timezone');
define('_AM_TZOPT_GMT','As GMT');
define('_AM_TZOPT_USER','As user\'s timezone');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:04:01
define('_AM_FMT_SERVER_TZ_ALL','Timezone of the server (winter): %+2.1f<br />Timezone of the server (summer): %+2.1f<br />Zonename of the server: %s<br />The value of XOOPS config: %+2.1f<br />The value of piCal using: %+2.1f<br />');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:14
define('_AM_FMT_SERVER_TZ_SYSTEM','Timezone in winter: %+2.1f');
define('_AM_TH_SERVER_TZ_COUNT','Events');
define('_AM_TH_SERVER_TZ_VALUE','Timezone');
define('_AM_TH_SERVER_TZ_VALUE_TO','Changes (-14.0��14.0)');
define('_AM_JSALRT_SERVER_TZ','Don\'t forget backing-up events table before this operation');
define('_AM_NOTICE_SERVER_TZ','If your server set the timezone area with summer time (=Day Light Saving) and some events were registerd in piCal 0.6x or 0.7x, dont\'t push this button.<br />eg) It is natural to display both -5.0 and -4.0 in EDT');
define('_AM_MB_SUCCESSTZUPDATE','Events are modified with the timezone(s).');
define('_AM_PI_UPDATED','Plugins are updated');
define('_AM_PI_TH_TYPE','Type');
define('_AM_PI_TH_TITLE','Title');
define('_AM_PI_TH_DIRNAME','Module\'s dirname');
define('_AM_PI_TH_FILE','Plugin file');
define('_AM_PI_TH_DOTGIF','Dot GIF');
define('_AM_PI_TH_OPERATION','Operation');
define('_AM_PI_ENABLED','Enabled');
define('_AM_PI_DELETE','Delete');
define('_AM_PI_NEW','New');
define('_AM_PI_VIEWYEARLY','Yearly View');
define('_AM_PI_VIEWMONTHLY','Monthly View');
define('_AM_PI_VIEWWEEKLY','Weekly View');
define('_AM_PI_VIEWDAILY','Daily View');

define( 'PICAL_AM_LOADED' , 1 ) ;
 //* Brazilian Portuguese Translation by Marcelo Yuji Himoro <www.yuji.eu.org> *//

// titles
define("_AM_CONFIG","Configura��es do piCal");
define("_AM_GENERALCONF","Configura��es gerais");
define("_AM_ADMISSION","Aprovar eventos");
define("_AM_MENU_EVENTS","Administra��o de eventos");
define("_AM_MENU_CATEGORIES","Administra��o de categorias");
define("_AM_MENU_CAT2GROUP","Permiss�es de acesso das categorias");
define("_AM_ICALENDAR_IMPORT","Importar do iCalendar");
define("_AM_GROUPPERM","Permiss�es globais dos grupos");
define("_AM_TABLEMAINTAIN","Manuten��o de tabelas (atualiza��o)");
define("_AM_MYBLOCKSADMIN","Administra��o de blocos e grupos do piCal");

// forms
define("_AM_BUTTON_EXTRACT","Extrair");
define("_AM_BUTTON_ADMIT","Aprovar");
define("_AM_BUTTON_MOVE","Mover");
define("_AM_BUTTON_COPY","Copiar");
define("_AM_CONFIRM_DELETE","Voc� deseja realmente apagar o(s) evento(s)?");
define("_AM_CONFIRM_MOVE","Voc� deseja realmente apagar o link para categoria antiga e adicionar um link para a categoria especificada?");
define("_AM_CONFIRM_COPY","Voc� deseja realmente adicionar um link para a categoria especificada?");
define('_AM_OPT_PAST','Passado');
define('_AM_OPT_FUTURE','Futuro');
define('_AM_OPT_PASTANDFUTURE','Ambos');

// format
define("_AM_DTFMT_LIST_ALLDAY",'y-m-d');
define("_AM_DTFMT_LIST_NORMAL",'y-m-d<\b\r />H:i');

// admission
define("_AM_LABEL_ADMIT","");
define("_AM_MES_ADMITTED","O(s) evento(s) foi(foram) aprovado(s).");
define("_AM_ADMIT_TH0","Usu�rio");
define("_AM_ADMIT_TH1","Hora e data do in�cio");
define("_AM_ADMIT_TH2","Hora e data do t�rmino");
define("_AM_ADMIT_TH3","T�tulo");
define("_AM_ADMIT_TH4","Regras de repeti��o");

// iCalendar I/O

define("_AM_LABEL_IMPORTFROMWEB","Importar dados do iCalendar atrav�s da Web (insira uma URL come�ada por 'http://' ou 'webcal://')");
define("_AM_LABEL_UPLOADFROMFILE","Fazer upload dos dados do iCalendar (escolha um arquivo local)");
define("_AM_LABEL_IO_CHECKEDITEMS","");
define("_AM_LABEL_IO_OUTPUT","");
define("_AM_LABEL_IO_DELETE","");
define("_AM_MES_EVENTLINKTOCAT","evento(s) foi(ram) conectado(s) � esta categoria.");
define("_AM_MES_EVENTUNLINKED","evento(s) com link � categoria antiga foi(ram) apagado(s).");
define("_AM_FMT_IMPORTED","evento(s) foi(foram) importado(s) de '%s'.");
define("_AM_MES_DELETED","evento(s) foi(foram) apagado(s).");
define("_AM_IO_TH0","Usu�rio");
define("_AM_IO_TH1","Hora e data do in�cio");
define("_AM_IO_TH2","Hora e data do t�rmino");
define("_AM_IO_TH3","T�tulo");
define("_AM_IO_TH4","Regras de repeti��o");
define("_AM_IO_TH5","Aprova��o");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "Permiss�o de cria��o de eventos" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "Permiss�o de aprova��o de eventos" ) ;
define( '_AM_GPERM_G_EDITABLE' , "Permiss�o de edi��o de eventos" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "Permiss�o de aprova��o de altera��es de eventos" ) ;
define( '_AM_GPERM_G_DELETABLE' , "Permiss�o de exclus�o de eventos" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "Permiss�o de aprova��o de exclus�o de eventos" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "Permiss�o de edi��o/remo��o de eventos de outros" ) ;
define( '_AM_CAT2GROUPDESC' , "Marque as categorias �s quais cada grupo ter� permiss�o de acesso." ) ;
define( '_AM_GROUPPERMDESC' , "D� as permiss�es do que cada grupo est� autorizado a fazer com os eventos.<br />Para usar esta op��o, antes voc� precisa definir as 'Permiss�es globais dos grupos'.<br />As configura��es definidas aqui para o grupo dos administradores e an�nimos ser�o ignoradas." ) ;

// Table Maintenance
define( '_AM_MB_SUCCESSUPDATETABLE' , "Estrutura das tabelas atualizadas com sucesso." ) ;
define( '_AM_MB_FAILUPDATETABLE' , "N�o foi poss�vel atualizar a estrutura das tabelas." ) ;
define( '_AM_NOTICE_NOERRORS' , "Atualiza��o para o formato 0.6 conclu�da sem problemas." ) ;
define( '_AM_ALRT_CATTABLENOTEXIST' , "A tabela de categorias n�o existe.<br />\nDeseja cri�-la?" ) ;
define( '_AM_ALRT_OLDTABLE' , "A estrutura da tabela de eventos � antiga.<br />\nDeseja atualiz�-la?" ) ;
define( '_AM_ALRT_TOOOLDTABLE' , "Ocorreu um erro na tabela.<br />\nTalvez seus dados sejam do piCal 0.3x ou inferior.<br />\nAtualize primeiro para 0.4x ou 0.5x e tente atualizar novamente." ) ;
define( '_AM_FMT_WRONGSTZ' , "Existem %s eventos com o fuso hor�rio incorreto.<br />Deseja consert�-los?" ) ;

// Categories
define( '_AM_CAT_TH_TITLE' , 'T�tulo' ) ;
define( '_AM_CAT_TH_DESC' , 'Descri��o' ) ;
define( '_AM_CAT_TH_PARENT' , 'Categoria padr�o' ) ;
define( '_AM_CAT_TH_OPTIONS' , 'Op��es' ) ;
define( '_AM_CAT_TH_LASTMODIFY' , '�ltima modifica��o' ) ;
define( '_AM_CAT_TH_OPERATION' , 'Opera��o' ) ;
define( '_AM_CAT_TH_ENABLED' , 'Ativar' ) ;
define( '_AM_CAT_TH_WEIGHT' , 'Posi��o' ) ;
define( '_AM_CAT_TH_SUBMENU' , 'Mostrar no SubMenu' ) ;
define( '_AM_BTN_UPDATE' , 'Atualizar' ) ;
define( '_AM_MENU_CAT_EDIT' , 'Editar uma categoria' ) ;
define( '_AM_MENU_CAT_NEW' , 'Criar uma nova categoria' ) ;
define( '_AM_MB_MAKESUBCAT' , 'Sub-categoria' ) ;
define( '_AM_MB_MAKETOPCAT' , 'Criar uma categoria principal' ) ;
define( '_AM_MB_CAT_INSERTED' , 'Nova categoria criada com sucesso.' ) ;
define( '_AM_MB_CAT_UPDATED' , 'Categoria atualizada com sucesso.' ) ;
define( '_AM_FMT_CAT_DELETED' , '%s categorias foram apagadas com sucesso.' ) ;
define( '_AM_FMT_CAT_BATCHUPDATED' , '%s categorias foram atualizadas com sucesso.' ) ;
define( '_AM_FMT_CATDELCONFIRM' , 'Voc� deseja realmente apagar a categoria %s ?' ) ;


}

?>