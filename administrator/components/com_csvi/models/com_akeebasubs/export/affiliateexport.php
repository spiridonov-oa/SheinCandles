<?php
/**
 * Subscription export class
 *
 * @package 	CSVI
 * @subpackage 	Export
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2013 RolandD Cyber Produksi. All rights reserved.
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: couponexport.php 1760 2012-01-02 19:50:19Z RolandD $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Processor for coupons exports
 *
 * @package 	CSVI
 * @subpackage 	Export
 */
class CsviModelAffiliateExport extends CsviModelExportfile {

	// Private variables
	private $_exportmodel = null;

	/**
	 * Subscription export
	 *
	 * Exports subscription details data to either csv, xml or HTML format
	 *
	 * @copyright
	 * @author		RolandD
	 * @todo
	 * @see
	 * @access 		public
	 * @param
	 * @return 		void
	 * @since 		3.0
	 */
	public function getStart() {
		// Get some basic data
		$db = JFactory::getDbo();
		$csvidb = new CsviDb();
		$jinput = JFactory::getApplication()->input;
		$csvilog = $jinput->get('csvilog', null, null);
		$template = $jinput->get('template', null, null);
		$exportclass =  $jinput->get('export.class', null, null);
		$export_fields = $jinput->get('export.fields', array(), 'array');

		// Build something fancy to only get the fieldnames the user wants
		$userfields = array();
		foreach ($export_fields as $column_id => $field) {
			if ($field->process) {
				switch ($field->field_name) {
					case 'user_id':
					case 'akeebasubs_affiliate_id':
						$userfields[] = $db->quoteName('#__akeebasubs_affiliates').'.'.$db->quoteName($field->field_name);
						break;
					case 'money_owed':
					case 'money_paid':
					case 'total_commission':
						$userfields[] = $db->quoteName('#__akeebasubs_affiliates').'.'.$db->quoteName('akeebasubs_affiliate_id');
						break;
					case 'custom':
						break;
					default:
						$userfields[] = $db->quoteName($field->field_name);
						break;
				}
			}
		}

		// Build the query
		$userfields = array_unique($userfields);
		$query = $db->getQuery(true);
		$query->select(implode(",\n", $userfields));
		$query->from('#__akeebasubs_affiliates');
		$query->leftJoin('#__akeebasubs_affpayments ON #__akeebasubs_affpayments.akeebasubs_affiliate_id = #__akeebasubs_affiliates.akeebasubs_affiliate_id');
		$query->leftJoin('#__users ON #__users.id = #__akeebasubs_affiliates.user_id');
		
		// Check if there are any selectors
		$selectors = array();
		
		// Filter by published state
		$publish_state = $template->get('publish_state', 'general');
		if ($publish_state !== '' && ($publish_state == 1 || $publish_state == 0)) {
			$selectors[] = '#__akeebasubs_affiliates.enabled = '.$publish_state;
		}
		
		// Check if we need to attach any selectors to the query
		if (count($selectors) > 0 ) $query->where(implode("\n AND ", $selectors));
		
		// Ignore some custom fields
		$ignore = array('money_owed', 'money_paid', 'total_commission');
		
		// Check if we need to group the orders together
		$groupby = $template->get('groupby', 'general', false, 'bool');
		if ($groupby) {
			$filter = $this->getFilterBy('groupby', $ignore);
			if (!empty($filter)) $query->group($filter);
		}

		// Order by set field
		$orderby = $this->getFilterBy('sort', $ignore);
		if (!empty($orderby)) $query->order($orderby);

		// Add a limit if user wants us to
		$limits = $this->getExportLimit();

		// Execute the query
		$csvidb->setQuery($query, $limits['offset'], $limits['limit']);
		$csvilog->addDebug(JText::_('COM_CSVI_EXPORT_QUERY'), true);
		// There are no records, write SQL query to log
		if (!is_null($csvidb->getErrorMsg())) {
			$this->addExportContent(JText::sprintf('COM_CSVI_ERROR_RETRIEVING_DATA', $csvidb->getErrorMsg()));
			$this->writeOutput();
			$csvilog->AddStats('incorrect', $csvidb->getErrorMsg());
		}
		else {
			$logcount = $csvidb->getNumRows();
			$jinput->set('logcount', $logcount);
			if ($logcount > 0) {
				while ($record = $csvidb->getRow()) {
					if ($template->get('export_file', 'general') == 'xml' || $template->get('export_file', 'general') == 'html') $this->addExportContent($exportclass->NodeStart());
					foreach ($export_fields as $column_id => $field) {
						$fieldname = $field->field_name;
						// Add the replacement
						if (isset($record->$fieldname)) $fieldvalue = CsviHelper::replaceValue($field->replace, $record->$fieldname);
						else $fieldvalue = '';
						switch ($fieldname) {
							case 'money_owed':
								$query1 = $db->getQuery(true);
								$query1->select('akeebasubs_affiliate_id, SUM(affiliate_comission) AS money_owed');
								$query1->from('#__akeebasubs_subscriptions');
								$query1->where('state = '.$db->Quote('C'));
								$query1->where('akeebasubs_affiliate_id = '.$record->akeebasubs_affiliate_id);
								$query1->group('akeebasubs_affiliate_id');
								
								$query2 = $db->getQuery(true);
								$query2->select('akeebasubs_affiliate_id, SUM(amount) AS money_paid');
								$query2->from('#__akeebasubs_affpayments');
								$query2->where('akeebasubs_affiliate_id = '.$record->akeebasubs_affiliate_id);
								$query2->group('akeebasubs_affiliate_id');
								
								$query = $db->getQuery(true);
								$query->select('money_owed-money_paid AS balance');
								$query->from('#__akeebasubs_affiliates');
								$query->leftJoin('('.$query1.') AS o USING ('.$db->quoteName('akeebasubs_affiliate_id').')');
								$query->leftJoin('('.$query2.') AS p USING ('.$db->quoteName('akeebasubs_affiliate_id').')');
								$query->where('akeebasubs_affiliate_id = '.$record->akeebasubs_affiliate_id);
								$db->setQuery($query);
								$fieldvalue = $db->loadResult();
								$fieldvalue =  number_format($fieldvalue, $template->get('export_price_format_decimal', 'general', 2, 'int'), $template->get('export_price_format_decsep', 'general'), $template->get('export_price_format_thousep', 'general'));
								if (strlen(trim($fieldvalue)) == 0) $fieldvalue = $field->default_value;
								$this->addExportField($field->combine, $fieldvalue, $fieldname, $field->column_header);
								break;
							case 'money_paid':
								$query = $db->getQuery(true);
								$query->select('SUM(amount) AS money_paid');
								$query->from('lwraz_akeebasubs_affpayments');
								$query->where('akeebasubs_affiliate_id = '.$record->akeebasubs_affiliate_id);
								$db->setQuery($query);
								$fieldvalue = $db->loadResult();
								$fieldvalue =  number_format($fieldvalue, $template->get('export_price_format_decimal', 'general', 2, 'int'), $template->get('export_price_format_decsep', 'general'), $template->get('export_price_format_thousep', 'general'));
								if (strlen(trim($fieldvalue)) == 0) $fieldvalue = $field->default_value;
								$this->addExportField($field->combine, $fieldvalue, $fieldname, $field->column_header);
								break;
							case 'total_commission':
								$query = $db->getQuery(true);
								$query->select('SUM(affiliate_comission) AS total_commision');
								$query->from('#__akeebasubs_subscriptions');
								$query->where('state = '.$db->Quote('C'));
								$query->where('akeebasubs_affiliate_id = '.$record->akeebasubs_affiliate_id);
								$query->group('akeebasubs_affiliate_id');
								$db->setQuery($query);
								$fieldvalue = $db->loadResult();
								$fieldvalue =  number_format($fieldvalue, $template->get('export_price_format_decimal', 'general', 2, 'int'), $template->get('export_price_format_decsep', 'general'), $template->get('export_price_format_thousep', 'general'));
								if (strlen(trim($fieldvalue)) == 0) $fieldvalue = $field->default_value;
								$this->addExportField($field->combine, $fieldvalue, $fieldname, $field->column_header);
								break;
							case 'created_on':
								$date = JFactory::getDate($record->$fieldname);
								$fieldvalue = CsviHelper::replaceValue($field->replace, date($template->get('export_date_format', 'general'), $date->toUnix()));
								$this->addExportField($field->combine, $fieldvalue, $fieldname, $field->column_header);
								break;
							default:
								// Check if we have any content otherwise use the default value
								if (strlen(trim($fieldvalue)) == 0) $fieldvalue = $field->default_value;
								$this->addExportField($field->combine, $fieldvalue, $fieldname, $field->column_header);
								break;
						}
					}
					if ($template->get('export_file', 'general') == 'xml' || $template->get('export_file', 'general') == 'html') {
						$this->addExportContent($exportclass->NodeEnd());
					}

					// Output the contents
					$this->writeOutput();
				}
			}
			else {
				$this->addExportContent(JText::_('COM_CSVI_NO_DATA_FOUND'));
				// Output the contents
				$this->writeOutput();
			}
		}
	}
}
?>