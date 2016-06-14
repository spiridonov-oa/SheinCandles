<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
*
* @version $Id: admin.virtuemart.php 6246 2012-07-09 19:00:20Z Milbo $
* @package VirtueMart
* @subpackage core
* @copyright Copyright (C) VirtueMart Team - All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/


if (!class_exists( 'VmConfig' )) require(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();

vmRam('Start');
vmSetStartTime('Start');

VmConfig::loadJLang('com_virtuemart');

$_controller = vRequest::getCmd('view', vRequest::getCmd('controller', 'virtuemart'));

// check for permission Only vendor and Admin can use VM2 BE
// this makes trouble somehow, we need to check if the perm object works not too strict maybe
if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
if($_controller!='updatesmigration' and !Permissions::getInstance()->isSuperVendor()){
// if(!Permissions::getInstance()->check('admin','storeowner')){
	$app = JFactory::getApplication();
	vmError( 'Access restricted to Vendor and Administrator only (you are admin and should not see this messsage?)','Access restricted to Vendors and Administrator only' );
	$app->redirect('index.php');
} else if($_controller=='updatesmigration'){
	if(!Permissions::getInstance()->check('admin')){
		$app = JFactory::getApplication();
		vmError( 'Access restricted to Administrators only (you are admin and should not see this messsage?)','Access restricted to Vendors and Administrator only' );
		$app->redirect('index.php');
	}
}

vmJsApi::jQuery();

// Require specific controller if requested
if($_controller) {
	if (file_exists(JPATH_VM_ADMINISTRATOR.DS.'controllers'.DS.$_controller.'.php')) {
		// Only if the file exists, since it might be a Joomla view we're requesting...
		require (JPATH_VM_ADMINISTRATOR.DS.'controllers'.DS.$_controller.'.php');
	} else {
		// try plugins
		JPluginHelper::importPlugin('vmextended');
		$dispatcher = JDispatcher::getInstance();
		$results = $dispatcher->trigger('onVmAdminController', array($_controller));
		if (empty($results)) {
			$app = JFactory::getApplication();
			$app->enqueueMessage('Fatal Error in maincontroller admin.virtuemart.php: Couldnt find file '.$_controller);
			$app->redirect('index.php?option=com_virtuemart');
		}
	}
}

// Create the controller
$_class = 'VirtueMartController'.ucfirst($_controller);
$controller = new $_class();

// Perform the Request task
$controller->execute(vRequest::getCmd('task', $_controller));

vmTime($_class.' Finished task '.$_controller,'Start');
vmRam('End');
vmRamPeak('Peak');
$controller->redirect();

// pure php no closing tag