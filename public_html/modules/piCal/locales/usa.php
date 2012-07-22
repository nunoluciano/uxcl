<?php

$this->holidays = array(
	'2003-1-20'=>'King Jr.','2003-2-17'=>'Washington',
	'2003-5-26'=>'Memorial','2003-9-1'=>'Labor',
	'2003-10-13'=>'Columbus','2003-11-27'=>'Thanksgiving',

	'2004-1-19'=>'King Jr.','2004-2-16'=>'Washington',
	'2004-5-31'=>'Memorial','2004-9-6'=>'Labor',
	'2004-10-11'=>'Columbus','2004-11-25'=>'Thanksgiving',

	'2005-1-17'=>'King Jr.','2005-2-14'=>'Washington',
	'2005-5-30'=>'Memorial','2005-9-5'=>'Labor',
	'2005-10-10'=>'Columbus','2005-11-24'=>'Thanksgiving',

	);

for( $y = 2001 ; $y < 2020 ; $y ++ ) {
	$this->holidays[ "$y-1-1" ] = 'New Year' ;
	$this->holidays[ "$y-7-4" ] = 'Independence' ;
	$this->holidays[ "$y-11-11" ] = 'Veterans' ;
	$this->holidays[ "$y-12-25" ] = 'Christmas' ;
}

?>