<?php
/* New Zealand public holidays from 2001-2010 */ 
/* Compiled by zANavAShi 4th January 2005 */

$this->holidays = array(
	'2001-1-2'=>'Public Holiday',
	'2001-4-13'=>'Good Friday', '2001-4-16'=>'Easter Monday',
	'2001-6-4'=>'Queens Birthday', '2001-10-22'=>'Labour Day',
	'2002-3-29'=>'Good Friday', '2002-4-1'=>'Easter Monday',
	'2002-6-3'=>'Queens Birthday', '2002-10-28'=>'Labour Day',
	'2003-1-2'=>'Public Holiday',
	'2003-4-18'=>'Good Friday', '2003-4-21'=>'Easter Monday',
	'2003-6-2'=>'Queens Birthday', '2003-10-27'=>'Labour Day',
	'2004-1-2'=>'Public Holiday',
	'2004-4-9'=>'Good Friday', '2004-4-12'=>'Easter Monday',
	'2004-6-7'=>'Queens Birthday', '2004-10-25'=>'Labour Day',
	'2004-12-27'=>'Public Holiday', '2004-12-28'=>'Public Holiday',
	'2005-1-3'=>'Public Holiday', '2005-1-4'=>'Public Holiday',
	'2005-3-25'=>'Good Friday', '2005-3-28'=>'Easter Monday',
	'2005-6-6'=>'Queens Birthday', '2005-10-24'=>'Labour Day',
	'2005-12-27'=>'Public Holiday',
	'2006-1-2'=>'Public Holiday', '2006-1-3'=>'Public Holiday',
	'2006-4-14'=>'Good Friday', '2006-4-17'=>'Easter Monday',
	'2006-6-5'=>'Queens Birthday', '2006-10-23'=>'Labour Day',
	'2007-1-2'=>'Public Holiday',
	'2007-4-6'=>'Good Friday', '2007-4-9'=>'Easter Monday',
	'2007-6-4'=>'Queens Birthday', '2007-10-22'=>'Labour Day',
	'2008-1-2'=>'Public Holiday',
	'2008-3-21'=>'Good Friday', '2008-3-24'=>'Easter Monday',
	'2008-6-2'=>'Queens Birthday', '2008-10-27'=>'Labour Day',
	'2009-1-2'=>'Public Holiday',
	'2009-4-10'=>'Good Friday', '2009-4-13'=>'Easter Monday',
	'2009-6-1'=>'Queens Birthday', '2009-10-26'=>'Labour Day',
	'2009-12-28'=>'Public Holiday',
	'2010-1-4'=>'Public Holiday',
	'2010-4-2'=>'Good Friday', '2010-4-5'=>'Easter Monday',
	'2010-6-7'=>'Queens Birthday', '2010-10-25'=>'Labour Day',
	'2010-12-27'=>'Public Holiday', '2010-12-28'=>'Public Holiday',
);

for( $y = 2001 ; $y < 2020 ; $y ++ ) {
	$this->holidays[ "$y-1-1" ] = 'New Years Day' ;
	$this->holidays[ "$y-2-6" ] = 'Waitangi Day' ;
	$this->holidays[ "$y-4-25" ] = 'Anzac Day' ;
	$this->holidays[ "$y-12-25" ] = 'Christmas Day' ;
	$this->holidays[ "$y-12-26" ] = 'Boxing Day' ;
}

?>