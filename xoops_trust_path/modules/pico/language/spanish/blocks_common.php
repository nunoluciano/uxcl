<?php

// definitions for editing blocks




// Appended by Xoops Language Checker -GIJOE- in 2008-09-17 13:09:55
define('_MB_PICO_PROCESSBODY','Process body of the content dynamically');

// Appended by Xoops Language Checker -GIJOE- in 2008-04-23 04:51:11
define('_MB_PICO_TAGSNUM','Display');
define('_MB_PICO_TAGSLISTORDER','Order for displaying');
define('_MB_PICO_TAGSSQLORDER','Order for extracting');

// Appended by Xoops Language Checker -GIJOE- in 2007-06-15 05:03:01
define('_MB_PICO_PARENTCAT','Parent category');
define('_MB_PICO_PARENTCATDSC','Subcategories directly belonging to this parent category will be displayed. you can specify parent categories multiply by numbers separated with comma.');

// Appended by Xoops Language Checker -GIJOE- in 2007-05-14 04:45:29
define('_MB_PICO_DISPLAYBODY','Display content body also');

define("_MB_PICO_CATLIMIT","Especificar categor�a(s)");
define("_MB_PICO_CATLIMITDSC","En blanco significa todas las categor�as. Cero (0) significa la categor�a PRINCIPAL. Puedes especificar m�ltiples categor�as con n�meros separados con comas.");
define("_MB_PICO_SELECTORDER","Ordenar por");
define("_MB_PICO_CONTENTSNUM","N�mero de elementos a ser desplegados");
define("_MB_PICO_THISTEMPLATE","Template(recurso) del bloque");
define("_MB_PICO_CONTENT_ID","ID de contenido");


// LTR or RTL
if( defined( '_ADM_USE_RTL' ) ) {
	@define( '_ALIGN_START' , _ADM_USE_RTL ? 'right' : 'left' ) ;
	@define( '_ALIGN_END' , _ADM_USE_RTL ? 'left' : 'right' ) ;
} else {
	@define( '_ALIGN_START' , 'left' ) ; // change it right for RTL
	@define( '_ALIGN_END' , 'right' ) ;  // change it left for RTL
}



?>
