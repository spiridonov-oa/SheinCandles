<?php defined('_JEXEC') or die;
defined('_JEXEC') or die('(@)|(@)');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
// Подключаем стили и скрипты модуля
$doc = JFactory::getDocument();
$doc
	->addStyleSheet('/modules/mod_callback/css/style.css')
	->addScript('/modules/mod_callback/js/callback.js')
?>

<form id="contactForm" action="" method="" class="form-validate">
	<div id="sendinfo"><img src="/modules/mod_callback/images/loader.gif" width="55" height="55" alt="" /></div>
	<div id="cfholder">
	<?php foreach ($form->getFieldset('callback') as $field): ?>
		<?php echo $field->label; ?>
		<?php echo $field->input; ?>
	<?php endforeach; ?>
	<?php echo JHtml::_('form.token'); ?>
	<input type="hidden" name="callback[info]" value="<?php echo JFactory::getDocument()->getTitle(); ?>" />
	<input type="hidden" name="callback[url]" value="<?php echo JURI::current(); ?>" />
	<button type="submit" class="validate">Отправить</button>
	</div>
</form>