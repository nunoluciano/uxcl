<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsCategory extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsCategory()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_commu_category_id', XOBJ_DTYPE_INT);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('sort_order', XOBJ_DTYPE_INT);
		$this->initVar('c_commu_category_parent_id', XOBJ_DTYPE_INT);
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsCategoryHandler extends XsnsRootHandler
{
	var $handler = NULL;
	//--------------------------------------------------------------------------
	
	function XsnsCategoryHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsCategory";
		$this->table_name = "c_commu_category";
		$this->primary_key = "c_commu_category_id";
		
		$this->handler = array(
			'cat_parent' => XsnsCategoryParentHandler::getInstance(),
			'community' => XsnsCommunityHandler::getInstance(),
		);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsCategoryHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getNameList()
	{
		$obj_list = $this->getObjects(NULL, true);
		$ret = array();
		foreach($obj_list as $key => $obj){
			$ret[$key] = $obj->getVar('name');
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getSelectorHtml($selector_name, $default_id=0, $default_str=NULL)
	{
		$cat_obj_list = array();
		
		$sql = "SELECT c.* FROM ".
				$this->prefix($this->table_name). " c,".
				$this->prefix('c_commu_category_parent')." cp".
				" WHERE c.c_commu_category_parent_id=cp.c_commu_category_parent_id".
				" ORDER BY cp.sort_order,c.sort_order";
		$rs = $this->db->query($sql);
		while($row = $this->db->fetchArray($rs)){
			$obj = new $this->obj_class();
			$obj->assignVars($row);
			$cat_obj_list[] = $obj;
			unset($obj);
		}
		
		$ret = "<select name='".$selector_name."'>\n";
		
		if(!is_null($default_str)){
			$selected = ($default_id==0)? " selected" : "";
			$ret.= "<option value='0'".$selected.">".$default_str."</option>\n";
		}
		
		foreach($cat_obj_list as $cat_obj){
			$cat_id = $cat_obj->getVar('c_commu_category_id');
			$selected = ($default_id==$cat_id)? " selected" : "";
			$ret.= "<option value='".$cat_id."'".$selected.">".$cat_obj->getVar('name')."</option>\n";
		}
		$ret.= "</select>\n";
		
		return $ret;
	}
	//------------------------------------------------------------------------------
	
	function updateSelector()
	{
		$criteria = new CriteriaCompo();
		$criteria->setSort('sort_order');
		$cat_parent_obj_list =& $this->handler['cat_parent']->getObjects($criteria);
		unset($criteria);
		
		foreach($cat_parent_obj_list as $cat_parent_obj){
			$pid = $cat_parent_obj->getVar('c_commu_category_parent_id');
			
			$criteria = new Criteria('c_commu_category_parent_id', $pid);
			$criteria->setSort('sort_order');
			$cat_obj_list =& $this->getObjects($criteria);
			
			$count = 0;
			$child = "";
			
			foreach($cat_obj_list as $cat_obj){
				$id = $cat_obj->getVar('c_commu_category_id');
				
				$criteria2 = new Criteria('c_commu_category_id', $id);
				$commu_count = $this->handler['community']->getCount($criteria2);
				
				$label = $cat_obj->getVar('name'). "<small>(".$commu_count.")</small>";
				$separator = ($count==0)? "" : "&nbsp;- ";
				$child .= $separator."<a href='[XSNS_URL]/?cat_id=".$id."'><nobr>".$label."</nobr></a>";
				
				unset($criteria2);
				$count++;
			}
			if(empty($child)){
				$child = "<span></span>";	// NOT NULL
			}
			$cat_parent_obj->setVar('selector', $child);
			if(!$this->handler['cat_parent']->insert($cat_parent_obj)){
				return false;
			}
			unset($criteria, $cat_obj_list);
		}
		return true;
	}
}

//******************************************************************************

?>
