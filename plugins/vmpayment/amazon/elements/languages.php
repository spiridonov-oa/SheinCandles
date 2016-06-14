<?php
defined('_JEXEC') or die();

/**
 *
 * @package    VirtueMart
 * @subpackage Plugins  - Elements
 * @author Valérie Isaksen
 * @version $Id: languages.php 8229 2014-08-23 16:56:12Z alatak $
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - March 09 2015 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
if (!class_exists('VmConfig')) {
	require(JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
}

if (!class_exists('ShopFunctions')) {
	require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'shopfunctions.php');
}
if (!class_exists('TableCategories')) {
	require(JPATH_VM_ADMINISTRATOR . DS . 'tables' . DS . 'categories.php');
}

if (!class_exists('VmElements')) {
	require(JPATH_VM_ADMINISTRATOR . DS . 'elements' . DS . 'vmelements.php');
}
/*
 * This element is used by the menu manager
 * Should be that way
 */
class JElementLanguages extends JElement {

	var $_name = 'Languages';


	function fetchElement ($name, $value, &$node, $control_name) {

		$activeLangs = array();
		$language = JFactory::getLanguage();
		$jLangs = $language->getKnownLanguages(JPATH_BASE);

		foreach ($jLangs as $jLang) {
			$jlangTag = strtolower(strtr($jLang['tag'], '-', '_'));
			$activeLangs[] = JHTML::_('select.option', $jLang['tag'], $jLang['name']);
		}
		$class = ($node->attributes('class') ? 'class="' . $node->attributes('class') . '"' : '');
		return JHTML::_('select.genericlist', $activeLangs, $control_name . '[' . $name . '][]', $class, 'value', 'text', $value, $control_name . $name);


	}

}

