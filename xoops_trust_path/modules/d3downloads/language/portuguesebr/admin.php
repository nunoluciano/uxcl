<?php
//  ------------------------------------------------------------------------ //
// $Id: admin.php 0003 12:31 2008/04/09 avtx30 $
// Tradu��o para o Brasil: Miraldo Antoninho Ohse
// Site: http://investbizu.com
//  ------------------------------------------------------------------------ //

// D3DOWNLOADS FILEMANAGER
define("_MD_D3DOWNLOADS_H2FILEMANAGER","Arquivos");
define("_MD_D3DOWNLOADS_NEWADDFILE","Adicionar um download");
define("_MD_D3DOWNLOADS_TH_VISIBLE","Visivel");
define("_MD_D3DOWNLOADS_TH_CANCOMMENT","Comentar");
define("_MD_D3DOWNLOADS_TH_CATEGORY","Categoria");
define("_MD_D3DOWNLOADS_TH_BROKEN","Arquivo com erro");
define("_MD_D3DOWNLOADS_TH_HITS","Hits");
define("_MD_D3DOWNLOADS_TH_RATING","Avalia��o");
define("_MD_D3DOWNLOADS_TH_COMMENTS","Coment��ios");
define("_MD_D3DOWNLOADS_VOTES"," votos");
define("_MD_D3DOWNLOADS_LABEL_FILECHECKED","Downloads checados");
define("_MD_D3DOWNLOADS_CONFIRM_DELETE","Voc�tem certeza que deseja deletar?");
define("_MD_D3DOWNLOADS_LABEL_CATEGORYSELECT","Selecionar a categoria");
define("_MD_D3DOWNLOADS_TOTAL_FIlE_NUM","Existem %s relat��ios totais");
define("_MD_D3DOWNLOADS_CATEGORY_FIlE_NUM","Existem %s downloads sob esta categoria");
define("_MD_D3DOWNLOADS_BTN_MOVE","Mover");
define("_MD_D3DOWNLOADS_MOVEED","Mudan�� feita");
define("_MD_D3DOWNLOADS_NO_MOVEED","Selecionar a categoria de destino");
define("_MD_D3DOWNLOADS_CONFIRM_MOVE","Voc~e tem certeza que deseja mover? Note que, se voc�usar este item, voc�tem de mover manualmente o screenshot da categoria. ");

// D3DOWNLOADS APPROVALMANAGER
define("_MD_D3DOWNLOADS_H2APROVALLIST","Novos downloads aguardando por aprova��o");
define("_MD_D3DOWNLOADS_H2MODFILELIST","Downloads editados aguardando aprova��o");
define("_MD_D3DOWNLOADS_APPROVAL","Aprova��o");
define("_MD_D3DOWNLOADS_SUBMIT_APPROVAL","Download para aprova��o");
define("_MD_D3DOWNLOADS_SUBMIT_APPROVED","Aprovados");
define("_MD_D3DOWNLOADS_UNAPROVALNUM","Downloads n�� aprovados: %s");
define("_MD_D3DOWNLOADS_NOWDATA","Conte��o antes da aprova��o");

