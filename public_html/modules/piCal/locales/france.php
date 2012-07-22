<?php

$this->holidays = array(
'2006-4-17'=>'Paques',
'2006-5-25'=>'Ascension',
'2006-6-5'=>'Pentecote',

);

for( $y = 2001 ; $y < 2020 ; $y ++ ) {
$this->holidays[ "$y-1-1" ] = 'Nouvel an' ;
$this->holidays[ "$y-5-1" ] = 'Fete du travail' ;
$this->holidays[ "$y-5-8" ] = 'Victoire' ;
$this->holidays[ "$y-7-14" ] = 'Fete Nationale' ;
$this->holidays[ "$y-8-15" ] = 'Assomption' ;
$this->holidays[ "$y-11-1" ] = 'Tous Saints' ;
$this->holidays[ "$y-11-11" ] = 'Armistice' ;
$this->holidays[ "$y-12-25" ] = 'Noel' ;
}

?>