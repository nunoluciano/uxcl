<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$root =& XCube_Root::getSingleton();

// check flag once for preventing double registering
if( ! $root->mContext->hasAttribute( 'PicalBlocks_Registered' ) ) {

	$root->mDelegateManager->add( "Legacy_Utils.CreateBlockProcedure" , "PicalBlocksFactory::createInstance" , dirname(dirname(__FILE__)).'/class/pical_blocks_factory.php' ) ;

	// turn the flag on
	$root->mContext->setAttribute( 'PicalBlocks_Registered' , true ) ;
}

?>