// D3DOWNLOADS CATEGORY MANAGER
define("_MD_D3DOWNLOADS_H2CATEGORYMANAGER","Categorias");
define("_MD_D3DOWNLOADS_NEWCATEGORY","Adicionar uma nova categoria");
define("_MD_D3DOWNLOADS_TH_ID","ID");
define("_MD_D3DOWNLOADS_TH_TITLE","T��ulo");
define("_MD_D3DOWNLOADS_TH_WEIGHT","Peso");
define("_MD_D3DOWNLOADS_TH_CONTENTSACTIONS","A��o");
define("_MD_D3DOWNLOADS_LABEL_CATEGORYCHECKED","Checar categorias");
define("_MD_D3DOWNLOADS_BTN_DELETE","Deletar");
define("_MD_D3DOWNLOADS_CATEGORYEDITTITLE","Editar Categoria");
define("_MD_D3DOWNLOADS_CATEGORYTITLE","T��ulo");
define("_MD_D3DOWNLOADS_CATEGORYIMGURL","URL da imagem da categoria");
define("_MD_D3DOWNLOADS_CATEGORYIMGURLDESC","A largura da Imagem ser�configurada para 70 pixels.");
define("_MD_D3DOWNLOADS_CATEGORYSHOTSDIR","Diret��io para screenshots");
define("_MD_D3DOWNLOADS_CATEGORYSHOTSDIRDESC","Configurar o percurso depois da  url do XOOPS.<br />Por exemplo: images/shots/ (sem o primeiro /, com o ��timo /)");
define("_MD_D3DOWNLOADS_CATEGORYSHOTSDIRHELP","Opcional. Se pular, as imagens sob o diret��io %s ser�� usadas como screenshots.");
define("_MD_D3DOWNLOADS_CATWEIGHT","Peso");
define("_MD_D3DOWNLOADS_MAINCATEGORY","Categoria Principal");
define("_MD_D3DOWNLOADS_HELP_CATEGORY_DEL","Nota: Se voc�deletar uma categoria, todos os dados e suas subcategorias ser�� deletados.");
define("_MD_D3DOWNLOADS_CONFIRM_CATEGORY_DEL","Voc�tem certeza que deseja deletar esta categoria? Todos os dados e sub categorias ser�� deletados!");
define("_MD_D3DOWNLOADS_SUBMIT_MESSAGE","Descri��o do formul��io de envio");
define("_MD_D3DOWNLOADS_SUBMIT_MESSAGE_HELP","Informe a descri��o que ser�mostrada no topo do formulario de envio pelos usu��ios que n�� sejam webmasters. A informa��o �opcional. Se voc�deixar em branco, a descri��o padr�� ser�mostrada.");

// D3DOWNLOADS USER ACCESS
define("_MD_D3DOWNLOADS_H2USERACCESS","Permiss��s da Categoria");
define("_MD_D3DOWNLOADS_TH_GROUPID","ID do Grupo");
define("_MD_D3DOWNLOADS_TH_GROUPNAME","Nome do Grupo");
define("_MD_D3DOWNLOADS_TH_CAN_READ","Ler");
define("_MD_D3DOWNLOADS_TH_CAN_POST","Postar");
define("_MD_D3DOWNLOADS_TH_CAN_EDIT","Editar");
define("_MD_D3DOWNLOADS_TH_CAN_DELETE","Deletar");
define("_MD_D3DOWNLOADS_TH_POST_AUTO_APPROVED","Aprova��o autom��ica(Envio)");
define("_MD_D3DOWNLOADS_TH_EDIT_AUTO_APPROVED","Aprova��o autom��ica(Editat)");
define("_MD_D3DOWNLOADS_TH_CAN_HTML","Permitir Html");
define("_MD_D3DOWNLOADS_HELP_USERACCESS","Nota: As configura��e de editar, deletar, aprova��o autom��ica e Html para usu��ios convidados ser�� ignoradas mesmo que voc�as configure.<br />  Essas configura��es s�� aplicadas apenas a usu��ios registrados.<br />&#8251;  Os webmasters podem editar, deletar e enviar, independentemente destas configura��es.");
define("_MD_D3DOWNLOADS_HELP_USERACCESS_PID","Nota: Veja que as configura��es ser�� herdadas da categoria pai.");

// D3DOWNLOADS IMPORT
define("_MD_D3DOWNLOADS_H2_IMPORTFROM","Importar");
define("_MD_D3DOWNLOADS_BTN_DOIMPORT","Fazer importa��o");
define("_MD_D3DOWNLOADS_LABEL_SELECTMODULE","Selecionar m��ulo");
define("_MD_D3DOWNLOADS_CONFIRM_DOIMPORT","Voc�tem certeza que deja importar?");

