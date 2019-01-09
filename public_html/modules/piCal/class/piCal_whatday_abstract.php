<?php
/**
 * piCal_whatday_abstract
 * 
 * @author nao-pon
 * @copyright GPL
 */
class piCal_whatday_abstract
{
	protected $pical;
	protected $base_path;
	protected $mydirname;
	protected $whatday_dir;
	protected $mybasename;
	
	public function __construct($pical) {
		$this->pical =& $pical;
		$this->base_path = $pical->base_path;
		$this->mydirname = basename($this->base_path);
		$this->whatday_dir = $this->base_path . '/plugins/whatday';
		$this->mybasename = substr(get_class($this), 14); // "piCal_whatday_" = 14 chars
		
		$this->load_lang();
	}
	
	private function load_lang() {
		//load language
		$_check = array();
		$_check[] = $this->whatday_dir . '/' . $this->mybasename . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/lang.php';
		$_check[] = $this->whatday_dir . '/' . $this->mybasename . '/language/english/lang.php';
		foreach($_check as $lang_file) {
			if (is_file($lang_file)) {
				include_once $lang_file;
				break;
			}
		}
	}
	
	public function get_what_day($date_string) {
		return '';
	}
	
	public function get_css_class($name) {
		return $name;
	}
	
	protected function set_cache($date_string, $value) {
		list($year, $month, $day, $cache_file) = $this->parse_date_string($date_string);
		if (is_file($cache_file) && $data = @unserialize(file_get_contents($cache_file))) {
			isset($data[$this->mybasename]) || $data[$this->mybasename] = array();
			isset($data[$this->mybasename][$month]) || $data[$this->mybasename][$month] = array();
		} else {
			$data = array();
			$data[$this->mybasename] = array();
			$data[$this->mybasename][$month] = array();
		}
		$data[$this->mybasename][$month][$day] = $value;
		return file_put_contents($cache_file, serialize($data), LOCK_EX);
	}
	
	protected function get_cache($date_string) {
		list($year, $month, $day, $cache_file) = $this->parse_date_string($date_string);
		if (is_file($cache_file) && $data = @unserialize(file_get_contents($cache_file))) {
			if (isset($data[$this->mybasename]) && isset($data[$this->mybasename][$month]) && isset($data[$this->mybasename][$month][$day])) {
				return $data[$this->mybasename][$month][$day];
			}
		}
		return false;
	}
	
	private function parse_date_string($date_string) {
		list($year, $month, $day) = explode('-', $date_string);
		$year = (int)$year;
		$month = (int)$month;
		$day = (int)$day;
		return array(
				$year,
				$month,
				$day,
				XOOPS_CACHE_PATH . '/'.rawurlencode(substr(XOOPS_URL, 7)).'_'.$this->mydirname.'_whatday_' . $year . '.ser') ;
	}
}
