<?php
// $Id: object.php,v 1.1 2007/05/15 02:34:37 minahito Exp $
//	------------------------------------------------------------------------ //
//				  XOOPS - PHP Content Management System 					 //
//					  Copyright (c) 2000 XOOPS.org							 //
//						 <http://www.xoops.org/>							 //
//	------------------------------------------------------------------------ //
//	This program is free software; you can redistribute it and/or modify	 //
//	it under the terms of the GNU General Public License as published by	 //
//	the Free Software Foundation; either version 2 of the License, or		 //
//	(at your option) any later version. 									 //
//																			 //
//	You may not change or alter any portion of this comment or credits		 //
//	of supporting developers from this source code or any supporting		 //
//	source code which is considered copyrighted (c) material of the 		 //
//	original comment or credit authors. 									 //
//																			 //
//	This program is distributed in the hope that it will be useful, 		 //
//	but WITHOUT ANY WARRANTY; without even the implied warranty of			 //
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 //
//	GNU General Public License for more details.							 //
//																			 //
//	You should have received a copy of the GNU General Public License		 //
//	along with this program; if not, write to the Free Software 			 //
//	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//	------------------------------------------------------------------------ //


if(!defined('XOBJ_DTYPE_STRING'))	define('XOBJ_DTYPE_STRING', 1);
if(!defined('XOBJ_DTYPE_TXTBOX'))	define('XOBJ_DTYPE_TXTBOX', 1);
if(!defined('XOBJ_DTYPE_TEXT'))		define('XOBJ_DTYPE_TEXT', 2);
if(!defined('XOBJ_DTYPE_TXTAREA'))	define('XOBJ_DTYPE_TXTAREA', 2);
if(!defined('XOBJ_DTYPE_INT'))		define('XOBJ_DTYPE_INT', 3);
if(!defined('XOBJ_DTYPE_URL'))		define('XOBJ_DTYPE_URL', 4);
if(!defined('XOBJ_DTYPE_EMAIL'))	define('XOBJ_DTYPE_EMAIL', 5);
if(!defined('XOBJ_DTYPE_ARRAY'))	define('XOBJ_DTYPE_ARRAY', 6);
if(!defined('XOBJ_DTYPE_OTHER'))	define('XOBJ_DTYPE_OTHER', 7);
if(!defined('XOBJ_DTYPE_SOURCE'))	define('XOBJ_DTYPE_SOURCE', 8);
if(!defined('XOBJ_DTYPE_STIME'))	define('XOBJ_DTYPE_STIME', 9);
if(!defined('XOBJ_DTYPE_MTIME'))	define('XOBJ_DTYPE_MTIME', 10);
if(!defined('XOBJ_DTYPE_LTIME'))	define('XOBJ_DTYPE_LTIME', 11);
if(!defined('XOBJ_DTYPE_FLOAT'))	define('XOBJ_DTYPE_FLOAT', 12);
if(!defined('XOBJ_DTYPE_BOOL'))		define('XOBJ_DTYPE_BOOL', 13);

if(!defined('XOBJ_DTYPE_DATE'))		define('XOBJ_DTYPE_DATE', 100);
if(!defined('XOBJ_DTYPE_DATETIME'))	define('XOBJ_DTYPE_DATETIME', 101);

//******************************************************************************

class XsnsRoot extends XoopsObject
{
	var $doHtml = false;
	var $doXcode = true;
	var $doSmiley = true;
	var $doImage = true;
	var $doBr = true;
	
	function XsnsRoot()
	{
	
	}
	
