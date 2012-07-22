<?php
require_once _MD_ELFINDER_LIB_PATH . '/php/elFinderVolumeFTP.class.php';

elFinder::$netDrivers['ftp'] = 'FTPx';

class elFinderVolumeFTPx extends elFinderVolumeFTP {
	
	protected function configure() {
		$this->options['tmpPath'] = XOOPS_MODULE_PATH.'/'._MD_ELFINDER_MYDIRNAME.'/cache';
		
		parent::configure();
		
		$this->tmbURL = '';
		$this->tmbPath = '';
		
		$this->disabled[] = 'pixlr';
	}
	
	protected function doSearch($path, $q, $mimes) {
		if ($this->options['enable_search']) {
			return parent::doSearch($path, $q, $mimes);
		} else {
			return array();
		}
	}
}
