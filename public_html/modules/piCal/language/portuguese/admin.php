<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {






// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:47
define('_AM_PICAL_DBUPDATED','Database Updated Successfully!');
define('_AM_PICAL_PERMADDNG','Could not add %s permission to %s for group %s');
define('_AM_PICAL_PERMADDOK','Added %s permission to %s for group %s');
define('_AM_PICAL_PERMRESETNG','Could not reset group permission for module %s');
define('_AM_PICAL_PERMADDNGP','All parent items must be selected.');

// Appended by Xoops Language Checker -GIJOE- in 2005-06-29 17:19:30
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
define('_AM_TH_SERVER_TZ_VALUE_TO','Changes (-14.0¡Á14.0)');
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


// titles

// Appended by Xoops Language Checker -GIJOE- in 2004-06-22 18:39:03
define('_AM_OPT_PAST','Past');
define('_AM_OPT_FUTURE','Future');
define('_AM_OPT_PASTANDFUTURE','Past&Future');

define("_AM_CONFIG","Configuração do Menu do piCal");
define("_AM_GENERALCONF","Opções Gerais do piCal");
define("_AM_ADMISSION","Admitir eventos");
define("_AM_MENU_EVENTS","Administrador de Eventos");
define("_AM_MENU_CATEGORIES","Administrador de Categorias");
define("_AM_MENU_CAT2GROUP","Permissão da Categoria");
define("_AM_ICALENDAR_IMPORT","Importar iCalendar");
define("_AM_GROUPPERM","Permissões Globais");
define("_AM_TABLEMAINTAIN","Manutenção da Tabela (Atualização)");
define("_AM_MYBLOCKSADMIN","Administrador Block&Group do piCal");

// forms
define("_AM_BUTTON_EXTRACT","Extrair");
define("_AM_BUTTON_ADMIT","Admitir");
define("_AM_BUTTON_MOVE","Mover");
define("_AM_BUTTON_COPY","Copiar");
define("_AM_CONFIRM_DELETE","Excluir evento(s) OK?");
define("_AM_CONFIRM_MOVE","Remover um link para categoria anterior e adicionar um link para a categoria especificada OK?");
define("_AM_CONFIRM_COPY","Adicionar um link para categoria especificada OK?");

// format
define("_AM_DTFMT_LIST_ALLDAY",'a-m-d');
define("_AM_DTFMT_LIST_NORMAL",'a-m-d<\b\r />H:i');

// admission
define("_AM_LABEL_ADMIT","Os eventos assinalados são: esperando admissão");
define("_AM_MES_ADMITTED","Evento(s) foi(foram) admitido(s)");
define("_AM_ADMIT_TH0","Usuário");
define("_AM_ADMIT_TH1","Hora e data de início");
define("_AM_ADMIT_TH2","Hora e data de final");
define("_AM_ADMIT_TH3","Título");
define("_AM_ADMIT_TH4","Regra");

// events manager & importing iCalendar

define("_AM_LABEL_IMPORTFROMWEB","Importar da web dados do iCalendar (Input URL que se inicia com 'http://' ou 'webcal://')");
define("_AM_LABEL_UPLOADFROMFILE","Carregar dados para o iCalendar(Selecione um arquivo de seu computador local)");
define("_AM_LABEL_IO_CHECKEDITEMS","Os eventos selecionados são:");
define("_AM_LABEL_IO_OUTPUT","para ser(em) exportado(s) ao iCalendar");
define("_AM_LABEL_IO_DELETE","para ser(em) excluído(s)");
define("_AM_MES_EVENTLINKTOCAT","evento(s) foi(foram) conectado(s) a esta categoria");
define("_AM_MES_EVENTUNLINKED","evento(s) has been removed a link to the old category");
// o link do(s) evento(s) ha sido removido para categoria antiga
define("_AM_FMT_IMPORTED","evento(s) foi(foram) importado(s) de '%s'");
define("_AM_MES_DELETED","evento(s) foi(foram) excluído(s)");
define("_AM_IO_TH0","Usuário");
define("_AM_IO_TH1","Hora e data de início");
define("_AM_IO_TH2","Hora e data de final");
define("_AM_IO_TH3","Título");
define("_AM_IO_TH4","Regra");
define("_AM_IO_TH5","Admissão");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "Pode adicionar" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "Super adicionar" ) ;
define( '_AM_GPERM_G_EDITABLE' , "Pode editar" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "Super editar" ) ;
define( '_AM_GPERM_G_DELETABLE' , "Pode excluir" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "Super excluir" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "Pode tocar outros" ) ;
define( '_AM_CAT2GROUPDESC' , "Assinalar as categorias às quais você autoriza o acesso" ) ;
define( '_AM_GROUPPERMDESC' , "Selecione permissões que cada grupo está autorizado a fazer<br />Se você necessita desta característica, antes selecione 'Atribuições dos usuários' para especificar em permissões do Grupo.<br />As opções dos grupos Administrator e Guest serão ignoradas." ) ;

