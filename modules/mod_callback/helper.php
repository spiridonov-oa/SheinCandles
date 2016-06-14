<?php defined('_JEXEC') or die;

class ModCallbackHelper
{
	public static function getForm()
	{
		$myForm = new JForm('callback');
// Добавили путь где лежит форма здесь form.xml лежит в корне модуля
		$myForm->addFormPath(__DIR__);
// Прочитали и вернули
		$myForm->loadFile('form', false);
		return $myForm;
	}
}

?>