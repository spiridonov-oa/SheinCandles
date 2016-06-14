<?php
defined('_JEXEC') or die('');
/**
 * abstract controller class containing get,store,delete,publish and pagination
 *
 *
 * This class provides the functions for the calculatoins
 *
 * @package	VirtueMart
 * @subpackage Helpers
 * @author Max Milbers
 * @copyright Copyright (c) 2011 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
 *
 * http://virtuemart.net
 */
// Load the view framework
jimport( 'joomla.application.component.view');
// Load default helpers

class VmView extends JView{

	var $writeJs = true;

	public function display($tpl = null)
	{
		$result = $this->loadTemplate($tpl);
		if ($result instanceof Exception) {
			return $result;
		}

		echo $result;
		if($this->writeJs and get_class($this)!='VirtueMartViewProductdetails'){
			echo vmJsApi::writeJS();
		}

	}

	public function prepareContinueLink(){

		$virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId ();
		$categoryStr = '';
		if ($virtuemart_category_id) {
			$categoryStr = '&virtuemart_category_id=' . $virtuemart_category_id;
		}

		$ItemidStr = '';
		$Itemid = shopFunctionsF::getLastVisitedItemId();
		if(!empty($Itemid)){
			$ItemidStr = '&Itemid='.$Itemid;
		}

		$this->continue_link = JRoute::_ ('index.php?option=com_virtuemart&view=category' . $categoryStr.$ItemidStr, FALSE);

		//$this->continue_link_html = '<a class="continue_link" href="' . $continue_link . '" ><span>' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</span></a>';
		$this->continue_link_html = '<a class="continue continue_link" href="' . $this->continue_link . '">' . JText::_ ('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';

		$this->cart_link = JRoute::_('index.php?option=com_virtuemart&view=cart'.$ItemidStr, FALSE);

		return;
	}

	function linkIcon($link,$altText ='',$boutonName,$verifyConfigValue=false, $modal = true, $use_icon=true,$use_text=false,$class = ''){
		if ($verifyConfigValue) {
			if ( !VmConfig::get($verifyConfigValue, 0) ) return '';
		}
		$folder = (JVM_VERSION===1) ? '/images/M_images/' : '/media/system/images/';
		$text='';
		if ( $use_icon ) $text .= JHtml::_('image.site', $boutonName.'.png', $folder, null, null, JText::_($altText));
		if ( $use_text ) $text .= '&nbsp;'. JText::_($altText);
		if ( $text=='' )  $text .= '&nbsp;'. JText::_($altText);
		if ($modal) return '<a '.$class.' class="modal" rel="{handler: \'iframe\', size: {x: 700, y: 550}}" title="'. JText::_($altText).'" href="'.JRoute::_($link, FALSE).'">'.$text.'</a>';
		else 		return '<a '.$class.' title="'. JText::_($altText).'" href="'.JRoute::_($link, FALSE).'">'.$text.'</a>';
	}

	public function escape($var)
	{
		if (in_array($this->_escape, array('htmlspecialchars', 'htmlentities')))
		{
			$result = call_user_func($this->_escape, $var, ENT_COMPAT, $this->_charset);
		} else {
			$result =  call_user_func($this->_escape, $var);
		}

		return $result;
	}
}