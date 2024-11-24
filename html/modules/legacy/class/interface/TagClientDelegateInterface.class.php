<?php
/**
 * This Interface is generated by Cube tool.
 * @package    Legacy
 * @version    XCL 2.4.0
 * @author     Other authors gigamaster, 2020 XCL/PHP7
 * @author     code generator
 * @copyright  (c) 2005-2024 The XOOPSCube Project
 * @license    GPL 2.0
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/**
 * Interface of group client delegate
 * Modules which uses Legacy_Tag must implement this interface.
**/
interface Legacy_iTagClientDelegate
{
    /**
     * getClientList	Legacy_TagClient.{dirname}.GetClientList
     *
     * @param mixed[]	&$list
     *  @list[]['dirname']		client module dirname
     *  @list[]['dataname']		client module dataname(tablename)
     * @param string	$tDirname	Legacy_Tag module's dirname
     *
     * @return	void
     */
    public static function getClientList(/*** mixed[] ***/ &$list, /*** string ***/ $tDirname);

    /**
     * getClientData	Legacy_TagClient.{dirname}.GetClientData
     *
     * @param mixed		&$list
     *	string	$list['dirname'][]	client module dirname
     *	string	$list['dataname'][]	client module dataname(tablename)
     *	mixed	$list['data'][]
     *	string	$list['title'][]	client module title
     *	string	$list['template_name'][]
     * @param string	$dirname	client module dirname
     * @param string	$dataname	client module dataname
     * @param int[]		$idList		client module primary key list you want
     *
     * @return	void
     */
    public static function getClientData(/*** mixed ***/ &$list, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int[] ***/ $idList);
}