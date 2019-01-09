<?php

class piCal_whatday_24sekki extends piCal_whatday_abstract
{
	private $qreki = null;
	private $sekki;
	private $last_key;
	
	public function __construct($pical) {
		parent::__construct($pical);
		$_arr = explode(',', _MD_PICAL_WHATDAY_24SEKKI_SEKKI);
		$_arr = array_map('trim', $_arr);
		$this->sekki = $_arr;
	}
	
	public function get_what_day($date_string) {
		$ret = $this->get_cache($date_string);
		if ($ret === false) {
			if (is_null($this->qreki)) {
				include_once $this->base_path . '/include/CalQReki.class.php';
				$this->qreki =& CalQReki::get_singleton();
			}
			list($year, $mon, $day) = explode('-', $date_string);
			$ret = $this->qreki->check_24sekki($year, $mon, $day, true);
			$this->set_cache($date_string, $ret);
		}
		$this->last_key = $ret;
		return ($ret !== '')? $this->sekki[$ret] : '';
	}
	
	public function get_css_class($name) {
		return $name . ' 24sekki';
	}
	
}
