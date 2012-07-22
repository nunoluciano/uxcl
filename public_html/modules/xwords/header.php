<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$mydirname = basename( dirname( __FILE__ ) ) ;
$MYDIRNAME = strtoupper($mydirname);

include "../../mainfile.php";

global $xoopsConfig, $xoopsModuleConfig;

// include the default language file for the module interface
if ( file_exists( XOOPS_ROOT_PATH . "/modules/$mydirname/language/" . $xoopsConfig['language'] . "/" . $xoopsModuleConfig['letterformat']) )
	{
	include (XOOPS_ROOT_PATH . "/modules/$mydirname/language/" . $xoopsConfig['language'] . "/" . $xoopsModuleConfig['letterformat'] );
	}
else
	{
	include (XOOPS_ROOT_PATH . "/modules/$mydirname/language/japanese/letter.php");
	}

include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/include/functions.php" );

$xoopsModule = XoopsModule::getByDirname("$mydirname");
$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;
$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;

if( ! class_exists( 'XwordsTextSanitizer' ) )
	{
	include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/class/xwords.textsanitizer.php" ) ;
	}
$myts = & XwordsTextSanitizer::getInstance();

        // モジュールID  // added by naao
        $module_handler =& xoops_gethandler('module');
        $this_module =& $module_handler->getByDirname($mydirname);
        $mid = $this_module->getVar('mid');
 
        // モジュールconfig  // added by naao
        $config_handler =& xoops_gethandler("config");
        $mod_config = $config_handler->getConfigsByCat(0, $mid);
        $mod_config['mybl_path'] = 'modules/'. $mod_config['com_agent']. '/blocks/blocks.php';
        $xoopsTpl->assign("moduleConfig", $mod_config);
 

?>