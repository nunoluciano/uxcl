<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsCategoryParent extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsCategoryParent()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_commu_category_parent_id', XOBJ_DTYPE_INT);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('sort_order', XOBJ_DTYPE_INT);
		$this->initVar('selector', XOBJ_DTYPE_TXTBOX);
	}
	
	//--------------------------------------------------------------------------
	
}

class XsnsCategoryParentHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsCategoryParentHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsCategoryParent";
		$this->table_name = "c_commu_category_parent";
		$this->primary_key = "c_commu_category_parent_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsCategoryParentHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getList()
	{
		$ret = array();
		$criteria = new CriteriaCompo(NULL);
		$criteria->setSort('sort_order');
		$obj_list =& $this->getObjects($criteria);
		if(is_array($obj_list)){
			foreach($obj_list as $obj){
				if(!is_object($obj)){
					continue;
				}
				$selector_html = $obj->getVar('selector', 'n');	// allow HTML
				$ret[] = array(
					'c_commu_category_parent_id' => $obj->getVar('c_commu_category_parent_id'),
					'name' => $obj->getVar('name'),
					'selector' => str_replace("[XSNS_URL]", XSNS_BASE_URL, $selector_html),
				);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