	/**
	* returns a specific variable for the object in a proper format
	*
	* @access public
	* @param string $key key of the object's variable to be returned
	* @param string $format format to use for the output
	* @return mixed formatted value of the variable
	*/
	function &getVar($key, $format = 's')
	{
		// for XsnsTextSanitizer
//		$ts =& XsnsTextSanitizer::getInstance();
		
		if(!isset($this->vars[$key]['value'])){
			$ret = NULL;
			return $ret;
		}
		$ret =	$this->vars[$key]['value'];
		switch ($this->vars[$key]['data_type']) {

		case XOBJ_DTYPE_TXTBOX:
			switch (strtolower($format)) {
			case 's':
			case 'show':
			case 'e':
			case 'edit':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = $ts->htmlSpecialChars($ret);
				break 1;
			case 'p':
			case 'preview':
			case 'f':
			case 'formpreview':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = $ts->htmlSpecialChars($ts->stripSlashesGPC($ret));
				break 1;
			case 'n':
			case 'none':
			default:
				break 1;
			}
			break;
		case XOBJ_DTYPE_TXTAREA:
			switch (strtolower($format)) {
			case 's':
			case 'show':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = $ts->displayTarea($ret, $this->doHtml, $this->doSmiley, $this->doXcode, $this->doImage, $this->doBr);
				break 1;
			case 'e':
			case 'edit':
				$ret = htmlspecialchars($ret, ENT_QUOTES);
				break 1;
			case 'p':
			case 'preview':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = $ts->previewTarea($ret, $this->doHtml, $this->doSmiley, $this->doXcode, $this->doImage, $this->doBr);
				break 1;
			case 'f':
			case 'formpreview':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = htmlspecialchars($ts->stripSlashesGPC($ret), ENT_QUOTES);
				break 1;
			
			// strip XOOPS Code ************************
			case 'x':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = $ts->stripXoopsCode($ret);
				break 1;
			// *****************************************
			
			case 'n':
			case 'none':
			default:
				break 1;
			}
			break;
		case XOBJ_DTYPE_ARRAY:
			$ret = unserialize($ret);
			break;
		case XOBJ_DTYPE_SOURCE:
			switch (strtolower($format)) {
			case 's':
			case 'show':
				break 1;
			case 'e':
			case 'edit':
				$ret = htmlspecialchars($ret, ENT_QUOTES);
				break 1;
			case 'p':
			case 'preview':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = $ts->stripSlashesGPC($ret);
				break 1;
			case 'f':
			case 'formpreview':
				$ts =& XsnsTextSanitizer::getInstance();
				$ret = htmlspecialchars($ts->stripSlashesGPC($ret), ENT_QUOTES);
				break 1;
			case 'n':
			case 'none':
			default:
				break 1;
			}
			break;
			
		case XOBJ_DTYPE_DATE:
		case XOBJ_DTYPE_DATETIME:
			$ret = XsnsUtils::getUserTimestamp($ret);
			break;
		
		default:
			if ($this->vars[$key]['options'] != '' && $ret != '') {
				switch (strtolower($format)) {
				case 's':
				case 'show':
					$selected = explode('|', $ret);
					$options = explode('|', $this->vars[$key]['options']);
					$i = 1;
					$ret = array();
					foreach ($options as $op) {
						if (in_array($i, $selected)) {
							$ret[] = $op;
						}
						$i++;
					}
					$ret = implode(', ', $ret);
				case 'e':
				case 'edit':
					$ret = explode('|', $ret);
					break 1;
				default:
					break 1;
				}

			}
			break;
		}
		return $ret;
	}

