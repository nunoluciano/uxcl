<?php

class piCal_whatday_rokuyou extends piCal_whatday_abstract
{
	private $qreki = null;
	private $rokuyou;
	private $last_key;
	private $css_class;
	
	public function __construct($pical) {
		parent::__construct($pical);
		$_arr = explode(',', _MD_PICAL_WHATDAY_ROKUYOU_ROKUYOU);
		$_arr = array_map('trim', $_arr);
		$this->rokuyou = $_arr;
		$this->css_class = array('taian', 'syakko', 'sensyo', 'tomobiki', 'senbu', 'butumetu'); // Âç°Â,ÀÖ¸ı,Àè¾¡,Í§°ú,ÀèÉé,Ê©ÌÇ
	}
	
	public function get_what_day($date_string) {
		$ret = $this->get_cache($date_string);
		if ($ret === false) {
			if (is_null($this->qreki)) {
				include_once $this->base_path . '/include/CalQReki.class.php';
				$this->qreki =& CalQReki::get_singleton();
			}
			list($year,$mon,$day) = explode('-', $date_string);
			$ret = $this->qreki->get_rokuyou($year, $mon, $day);
			$this->set_cache($date_string, $ret);
		}
		$this->last_key = $ret;
		return $this->rokuyou[$ret];
	}
	
	public function get_css_class($name) {
		return $name . ' rokuyou ' . $this->css_class[$this->last_key];
	}
	
}
