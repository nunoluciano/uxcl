<?php

// definitions for editing blocks

define("_MB_PICO_CATLIMIT","Especificar a categoria (s)");
define("_MB_PICO_CATLIMITDSC","Em branco significa todas as categorias. 0 significa a categoria TOP. Voc� pode especificar m�ltiplas categorias atrav�s de n�meros seperados com v�rgula.");
define("_MB_PICO_PARENTCAT","Categoria pai");
define("_MB_PICO_PARENTCATDSC","Ser�o mostradas subcategorias diretamente pertencentes a esta categoria pai. Voc� pode especificar m�ltiplas categorias pai atrav�s de n�meros separados com v�rgula.");
define("_MB_PICO_SELECTORDER","Ordenar por");
define("_MB_PICO_CONTENTSNUM","N�mero de itens que � mostrado");
define("_MB_PICO_THISTEMPLATE","Modelo (recurso)do bloco");
define("_MB_PICO_DISPLAYBODY","Mostrar o corpo do conte�do tamb�m");
define("_MB_PICO_CONTENT_ID","Conte�do ID");
define("_MB_PICO_PROCESSBODY","Processar o corpo do conte�do dinamicamente");
define("_MB_PICO_TAGSNUM","Mostrar");
define("_MB_PICO_TAGSLISTORDER","Ordem de exibi��o");
define("_MB_PICO_TAGSSQLORDER","Ordem de extra��o");

// LTR or RTL
if( defined( '_ADM_USE_RTL' ) ) {
	@define( '_ALIGN_START' , _ADM_USE_RTL ? 'right' : 'left' ) ;
	@define( '_ALIGN_END' , _ADM_USE_RTL ? 'left' : 'right' ) ;
} else {
	@define( '_ALIGN_START' , 'left' ) ; // change it right for RTL
	@define( '_ALIGN_END' , 'right' ) ;  // change it left for RTL
}



?>