	/**
	 * clean values of all variables of the object for storage.
	 * also add slashes whereever needed
	 *
	 * @return bool true if successful
	 * @access public
	 */
	function cleanVars()
	{
		// for XsnsTextSanitizer
		$ts =& XsnsTextSanitizer::getInstance();
		foreach ($this->vars as $k => $v) {
			$cleanv = $v['value'];
			if (!$v['changed']) {
			} else {
				$cleanv = is_string($cleanv) ? trim($cleanv) : $cleanv;
				switch ($v['data_type']) {
				case XOBJ_DTYPE_TXTBOX:
					if ($v['required'] && $cleanv != '0' && $cleanv == '') {
						$this->setErrors("$k is required.");
						continue;
					}
					if (isset($v['maxlength']) && strlen($cleanv) > intval($v['maxlength'])) {
						$this->setErrors("$k must be shorter than ".intval($v['maxlength'])." characters.");
						continue;
					}
					if (!$v['not_gpc']) {
						$cleanv = $ts->stripSlashesGPC($ts->censorString($cleanv));
					} else {
						$cleanv = $ts->censorString($cleanv);
					}
					break;
				case XOBJ_DTYPE_TXTAREA:
					if ($v['required'] && $cleanv != '0' && $cleanv == '') {
						$this->setErrors("$k is required.");
						continue;
					}
					if (!$v['not_gpc']) {
						$cleanv = $ts->stripSlashesGPC($ts->censorString($cleanv));
					} else {
						$cleanv = $ts->censorString($cleanv);
					}
					break;
				case XOBJ_DTYPE_SOURCE:
					if (!$v['not_gpc']) {
						$cleanv = $ts->stripSlashesGPC($cleanv);
					} else {
						$cleanv = $cleanv;
					}
					break;

				case XOBJ_DTYPE_INT:
					$cleanv = intval($cleanv);
					break;

				case XOBJ_DTYPE_FLOAT:
					$cleanv = floatval($cleanv);
					break;

				case XOBJ_DTYPE_BOOL:
					$cleanv = $cleanv ? 1 : 0;
					break;

				case XOBJ_DTYPE_EMAIL:
					if ($v['required'] && $cleanv == '') {
						$this->setErrors("$k is required.");
						continue;
					}
					if ($cleanv != '' && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i",$cleanv)) {
						$this->setErrors("Invalid Email");
						continue;
					}
					if (!$v['not_gpc']) {
						$cleanv = $ts->stripSlashesGPC($cleanv);
					}
					break;
				case XOBJ_DTYPE_URL:
					if ($v['required'] && $cleanv == '') {
						$this->setErrors("$k is required.");
						continue;
					}
					if ($cleanv != '' && !preg_match("/^http[s]*:\/\//i", $cleanv)) {
						$cleanv = 'http://' . $cleanv;
					}
					if (!$v['not_gpc']) {
						$cleanv =& $ts->stripSlashesGPC($cleanv);
					}
					break;
				case XOBJ_DTYPE_ARRAY:
					$cleanv = serialize($cleanv);
					break;
				case XOBJ_DTYPE_STIME:
				case XOBJ_DTYPE_MTIME:
				case XOBJ_DTYPE_LTIME:
					$cleanv = !is_string($cleanv) ? intval($cleanv) : strtotime($cleanv);
					break;
				
				case XOBJ_DTYPE_DATE:
					if(!is_string($cleanv)){
						$cleanv = date("Y-m-d", intval($cleanv));
					}
					else{
						$cleanv = preg_replace("/[^\d-]/", "", $cleanv);
					}
					break;
				
				case XOBJ_DTYPE_DATETIME:
					if(!is_string($cleanv)){
						$cleanv = date("Y-m-d H:i:s", intval($cleanv));
					}
					else{
						$cleanv = preg_replace("/[^0-9\s:-]/", "", $cleanv);
					}
					break;
				}
			}
			$this->cleanVars[$k] =& $cleanv;
			unset($cleanv);
		}
		if (count($this->_errors) > 0) {
			return false;
		}
		$this->unsetDirty();
		return true;
	}

	function getVarsArray()
	{
		$ret = array();
		foreach($this->vars as $k => $v){
			$ret[$k] = $this->getVar($k);
		}
		return $ret;
	}
}

//******************************************************************************

class XsnsRootHandler
{
	//--------------------------------------------------------------------------
	
	var $db = NULL;
	var $module_config = NULL;
	
	var $obj_class = NULL;
	var $table_name = NULL;		// except prefix
	var $primary_key = NULL;
	
	//--------------------------------------------------------------------------
	
	function XsnsRootHandler()
	{
		global $xoopsModuleConfig, $mydirname;
		if($xoopsModuleConfig){
			$this->module_config =& $xoopsModuleConfig;
		}
		else{
			$config_handler =& xoops_gethandler('config');
			$this->module_config =& $config_handler->getConfigsByDirname($mydirname);
		}
		$this->db =& Database::getInstance();
	}
	//--------------------------------------------------------------------------
	
	function prefix($table_name)
	{
		global $mydirname;
		return $this->db->prefix($mydirname.'_'.$table_name);
	}
	//--------------------------------------------------------------------------
	
	function enabled()
	{
		if( empty($this->obj_class) || empty($this->table_name) || empty($this->primary_key) ){
			return false;
		}
		return true;
	}
	
	//--------------------------------------------------------------------------
	