//_MD_D3DOWNLOADS_HELP_IMPORTFROM
define("_MD_D3DOWNLOADS_HELP_IMPORTFROM","A presente vers�� pode importar de de outros d3downloads, mydownloads, wfdownloads v3.10 ou superior. N�� tentamos o melhor esfor��a para que seja importado tudo corretamente mas �poss��el que ela n�� seja completada. Note que se voc�fazer a impota��o, <b>os dados atuais deste m��ulo ser�� deletados completamente!</b> E se voc�importar do mydownloads ou wfdownloads, as permiss��s da categorias ser�� zeradas. N�� esque�� de configurar as permiss��s manualmente depois da importa��o.");
define("_MD_D3DOWNLOADS_FILE_IMPORT_HELP","Se voc�importar de outra inst��cia de d3downloads, crie um diret��io <i>%s</i> primeiro com permiss�� de escrita. Os arquivos enviados ser�� copiados para ele com o melhor esfor��. Os arquivos enviados podem n�� ser copiados completamente dependendo do ambiente. Por favor, cheque isso cuidadosamente ap�� a importa��o.");
define("_MD_D3DOWNLOADS_FILE_CONFIGERROR_HELP","Se voc�importar de outra inst��cia de d3downloads, crie um diret��io <i>%s</i> primeiro com permiss�� de escrita. Os arquivos enviados ser�� copiados para ele.");
define("_MD_D3DOWNLOADS_FILE_CONFIGERROR","Crie um diret��io para envio com permiss�� de escrita primeiro!");
define("_MD_D3DOWNLOADS_IMPORTDONE","Importa��o feita");
define("_MD_D3DOWNLOADS_ERR_INVALIDMID","N�� foi pos��el importar deste m��ulo");
define("_MD_D3DOWNLOADS_SQLONIMPORT","A importa��o falhou. As tabelas de origem e as tabelas de destino podem ter estruturas diferentes. Por favor, atualize seus m��ulos para as modifica��es mais recentes ou verifique manualmente as tabelas.");
define("_MD_D3DOWNLOADS_FILE_NO_IMPORT","Somente o banco de dados foi importado. Os aquivos enviados n�� poderam ser importados.");
define("_MD_D3DOWNLOADS_H2_UPDATEFROM","Atualiza��o (0.01 -> 0.02)");
define("_MD_D3DOWNLOADS_BTN_UPDATE","Atualizado");
define("_MD_D3DOWNLOADS_HELP_UPDATEFROM","Da vers�� 0.02 op��es para um ��ico downloads (Html, smileys, quebra de linha, BB Code) foram selecionados mas se voce atualizar das vers�� 0.01 aquelas op��es n�� estar�� dispon��eis. Por favor, pressione o bot�� Atualizar uma vez para ter dispon��el as op��es de smileys, quebra de linha e BB Code. Apenas a op��o de Html n�� estar�dispon��el, se voc�precisar, configure-as na edi��o dos formul����s. Lamentamos este inconveniente.");
define("_MD_D3DOWNLOADS_UPDATEDONE","Atualiza��o feita");
define("_MD_D3DOWNLOADS_SQLONUPDATE","Atualiza��o falhou");

// D3DOWNLOADS CONFIG_CHECK
define("_MD_D3DOWNLOADS_H2_CONFIG_CHECK","Checar ambiente de Envio");
define("_MD_D3DOWNLOADS_MAXFILESIZE","Tamano m��imo do arquivo para envio %s (bytes)");
// define("_MD_D3DOWNLOADS_MAXFILESIZE","Max size of file for uploading %s (KB)");
// define("_MD_D3DOWNLOADS_MAXFILESIZE","Upload Size (KB)");
define("_MD_D3DOWNLOADS_PHPINI_CHECK","Checar as diretivas do php.ini");
define("_MD_D3DOWNLOADS_UPLOADDIR_CHECK","Checar o diret��io de envio");
define("_MD_D3DOWNLOADS_UPLOADDIR_CONFIFG","Diret��io de Envio");

