<?php

$this->holidays = array(
'2005-1-3'=>'New Year Stat','2005-3-25'=>'Good Friday',
'2005-9-5'=>'Labour Day','2005-12-27'=>'Christmas Stat',
'2006-1-2'=>'New Year Stat','2006-4-14'=>'Good Friday',
'2006-5-22'=>'Victoria Day','2006-7-3'=>'Canada Day Stat',
'2006-8-7'=>'BC Day','2006-9-4'=>'Labour Day',
'2006-10-9'=>'Thanksgiving Day','2006-11-13'=>'Rememberance Day Stat',
'2007-4-6'=>'Good Friday','2007-5-21'=>'Victoria Day',
'2007-7-2'=>'Canada Stat','2007-8-6'=>'BC Day',
'2007-9-3'=>'Labour Day','2007-10-8'=>'Thanksgiving',
'2007-11-12'=>'Rememberance Day Stat',

);

for( $y = 2005 ; $y < 2020 ; $y ++ ) {
$this->holidays[ "$y-1-1" ] = 'New Year' ;
$this->holidays[ "$y-7-1" ] = 'Canada Day' ;
$this->holidays[ "$y-11-11" ] = 'Rememberance' ;
$this->holidays[ "$y-12-25" ] = 'Christmas' ;
$this->holidays[ "$y-12-26" ] = 'Boxing Day' ;
$this->holidays[ "$y-2-14" ] = 'Valentines Day' ;
$this->holidays[ "$y-3-17" ] = 'St. Patricks Day' ;
$this->holidays[ "$y-10-31" ] = 'Halloween' ;
$this->holidays[ "$y-12-24" ] = 'Christmas Eve' ;
$this->holidays[ "$y-12-31" ] = 'New Years Eve' ;
}

?>