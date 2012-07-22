<?php

$this->holidays = array(
	'2005-3-7'=>'Labour Day','2005-3-25'=>'Good Friday',
	'2005-3-28'=>'Easter Monday','2005-6-6'=>'Foundation Day',
	'2005-9-26'=>'Queens Birthday','2005-12-26'=>'Christmas Day PH',
  '2005-12-27'=>'Boxing Day PH','2006-1-2'=>'New Years PH',
	'2006-3-6'=>'Labour Day','2006-4-14'=>'Good Friday',
	'2006-4-17'=>'Easter Monday','2006-6-5'=>'Foundation Day',
	'2006-10-2'=>'Queens Birthday','2007-3-5'=>'Labour Day',
	'2007-4-6'=>'Good Friday','2007-4-9'=>'Easter Monday',
	'2007-6-4'=>'Foundation Day','2007-10-1'=>'Queens Birthday'
);

for( $y = 2001 ; $y < 2020 ; $y ++ ) {
	$this->holidays[ "$y-1-1" ] = 'New Years Day' ;
	$this->holidays[ "$y-1-26" ] = 'Australia Day' ;
	$this->holidays[ "$y-4-25" ] = 'Anzac Day' ;
	$this->holidays[ "$y-12-25" ] = 'Christmas Day' ;
	$this->holidays[ "$y-12-26" ] = 'Boxing Day' ;
}

?>