// Table Maintenance
define( '_AM_MB_SUCCESSUPDATETABLE' , "Atualização de tabela feita com sucesso" ) ;
define( '_AM_MB_FAILUPDATETABLE' , "Atualização de tabela falhou" ) ;
define( '_AM_NOTICE_NOERRORS' , "Não há erro em tabelas ou registros." ) ;
define( '_AM_ALRT_CATTABLENOTEXIST' , "A tabela de categorias não existe.<br />\nVocê criou a tabela ?" ) ;
define( '_AM_ALRT_OLDTABLE' , "A estrutura da tabela de eventos é antiga.<br />\nVocê atualizo a tabela ?" ) ;
define( '_AM_ALRT_TOOOLDTABLE' , "Ocorreu um erro na tabela.<br />\nTalvez você usou piCal 0.3x ou mais antigo.<br />\nAntes, atualize para 0.4x ou 0.5x." ) ;
define( '_AM_FMT_WRONGSTZ' , "Há %s eventos que estão registrados com fuso horário errado.<br />Você deseja repará-los?" ) ;

// Categories
define( '_AM_CAT_TH_TITLE' , 'Título' ) ;
define( '_AM_CAT_TH_DESC' , 'Descrição' ) ;
define( '_AM_CAT_TH_PARENT' , 'Categoria Acima' ) ;
define( '_AM_CAT_TH_OPTIONS' , 'Opções' ) ;
define( '_AM_CAT_TH_LASTMODIFY' , 'Última Modificação' ) ;
define( '_AM_CAT_TH_OPERATION' , 'Operação' ) ;
define( '_AM_CAT_TH_ENABLED' , 'Habilitado' ) ;
define( '_AM_CAT_TH_WEIGHT' , 'Peso' ) ;
define( '_AM_CAT_TH_SUBMENU' , 'registrar em SubMenu' ) ;
define( '_AM_BTN_UPDATE' , 'ATUALIZAÇÃO' ) ;
define( '_AM_MENU_CAT_EDIT' , 'Editando a Categoria' ) ;
define( '_AM_MENU_CAT_NEW' , 'Criar uma nova Categoria' ) ;
define( '_AM_MB_MAKESUBCAT' , 'SubCategoria' ) ;
define( '_AM_MB_MAKETOPCAT' , 'Criar uma categoria principal' ) ;
define( '_AM_MB_CAT_INSERTED' , 'Nova Categoria criada' ) ;
define( '_AM_MB_CAT_UPDATED' , 'Categoria atualizada' ) ;
define( '_AM_FMT_CAT_DELETED' , '%s Categorias excluídas' ) ;
define( '_AM_FMT_CAT_BATCHUPDATED' , '%s Categorias atualizadas' ) ;
define( '_AM_FMT_CATDELCONFIRM' , 'Você deseja excluir a categoria %s ?' ) ;



}

?>