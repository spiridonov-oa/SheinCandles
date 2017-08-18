<?php defined('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */
JHTML::stylesheet('plugins/system/onepage/onepage.css');
// Check to ensure this file is included in Joomla!
$plugin = JPluginHelper::getPlugin('system', 'onepage');
$params = new JRegistry($plugin->params);
?>
<div class="billto-shipto">
    <div class="container">
        <div class="row">
            <h2 class="col-xs-12"><?php echo JText::_('COM_VIRTUEMART_ORDER_FORM_CART'); ?></h2>
        </div>
    </div>

    <div class="container cart-container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

		<span class="none"><span class="vmicon vm2-billto-icon"></span>
            <?php echo JText::_('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></span>

                <div class="output-billto none">
                    <div class="clear"></div>
                </div>

                <?php
                if (JFactory::getUser()->get('id') == 0 && VmConfig::get('oncheckout_show_register')) {
                    ?>
                    <input class="inputbox" type="checkbox" name="register" id="register" value="1"
                           onclick="toggle_register(this.checked);" <?php echo $params->get('check_register') ? 'checked="checked"' : ''; ?>/>
                    <?php echo JText::_('COM_VIRTUEMART_REGISTER'); ?>
                    <?php
                }
                $userFields = array('agreed', 'name', 'username', 'password', 'password2');
                echo '<div id="div_billto">';
                echo '	<table class="adminform user-details" id="table_user" ' . ($params->get('check_register') ? '' : 'style="display:none"') . '>' . "\n";
                foreach ($this->helper->BTaddress["fields"] as $_field) {
                    if (!in_array($_field['name'], $userFields)) {
                        continue;
                    }
                    if ($_field['name'] == 'agreed') {
                        continue;
                    }
                    echo '		<tr>' . "\n";
                    echo '			<td class="key">' . "\n";
                    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
                    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
                    echo '				</label>' . "\n";
                    echo '			</td>' . "\n";
                    echo '			<td>' . "\n";
                    echo '				' . $_field['formcode'] . "\n";
                    echo '			</td>' . "\n";
                    echo '		</tr>' . "\n";
                }
                echo '	</table>' . "\n";
                echo '	<table class="adminform user-details" id="table_billto">' . "\n";
                foreach ($this->helper->BTaddress["fields"] as $_field) {
                    if (in_array($_field['name'], $userFields)) {
                        continue;
                    }
                    echo '		<tr>' . "\n";
                    echo '			<td class="key">' . "\n";
                    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
                    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
                    echo '				</label>' . "\n";
                    echo '			</td>' . "\n";
                    echo '			<td>' . "\n";
                    if ($_field['name'] == 'zip') {
                        $_field['formcode'] = str_replace('input', 'input onchange="update_form();"', $_field['formcode']);
                    } else if ($_field['name'] == 'virtuemart_country_id') {
                        $_field['formcode'] = str_replace('<select', '<select onchange="update_form();"', $_field['formcode']);
                    } else if ($_field['name'] == 'virtuemart_state_id') {
                        $_field['formcode'] = str_replace('<select', '<select onchange="update_form();"', $_field['formcode']);
                    }
                    echo '				' . $_field['formcode'] . "\n";
                    echo '			</td>' . "\n";
                    echo '		</tr>' . "\n";
                }
                echo '	</table>' . "\n";
                echo '</div>';
                ?>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12" id="div_shipto">
                <span class="vmicon vm2-shipto-icon none"></span>

                <div class="output-shipto none">
                    <?php
                    if (!empty($this->cart->STaddress['fields'])) {
                        if (!class_exists('VmHtml')) require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
                        echo JText::_('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
                        ?>
                        <input class="inputbox" type="checkbox" name="STsameAsBT"
                               id="STsameAsBT" <?php echo $params->get('check_shipto_address') == 1 ? 'checked="checked"' : ''; ?>
                               value="1" onclick="set_st(this);"/><br/>
                        <?php
                    }
                    ?>
                    <div class="clear"></div>
                </div>
                <?php if (!isset($this->cart->lists['current_id'])) $this->cart->lists['current_id'] = 0; ?>
                <?php
                echo '	<table class="adminform user-details" id="table_shipto" ' . ($params->get('check_shipto_address') == 1 ? 'style="display:none"' : '') . '>' . "\n";
                foreach ($this->helper->STaddress["fields"] as $_field) {
                    echo '		<tr>' . "\n";
                    echo '			<td class="key">' . "\n";
                    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
                    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
                    echo '				</label>' . "\n";
                    echo '			</td>' . "\n";
                    echo '			<td>' . "\n";
                    if ($_field['name'] == 'shipto_zip') {
                        $_field['formcode'] = str_replace('input', 'input onchange="update_form();"', $_field['formcode']);
                    } else if ($_field['name'] == 'shipto_virtuemart_country_id') {
                        $_field['formcode'] = str_replace('<select', '<select onchange="update_form();add_countries();"', $_field['formcode']);
                        $_field['formcode'] = str_replace('class="virtuemart_country_id', 'class="shipto_virtuemart_country_id', $_field['formcode']);
                    } else if ($_field['name'] == 'shipto_virtuemart_state_id') {
                        $_field['formcode'] = str_replace('id="virtuemart_state_id"', 'id="shipto_virtuemart_state_id"', $_field['formcode']);
                        $_field['formcode'] = str_replace('<select', '<select onchange="update_form();"', $_field['formcode']);
                    }
                    echo '				' . $_field['formcode'] . "\n";
                    echo '			</td>' . "\n";
                    echo '		</tr>' . "\n";
                }
                echo '	</table>' . "\n";
                ?>


                <div class="sectiontableentry1">
                    <div colspan="4" align="left">
                        <?php // echo $this->cart->cartData['shipmentName']; ?>

                        <?php
                        echo JText::_('COM_VIRTUEMART_CART_SELECTSHIPMENT');
                        if (!empty($this->layoutName) && $this->layoutName == 'default') {
                            echo "<fieldset id='shipments'>";
                            foreach ($this->helper->shipments_shipment_rates as $rates) {
                                echo str_replace("input", 'input onclick="update_form();"', $rates) . "<br />";
                            }
                            echo "</fieldset>";
                        } else {
                            JText::_('COM_VIRTUEMART_CART_SHIPPING');
                        }
                        if (VmConfig::get('show_tax')) { ?>
                            <div
                                align="right"><?php echo "<span  class='priceColor2' id='shipment_tax'>" . $this->currencyDisplay->createPriceDiv('shipmentTax', '', $this->cart->pricesUnformatted['shipmentTax'], false) . "</span>"; ?> </div>
                        <?php } ?>
                        <div align="right"
                             id="shipment"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceShipment', '', $this->cart->pricesUnformatted['salesPriceShipment'], false); ?> </div>
                    </div>
                </div>

                <div class="sectiontableentry1">
                    <div colspan="4" align="left">
                        <?php
                        echo JText::_('COM_VIRTUEMART_CART_SELECTPAYMENT');
                        if (!empty($this->layoutName) && $this->layoutName == 'default') {
                            echo "<fieldset id='payments'>";
                            foreach ($this->helper->paymentplugins_payments as $payments) {
                                echo str_replace('type="radio"', 'type="radio" onclick="update_form();"', $payments) . "<div></div>";
                            }
                            echo "</fieldset>";
                        } else {
                            JText::_('COM_VIRTUEMART_CART_PAYMENT');
                        }
                        ?> </div>
                    <?php if (VmConfig::get('show_tax')) { ?>
                        <div
                            align="right"><?php echo "<span  class='priceColor2' id='payment_tax'>" . $this->currencyDisplay->createPriceDiv('paymentTax', '', $this->cart->pricesUnformatted['paymentTax'], false) . "</span>"; ?> </div>
                    <?php } ?>
                    <div
                        align="right"><?php //echo "<span  class='priceColor2'>".$this->cart->prices['paymentDiscount']."</span>"; ?></div>
                    <div align="right"
                         id="payment"><?php  echo $this->currencyDisplay->createPriceDiv('salesPricePayment', '', $this->cart->pricesUnformatted['salesPricePayment'], false); ?> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>

<fieldset id="cart-contents">
    <div class="cart-summary container">
        <div class="row hidden-xs header-row">
            <div class="col-sm-4 col-xs-12" align="left"><?php echo JText::_('COM_VIRTUEMART_CART_NAME') ?></div>
            <div class="col-sm-2 hidden-xs" align="center"><?php echo JText::_('COM_VIRTUEMART_CART_PRICE') ?></div>
            <div class="col-sm-2 col-xs-6" align="center"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY') ?></div>
            <div class="col-sm-2 hidden-xs"
                 align="right"><?php echo "<span  class='priceColor2'>" . JText::_('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?></div>
            <div class="col-sm-2 col-xs-6" align="right"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?></div>
        </div>

        <?php
        $i = 1;
        foreach ($this->cart->products as $pkey => $prow) {
            ?>
            <div class="row sectiontableentry<?php echo $i ?>" id="product_row_<?php echo $pkey; ?>">
                <div class="col-sm-4 col-xs-12" align="left">
                    <?php if ($prow->virtuemart_media_id) { ?>
                        <span class="cart-images">
						 <?php
                            if (!empty($prow->image)) echo $prow->image->displayMediaThumb('', false);
                            ?>
						</span>
                    <?php } ?>
                    <strong><?php echo JHTML::link($prow->url, $prow->product_name) . $prow->customfields; ?></strong>
                    <?php  echo $prow->product_sku ?>
                </div>
                <div class="col-sm-2 hidden-xs" align="center">
                    <?php echo $this->currencyDisplay->createPriceDiv('salesPrice','', $this->cart->pricesUnformatted[$pkey],false); ?>
                </div>
                <div class="col-sm-2 col-xs-6" align="center">
                    <input type="text" title="<?php echo JText::_('COM_VIRTUEMART_CART_UPDATE') ?>"
                           class="inputbox update-quantity"
                           onblur="update_form('update_product','<?php echo $pkey; ?>');" size="3" maxlength="4"
                           value="<?php echo $prow->quantity ?>" id='quantity_<?php echo $pkey; ?>'/>
                    <a class="glyphicon glyphicon-trash" title="<?php echo JText::_('COM_VIRTUEMART_CART_DELETE') ?>"
                       align="middle" href="javascript:void(0)"
                       onclick="update_form('remove_product','<?php echo $pkey; ?>')"> </a>
                </div>
                <div class="col-sm-2 hidden-xs"
                     align="right"><?php echo "<span  class='priceColor2' id='subtotal_discount_" . $pkey . "'>" . $this->currencyDisplay->createPriceDiv('discountAmount', '', $this->cart->pricesUnformatted[$pkey], false, false, $prow->quantity) . "</span>" ?></div>
                <div class="col-sm-2 col-xs-6" align="right" id="subtotal_with_tax_<?php echo $pkey; ?>">
                    <?php
                    if (VmConfig::get('checkout_show_origprice', 1) && !empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceWithTax'] != $this->cart->pricesUnformatted[$pkey]['salesPrice']) {
                        echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv('basePriceWithTax', '', $this->cart->pricesUnformatted[$pkey], true, false, $prow->quantity) . '</span><br />';
                    }
                    echo $this->currencyDisplay->createPriceDiv('salesPrice', '', $this->cart->pricesUnformatted[$pkey], false, false, $prow->quantity);
                    ?>
                </div>
            </div>
            <?php
            //echo "<pre>";print_r($this->cart->pricesUnformatted['salesPrice']);echo "</pre>";
            $i = 1 ? 2 : 1;
        } ?>
        <!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
        <?php if (VmConfig::get('show_tax')) {
            $colspan = 3;
        } else {
            $colspan = 2;
        } ?>

        <div class="row sectiontableentry1">
            <div class="col-sm-1 col-sm-offset-7 col-offset-1 col-xs-6"
                align="right"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></div>

            <?php if (VmConfig::get('show_tax')) { ?>
                <div class="col-sm-1 hidden-xs" align="right"><?php echo "<span  class='priceColor2' id='tax_amount'>" . $this->currencyDisplay->createPriceDiv('taxAmount', '', $this->cart->pricesUnformatted, false) . "</span>" ?></div>
            <?php } ?>
            <div class="col-sm-1 hidden-xs" align="right"><?php echo "<span  class='priceColor2' id='discount_amount'>" . $this->currencyDisplay->createPriceDiv('discountAmount', '', $this->cart->pricesUnformatted, false) . "</span>" ?></div>
            <div class="col-sm-2 col-xs-5" align="right"
                id="sales_price"><?php echo $this->currencyDisplay->createPriceDiv('salesPrice', '', $this->cart->pricesUnformatted, false) ?></div>
        </div>

        <?php
        if (VmConfig::get('coupons_enable')) {
            ?>
            <div class="row sectiontableentry2">
                <div class="col-sm-1 col-sm-offset-7 col-offset-1 col-xs-6" align="left">
                    <?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
                        echo $this->loadTemplate('coupon');
                    }
                    ?>

                    <?php
                    echo "<span id='coupon_code_txt'>" . @$this->cart->cartData['couponCode'] . "</span>";
                    echo @$this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
                    ?>

                </div>
                <?php if (VmConfig::get('show_tax')) { ?>
                    <div class="col-sm-1 hidden-xs" align="right"
                        id="coupon_tax"><?php echo $this->currencyDisplay->createPriceDiv('couponTax', '', @$this->cart->pricesUnformatted['couponTax'], false); ?> </div>
                <?php } ?>
                <div class="col-sm-1 hidden-xs" align="right">&nbsp;</div>
                <div class="col-sm-2 col-xs-5" align="right"
                    id="coupon_price"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceCoupon', '', @$this->cart->pricesUnformatted['salesPriceCoupon'], false); ?> </div>
            </div>
        <?php } ?>


        <?php
        foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) { ?>
            <div class="row sectiontableentry<?php $i ?>">
                <div class="col-sm-1 col-sm-offset-7  col-offset-1 col-xs-6" align="right"><?php echo $rule['calc_name'] ?> </div>

                <?php if (VmConfig::get('show_tax')) { ?>
                    <div class="col-sm-1 hidden-xs" align="right"></div>
                <?php } ?>
                <div class="col-sm-1 hidden-xs" align="right"> <?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], false);  ?></div>
                <div class="col-sm-2 col-xs-5" align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], false);   ?> </div>
            </div>
            <?php
            if ($i) $i = 1; else $i = 0;
        } ?>

        <?php

        foreach ($this->cart->cartData['taxRulesBill'] as $rule) { ?>
            <div class="row sectiontableentry<?php $i ?>">
                <div class="col-sm-1 col-sm-offset-7 col-offset-1 col-xs-6" align="right"><?php echo $rule['calc_name'] ?> </div>
                <?php if (VmConfig::get('show_tax')) { ?>
                    <div class="col-sm-1 hidden-xs" align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], false); ?> </div>
                <?php } ?>
                <div class="col-sm-1 hidden-xs" align="right"><?php    ?> </div>
                <div class="col-sm-2 col-xs-5" align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], false);   ?> </div>
            </div>
            <?php
            if ($i) $i = 1; else $i = 0;
        }

        foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) { ?>
            <div class="row sectiontableentry<?php $i ?>">
                <div class="col-sm-1 col-sm-offset-7 col-offset-1 col-xs-6" align="right"><?php echo $rule['calc_name'] ?> </div>

                <?php if (VmConfig::get('show_tax')) { ?>
                    <div class="col-sm-1 hidden-xs" align="right"></div>

                <?php } ?>
                <div class="col-sm-1 hidden-xs" align="right"><?php  echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], false);   ?>  </div>
                <div class="col-sm-2 col-xs-5" align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], false);   ?> </div>
            </div>
            <?php
            if ($i) $i = 1; else $i = 0;
        } ?>

        <?php /*
	<tr class="sectiontableentry1">
				<td colspan="4" align="left">
				<?php // echo $this->cart->cartData['shipmentName']; ?>
				    <br />
				<?php
				echo JText::_('COM_VIRTUEMART_CART_SELECTSHIPMENT');
				if(!empty($this->layoutName) && $this->layoutName=='default') {
					echo "<fieldset id='shipments'>";					
						foreach($this->helper->shipments_shipment_rates as $rates) {
								echo str_replace("input",'input onclick="update_form();"',$rates)."<br />";
						}
					echo "</fieldset>";
				} else {
				    JText::_('COM_VIRTUEMART_CART_SHIPPING');
				}
                if ( VmConfig::get('show_tax')) { ?>
				<td align="right"><?php echo "<span  class='priceColor2' id='shipment_tax'>".$this->currencyDisplay->createPriceDiv('shipmentTax','', $this->cart->pricesUnformatted['shipmentTax'],false)."</span>"; ?> </td>
                <?php } ?>
				<td></td>
				<td align="right" id="shipment"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceShipment','', $this->cart->pricesUnformatted['salesPriceShipment'],false); ?> </td>
		</tr>

		<tr class="sectiontableentry1">
				<td colspan="4" align="left">
				<?php 
				echo JText::_('COM_VIRTUEMART_CART_SELECTPAYMENT');
				if(!empty($this->layoutName) && $this->layoutName=='default') { 
					echo "<fieldset id='payments'>";
						foreach($this->helper->paymentplugins_payments as $payments) {
							echo str_replace('type="radio"','type="radio" onclick="update_form();"',$payments)."<br />";
						}
					echo "</fieldset>";
				} else {
					JText::_('COM_VIRTUEMART_CART_PAYMENT'); 
				}
				?> </td>
                <?php if ( VmConfig::get('show_tax')) { ?>
				<td align="right"><?php echo "<span  class='priceColor2' id='payment_tax'>".$this->currencyDisplay->createPriceDiv('paymentTax','', $this->cart->pricesUnformatted['paymentTax'],false)."</span>"; ?> </td>
                <?php } ?>
				<td align="right"><?php //echo "<span  class='priceColor2'>".$this->cart->prices['paymentDiscount']."</span>"; ?></td>
				<td align="right" id="payment"><?php  echo $this->currencyDisplay->createPriceDiv('salesPricePayment','', $this->cart->pricesUnformatted['salesPricePayment'],false); ?> </td>
		</tr>
*/ ?>

        <div class="row sectiontableentry2">
            <div class="col-sm-1 col-sm-offset-7 col-offset-1 col-xs-6" align="right"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?>:</div>

            <?php if (VmConfig::get('show_tax')) { ?>
                <div class="col-sm-1 hidden-xs" align="right"> <?php echo "<span  class='priceColor2' id='total_tax'>" . $this->currencyDisplay->createPriceDiv('billTaxAmount', '', $this->cart->pricesUnformatted['billTaxAmount'], false) . "</span>" ?> </div>
            <?php } ?>
            <div class="col-sm-1 hidden-xs" align="right"> <?php echo "<span  class='priceColor2' id='total_amount'>" . $this->currencyDisplay->createPriceDiv('billDiscountAmount', '', $this->cart->pricesUnformatted['billDiscountAmount'], false) . "</span>" ?> </div>
            <div class="col-sm-2 col-xs-5" align="right"><strong
                    id="bill_total"><?php echo $this->currencyDisplay->createPriceDiv('billTotal', '', $this->cart->pricesUnformatted['billTotal'], false) ?></strong>
            </div>
        </div>
        <?php
        if ($this->totalInPaymentCurrency) {
            ?>

            <div class="row sectiontableentry2">
                <div class="col-sm-1 col-sm-offset-7 col-offset-1 col-xs-6" align="right"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</div>

                <?php if (VmConfig::get('show_tax')) { ?>
                    <div class="col-sm-1 hidden-xs" align="right"></div>
                <?php } ?>
                <div class="col-sm-1 hidden-xs" align="right"></div>
                <div class="col-sm-2 col-xs-5" align="right">
                    <strong><?php echo $this->currencyDisplay->createPriceDiv('totalInPaymentCurrency', '', $this->totalInPaymentCurrency, false); ?></strong>
                </div>
            </div>
            <?php
        }
        ?>


    </div>
</fieldset>