	function &create($is_new = true)
	{
		$ret = false;
		if( !$this->enabled() ){
			return $ret;
		}
		$obj = new $this->obj_class();
		if($is_new){
			$obj->setNew();
		}
		$ret =& $obj;
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function insert(&$obj, $force = false)
	{
		if( !$this->enabled() || strtolower(get_class($obj)) != strtolower($this->obj_class) ){
			return false;
		}
		if( !$obj->isDirty() ){
			return true;
		}
		if( !$obj->cleanVars() ){
			return false;
		}
		
		$id = isset($obj->cleanVars[$this->primary_key])? $obj->cleanVars[$this->primary_key] : NULL;
		
		if( $obj->isNew() || empty($id) ){
			$sql_key = array();
			$sql_var = array();
			foreach( $obj->cleanVars as $k=>$v ){
				if($k != $this->primary_key && !empty($v)){
					$sql_key[] = $k;
					$sql_var[] = $this->db->quoteString($v);
				}
			}
			if(count($sql_key)==0 || count($sql_var)==0){
				return false;
			}
			$sql = "INSERT INTO ". $this->prefix($this->table_name).
					"(".implode(",", $sql_key).") VALUES (". implode(",", $sql_var).")";
		}
		else{
			$sql_arr = array();
			foreach( $obj->vars as $k=>$v ){
				if($k != $this->primary_key && $v['changed']){
					$sql_arr[] = $k."=".$this->db->quoteString($obj->cleanVars[$k]);
				}
			}
			if(count($sql_arr)==0){
				return false;
			}
			$sql = "UPDATE ".$this->prefix($this->table_name).
					" SET ". implode(",", $sql_arr).
					" WHERE ".$this->primary_key."='".intval($id)."'";
		}
		
		$result = ($force)? $this->db->queryF($sql) : $this->db->query($sql);
		if( !$result ){
			$obj->setErrors('ERROR<br />'.$this->db->error().' ('.$this->db->errno().')<br />'.$sql);
			return false;
		}
		if( empty($id) ){
			$id = $this->db->getInsertId();
		}
		$obj->assignVar($this->primary_key, $id);
		return $id;
	}
	
	//--------------------------------------------------------------------------
	
	function delete(&$obj)
	{
		if( !$this->enabled() || strtolower(get_class($obj)) != strtolower($this->obj_class)){
			return false;
		}
		
		$id = $obj->getVar($this->primary_key);
		if(!$id){
			return false;
		}
		
		$sql = "DELETE FROM ".$this->prefix($this->table_name).
				" WHERE ".$this->primary_key."='".intval($id)."'";
		if($result = $this->db->query($sql)){
			return true;
		}
		return false;
	}
	
	//--------------------------------------------------------------------------
	
	function deleteObjects($criteria)
	{
		if(!isset($criteria) || !is_subclass_of($criteria, 'criteriaelement')){
			return false;
		}
		
		$obj_list =& $this->getObjects($criteria);
		foreach($obj_list as $obj){
			$this->delete($obj);
		}
		return true;
	}
	//--------------------------------------------------------------------------
	
	function &get($id)
	{
		$ret = false;
		if (intval($id) > 0) {
			$sql = "SELECT * FROM ".$this->prefix($this->table_name).
					" WHERE ".$this->primary_key."='".intval($id)."'";
			if ($result = $this->db->query($sql)) {
				$numrows = $this->db->getRowsNum($result);
				if ($numrows == 1) {
					$obj = new $this->obj_class();
					$obj->assignVars($this->db->fetchArray($result));
					$ret = $obj;
				}
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getObjects($criteria = NULL, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = "SELECT * FROM ".$this->prefix($this->table_name);
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " ".$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($row = $this->db->fetchArray($result)) {
			$obj = new $this->obj_class();
			$obj->assignVars($row);
			if (!$id_as_key) {
				$ret[] = $obj;
			}
			else {
				$ret[$row[$this->primary_key]] = $obj;
			}
			unset($obj);
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getCount($criteria = NULL)
	{
		$sql = "SELECT COUNT(*) FROM ".$this->prefix($this->table_name);
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " ".$criteria->renderWhere();
		}
		
		if($result = $this->db->query($sql)){
			$row = $this->db->fetchRow($result);
			return $row[0];
		}
		return 0;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
