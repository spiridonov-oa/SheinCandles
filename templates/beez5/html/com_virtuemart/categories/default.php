<?php
/**
*
* Show the products in a category
*
* @package	VirtueMart
* @subpackage
* @author RolandD
* @author Max Milbers
* @todo add pagination
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2012 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
 * @version $Id: default.php 6104 2012-06-13 14:15:29Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if ($this->category->haschildren) {

// Category and Columns Counter
$iCol = 1;
$iCategory = 1;

// Calculating Categories Per Row
$categories_per_row = VmConfig::get ( 'categories_per_row', 3 );
$category_cellwidth = ' width'.floor ( 100 / $categories_per_row );

// Separator
$verticalseparator = " vertical-separator";
?>

<div class="category-view category-view-home">

<?php // Start the Output
if ($this->category->children ) {
	echo '<div class="row">';

	foreach ( $this->category->children as $category ) {

	    // Show the vertical separator
	    if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
		    $show_vertical_separator = ' ';
	    } else {
		    $show_vertical_separator = $verticalseparator;
	    }

	    // Category Link
	    $caturl = JRoute::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id );

		    // Show Category ?>
		    <div class="category col-lg-4 col-md-4 col-sm-6 col-xs-12 <?php echo $show_vertical_separator ?>">
			    <div class="spacer">
				    
					    <a href="<?php echo $caturl ?>" data-title="<?php echo $category->category_name ?>">
							
					    <?php // if ($category->ids) {
						    echo $category->images[0]->displayMediaThumb("",false);
					    //} ?>
					    <h2>
							<?php echo $category->category_name ?>
							</h2>
					    </a>
				    
			    </div>
		    </div>
	    <?php
	    $iCategory ++;

    }
	echo '</div>';
}
?>
</div>

<?php //**-** Вызов модуля position-4 который выводит Новости
    $document   = & JFactory::getDocument();
    $renderer   = $document->loadRenderer('modules');
    $options    = array('style' => 'xhtml');
    $position4   = 'position-4';
    echo $renderer->render($position4, $options, null);      
?>

<div id="benefits" class="container">
	<ul class="benefits-content row">
		<li class="col-xs-12">Мы являемся производителями, поэтому Вы получаете продукцию по самой низкой цене на рынке.</li>
		<li class="col-xs-12">Наша продукция полностью сертифицирована и выполнена из высококачественных материалов.</li>
		<li class="col-xs-12">Специальные предложения для рекламных агентств, декораторов и организаторов мероприятий.</li>
		<li class="col-xs-12">100% гарантия сроков изготовления.</li>
		<li class="col-xs-12">Система скидок для постоянных клиентов.</li>
		<li class="col-xs-12">Работаем с доставкой.</li>
	</ul>
</div>
<div class="item-page">
	<h4>Свеча</h4>
	<p>Незаменимый атрибут для создания романтической атмосферы и приятной обстановки. История создания и изготовления свечей превышает 2000 лет и долгое время они находили применение лишь в домах состоятельных людей, так как стоимость их была очень высока.<br /> Шло время, зарождались и менялись технологии и традиции, росли требования человека к комфорту - совершенствовалось и производство свечей. Пройдя огромный путь с момента создания до наших дней свеча уже не является просто предметом, способным осветить часть дома, квартиры или комнаты, а зачастую используется как элемент дизайна и отражение хорошего вкуса. Различные свечи продолжают завоёвывать сердца людей и становятся всё более популярными в развитых странах. Сегодняшние свечи символизируют праздник, помогают создать романтическую обстановку, успокаивают человека, и являются интересной частью декора, неся с собой в дом уют и комфорт.</p>

	<ul>
		<li>
		<h4>Подарочные свечи</h4>
		Изумительный подарок, который всегда найдет применение. Свечи бывают настолько разнообразны, что выбрать необычный подарок не составит проблем.
		</li>
		<li>
		<h4>Свечи с различными ароматами</h4>
		Подарят вам хорошее настроение и удовольствие от исключительно приятного, располагающего к расслаблению и медитативным практикам, умиротворяющего аромата.
		</li>
		<li>
		<h4>Свечи в стекле</h4>
		Свечи выполненные в разнообразных стеклянных формах, и подкупают своей красотой и аккуратностью. Идеально подходят для украшения столов и различных интерьеров.
		</li>
		<li>
		<h4>Резные свечи</h4>
		Настоящее произведение искусства. Каждая свеча уникальна и вырезается вручную руками опытных мастеров. Такие свечи являются шикарными подарками к различным праздникам. Так же есть специальный раздел Свадебных свечей.
		</li>
		<li></li>
	</ul>

	<h4>Свечи с логотипами</h4>
	<p>Если вам хочется действительно отличиться и иметь уникальные свечи с логотипом своей компании или любым другим изображением тогда это для вас.</p>
</div>
<?php } ?>