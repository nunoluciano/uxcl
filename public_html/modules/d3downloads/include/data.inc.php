<?php

// === option begin ===
// $category_option  �ɕ\������J�e�S���ԍ����J���}(,)�ŋ�؂��ċL���B�󗓂Ȃ�S�J�e�S���[�\���B
// $intree �� '1' �ɂ���ƁA�z���̃T�u�J�e�S�����\�����邱�Ƃ��ł��܂��B 
$category_option = '' ;
$intree = '0' ;

// --- option end ---

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirname = basename( dirname(  dirname( __FILE__ ) ) ) ;
$mydirpath = dirname( dirname( __FILE__ ) ) ;
require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/whatsnew.inc.php' ;

?>