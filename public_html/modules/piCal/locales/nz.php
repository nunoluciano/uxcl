<?php

$this->holidays = array(
	'2006-4-14'=>'Good Friday',
	'2007-4-6'=>'Good Friday',
	'2008-3-21'=>'Good Friday',
	'2009-4-10'=>'Good Friday',
	
	'2006-4-17'=>'Easter Monday',
	'2007-4-9'=>'Easter Monday',
	'2008-3-24'=>'Easter Monday',
	'2009-4-13'=>'Easter Monday',
	
	'2006-6-5'=>'Queens Birthday',
	'2007-6-4'=>'Queens Birthday',
	'2008-6-2'=>'Queens Birthday',
	'2009-6-1'=>'Queens Birthday',
	
	'2006-10-23'=>'Labour Day',
	'2007-10-22'=>'Labour Day',
	'2008-10-27 '=>'Labour Day',
	'2009-10-26 '=>'Labour Day',
);

for( $y = 2006 ; $y < 2020 ; $y ++ ) {
	$this->holidays[ "$y-1-1" ] = 'New Years Day' ;
	$this->holidays[ "$y-1-2" ] = 'Day after New Years Day';
	$this->holidays[ "$y-2-6" ] = 'Waitangi Day';
	$this->holidays[ "$y-4-25" ] = 'Anzac Day' ;
	$this->holidays[ "$y-12-25" ] = 'Christmas Day' ;
	$this->holidays[ "$y-12-26" ] = 'Boxing Day' ;
	
	$this->holidays[ "$y-1-29 " ] = 'Auckland Anniversary Day' ;
	$this->holidays[ "$y-3-31 " ] = 'Taranaki Anniversary Day' ;
	$this->holidays[ "$y-11-1" ] = 'Hawkes Bay Anniversary Day' ;
	$this->holidays[ "$y-1-22" ] = 'Wellington Anniversary Day' ;
	$this->holidays[ "$y-11-1" ] = 'Marlborough Anniversary Day' ;
	$this->holidays[ "$y-2-1" ] = 'Nelson Anniversary Day' ;
	$this->holidays[ "$y-12-16" ] = 'Canterbury Anniversary Day' ;
	$this->holidays[ "$y-12-1" ] = 'Westland Anniversary Day' ;
	$this->holidays[ "$y-3-23" ] = 'Otago Anniversary Day' ;
	$this->holidays[ "$y-1-17" ] = 'Southland Anniversary Day' ;
	$this->holidays[ "$y-11-30" ] = 'Chatham Islands Anniversary Day' ;
}

?>