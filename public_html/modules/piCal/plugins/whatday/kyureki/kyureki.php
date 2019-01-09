<?php

class piCal_whatday_kyureki extends piCal_whatday_abstract
{
	private $qreki = null;
	
	public function get_what_day($date_string) {
		$ret = $this->get_cache($date_string);
		if ($ret === false) {
			if (is_null($this->qreki)) {
				include_once $this->base_path . '/include/CalQReki.class.php';
				$this->qreki =& CalQReki::get_singleton();
			}
			list($year,$mon,$day) = explode('-', $date_string);
			$ret = $this->qreki->calc_kyureki($year, $mon, $day);
			$this->set_cache($date_string, $ret);
		}
		return _MD_PICAL_WHATDAY_KYUREKI_KYU.($ret[1]? _MD_PICAL_WHATDAY_KYUREKI_URUU : '').$ret[2].'/'.$ret[3];
	}
	
	public function get_css_class($name) {
		return $name . ' kyureki';
	}
	
}