// add photosite
define("_MD_D3DOWNLOADS_TH_CAN_UPLOAD","Permitir UPLOAD");
define('_MD_D3DOWNLOADS_TH_UID','ID do usu��io');
define('_MD_D3DOWNLOADS_TH_UNAME','Nome do Uus��io');
define('_MD_D3DOWNLOADS_IMGURL_CHECK','URL da imagem da categoria n�� �valida');
define('_MD_D3DOWNLOADS_IMGURL_TOOLONG','Por favor, informe a URL da imagem da categoria em caracteres one-byte com o comprimento m��imo de %s');
define('_MD_D3DOWNLOADS_SHOTSDIR_CHECK','O diret��io pra screenshots n�� �v��ido');
define('_MD_D3DOWNLOADS_SHOTSDIR_TOOLONG','Por favor, informe o directory para screenshots em caracteres one-byte com o comprimento m��imo de %s');
define('_MD_D3DOWNLOADS_CAT_WEIGHT_TOOLONG','Por favor, informe o peso em em caracteres one-byte com o comprimento m��imo de %s');
define('_MD_D3DOWNLOADS_INVISIBLEINFO','Invisivel');
define('_MD_D3DOWNLOADS_WAITINGRELEASEINFO','aguardando lan��mento');
define('_MD_D3DOWNLOADS_EXPIREDINFO','Expirou');
define('_MD_D3DOWNLOADS_CATDESCRIPTION','Configurar as descri��es da categoria');
define('_MD_D3DOWNLOADS_H2BROKENMANAGER','Informar erros');
define('_MD_D3DOWNLOADS_BROKENNUM',' %s ');
define('_MD_D3DOWNLOADS_TH_SENDERNAME','Quem enviou');
define('_MD_D3DOWNLOADS_TH_IP','Endere�� de IP');
define('_MD_D3DOWNLOADS_TH_REPORTDATE','Reportar data');
define('_MD_D3DOWNLOADS_TH_BROKENDEL','Ignorar o relat��io');
define('_MD_D3DOWNLOADS_TOTAL_INVISIBLE_NUM','Existem um total %s de arquivos invis��eis');
define('_MD_D3DOWNLOADS_CATEGORY_INVISIBLE_NUM','Existem %s arquivos invis��eis sob esta categoria');
define('_MD_D3DOWNLOADS_LABEL_BROKENCHECK','Checar erros no envio de arquivos');
define('_MD_D3DOWNLOADS_UPLOAD_TMP_DIR_IS_NOTWRITEABLE','N�� foi poss��el escrever para upload_tmp_dir');
define('_MD_D3DOWNLOADS_SYSTEM_CHECK','Ambiente de uso');
define('_MD_D3DOWNLOADS_CACHEDIR_CHECK','Checar diretorio de cache');
define('_MD_D3DOWNLOADS_CACHEDIR_CONFIFG','Diret��io de Cache');
define('_MD_D3DOWNLOADS_CACHEDIR_NOT_IS_DIR','Criar diretorio cache e configurar as permiss��s de escrita para ele');
define("_MD_D3DOWNLOADS_CACHEDIR_NOT_MKDIR","N�� foi possivel criar o diret��io de cache. Por favor, check as permiss��s de escrita do diret��io pai");
define("_MD_D3DOWNLOADS_CACHEDIR_NOT_IS_WRITEABLE","N�� foi poss��el escrever no diret��io de cache. Por favor, check as permiss��s de escrita");
define('_MD_D3DOWNLOADS_TABLE_CHECK','Checar tabela');
define('_MD_D3DOWNLOADS_NOLINK_CHECK','Enviar arquivos que n�� estejam lincados');
define('_MD_D3DOWNLOADS_HELP_BROKENCHECK','Nota: N�� no ambiente que pode usar cron, �poss��el a checagem de um arquivo ou link regular errado checado na linha de comando. <br />[ Exemplo de configura��o de crontab ] :<br /><ul><li>0 0 1 * * /usr/local/bin/php php -q -f home/***/html/modules/(dirname)/bin/broken_check.sh pass=password limit=100 offset=0</li><li>A senha pode ser configurada e alterada indispensavelmente nas prefer��cias. Por favor, configure o limite e offset, se necess��io indispensavelmente. </li></ul>');
define('_MD_D3DOWNLOADS_HISTORY_RESTORE','Os conte��os registrados s�� reconstruidos com esses conte��os');
define('_MD_D3DOWNLOADS_CONFIRM_HISTORY_RESTORE','�� poss��el a reconstru��o com este conte��o? Quando isto for executado, o presente conte��o registrado ser�reconstruido depois de retaining, como ��timo registro. No entanto, n�� �o caso disto poder restaurar todos os dados. Ap�� a execu��o, por favor verifique se o conte��o registrado est�corretode acordo com a necessidade.');
define('_MD_D3DOWNLOADS_NEWCATEGORYEDITTITLE','Adicionar nova categoria');
define('_MD_D3DOWNLOADS_CATEGORY_TREE','Arvore da Categoria');
define('_MD_D3DOWNLOADS_SUBCATEGORY_SUM','N��ero de sub categorias');
define('_MD_D3DOWNLOADS_FILES_SUM','N��ero de registros');
define('_MD_D3DOWNLOADS_MAKESUBCATEGORY','Adicionar uma nova sub categoria');
define('_MD_D3DOWNLOADS_MYTPLSFORM_BTN_MODIFYCONT','Refletir');
define('_MD_D3DOWNLOADS_CATEGORY_MOVE','Move como sub categoria da categoria da qual �selecionada');
define('_MD_D3DOWNLOADS_CONFIRMCATEGORY_MOVE','Truly, moving as sub category it may, is?');
define('_MD_D3DOWNLOADS_CATEGORY_TOP_MOVE','It makes top category');
define('_MD_D3DOWNLOADS_CONFIRMCATEGORY_TOP_MOVE','Verdadeiramente, �possivel mover como a categoria top, �isso?');
define('_MD_D3DOWNLOADS_H2USERACCESS_INFO','Permiss��s da Categoria ( %s )');
define('_MD_D3DOWNLOADS_NEWCID_USERACCESS','Permiss��s da Categoria');
define('_MD_D3DOWNLOADS_NEWCID_USERACCESS_INFO','Permiss��s da Categoria');
define('_MD_D3DOWNLOADS_HELP_USERACCESS_USER','Nota: Por favor, informe cada uid ou uname quando voc�adicionar o novo usu��io.<br />O usu��io pode apagar ele da lista, removendo a leitura. ');
define('_MD_D3DOWNLOADS_USERACCESS_COPY','Copiar esta configura��o de permiss�� em outra categoria');
define('_MD_D3DOWNLOADS_CONFIRM_USERACCESS_COPY','Copiando, �poss��el?');
define('_MD_D3DOWNLOADS_COPYDONE','A c��ia foi concluida');
define('_MD_D3DOWNLOADS_ALL_USERACCESS_COPY','Copiar esta configura��o de permiss�� em todas as categorias');
define('_MD_D3DOWNLOADS_CONFIRM_ALL_USERACCESS_COPY','Copiando verdadeiramente �poss��el? A configura��o da permiss�� de todas as categorias foram modificadas com os conte��os que foram selecionados.');
define('_MD_D3DOWNLOADS_HISTORY_DELETE','O registro anterior foi deletado');
define('_MD_D3DOWNLOADS_CATEGORYIMG','Imagem da Categoria');
define('_MD_D3DOWNLOADS_SEL_SUBMITTER','Selecionar quem envia');
define('_MD_D3DOWNLOADS_ERROR_SEL_FILSE','Selecionar o arquivo de destino');
define('_MD_D3DOWNLOADS_CATEGORY_CHECK','Execute isso se as suas categorias mostrarem informa��es contradit��ias.');
define('_MD_D3DOWNLOADS_CATEGORY_CHECK_DONE','Processamento concluido');
define('_MD_D3DOWNLOADS_SEL_GROUP','Selecionar grupo');
define('_MD_D3DOWNLOADS_SEL_USER','Selecionar usu��io');
define('_MD_D3DOWNLOADS_LABEL_GROUP_CHECKED','Checar grupos');
define('_MD_D3DOWNLOADS_LABEL_USER_CHECKED','Checar usu��ios');
define('_MD_D3DOWNLOADS_ERROR_SEL_CATEGORY','Selecionar a categoria de destino');
define('_MD_D3DOWNLOADS_ERROR_SEL_GROUP','Selecionar o grupo de destino');
define('_MD_D3DOWNLOADS_ERROR_SEL_USER','Selecionar o usu��io de destino');
define('_MD_D3DOWNLOADS_ERROR_SEL_REPORT','Selecionar o relat��io de destino');
define('_MD_D3DOWNLOADS_TH_MYLINK','Meu link');
define('_MD_D3DOWNLOADS_SELECT_IMGURL','Selecionar a imagem da categoria');
define('_MD_D3DOWNLOADS_SELECT_IMGURLDESC','�poss��el selecionar o diret��io do screenshot ou o m��ulo de administra��o de imagens.');
define('_MD_D3DOWNLOADS_TH_REPORT','Informar erro');
define('_MD_D3DOWNLOADS_BTN_INVISIBLE','Invis��el');
define('_MD_D3DOWNLOADS_CONFIRM_INVISIBLE','Voc�tem certeza que deseja tornar invis��el?');
define('_MD_D3DOWNLOADS_INVISIBLE_DONE','Foi configurado para invis��el');

?>
