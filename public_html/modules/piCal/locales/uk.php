<?php

$this->holidays = array(
	'2005-1-3'=>'New Years Bank Holiday',
	'2005-3-25'=>'Good Friday',
	'2005-3-28'=>'Easter Monday',
	'2005-5-2'=>'Early May Bank Holiday',
	'2005-5-30'=>'Spring Bank Holiday',
	'2005-8-29'=>'Summer Bank Holiday',
	'2005-12-27'=>'Christmas Bank Holiday',

	'2006-1-2'=>'New Years Bank Holiday',
	'2006-4-14'=>'Good Friday',
	'2006-4-17'=>'Easter Monday',
	'2006-5-1'=>'Early May Bank Holiday',
	'2006-5-29'=>'Spring Bank Holiday',
	'2006-8-28'=>'Summer Bank Holiday',

	'2007-4-6'=>'Good Friday',
	'2007-4-9'=>'Easter Monday',
	'2007-5-7'=>'Early May Bank Holiday',
	'2007-5-28'=>'Spring Bank Holiday',
	'2007-8-27'=>'Summer Bank Holiday',

	'2008-3-21'=>'Good Friday',
	'2008-3-24'=>'Easter Monday',
	'2008-5-5'=>'Early May Bank Holiday',
	'2008-5-26'=>'Spring Bank Holiday',
	'2008-8-25'=>'Summer Bank Holiday',

	);

for( $y = 2001 ; $y < 2020 ; $y ++ ) {
	$this->holidays[ "$y-1-1" ] = 'New Years Day' ;
	$this->holidays[ "$y-12-25" ] = 'Christmas' ;
	$this->holidays[ "$y-12-26" ] = 'Boxing Day' ;
}

?>