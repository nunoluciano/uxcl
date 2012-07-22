<?php

if( ! class_exists( 'PicalBlocksFactory' ) ) {

class PicalBlocksFactory
{
	function createInstance(&$instance, $xoopsBlock)
	{
		if( $xoopsBlock->get( 'show_func' ) == 'pical_after_schedule_show_tpl' ) {
			$instance = new Pical_AfterScheduleBlockProcedure( $xoopsBlock ) ;
		} else if( $xoopsBlock->get( 'show_func' ) == 'pical_thedays_schedule_show_tpl' ) {
			$instance = new Pical_ThedaysScheduleBlockProcedure( $xoopsBlock ) ;
		} else if( $xoopsBlock->get( 'show_func' ) == 'pical_minical_ex_show' ) {
			$instance = new Pical_MinicalExBlockProcedure( $xoopsBlock ) ;
		}
	}
}

class Pical_AfterScheduleBlockProcedure extends Legacy_BlockProcedureAdapter
{
	function getTitle()
	{
		return sprintf( $this->_mBlock->get('title') , @$GLOBALS['pical_after_schedule_title_parameter'] ) ;
	}
}

class Pical_ThedaysScheduleBlockProcedure extends Legacy_BlockProcedureAdapter
{
	function getTitle()
	{
		return sprintf( $this->_mBlock->get('title') , @$GLOBALS['pical_thedays_schedule_title_parameter'] ) ;
	}
}

class Pical_MinicalExBlockProcedure extends Legacy_BlockProcedureAdapter
{
	function execute()
	{
		$this->_mBlock->set( 'options' , $this->_mBlock->get('options') . '|' . $this->_mBlock->get('bid') ) ;
		parent::execute() ;
	}
}

}

?>