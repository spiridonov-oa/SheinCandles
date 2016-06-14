<?php defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// Отправляем параметры модуля в обработчик ajax запросов
$session = JFactory::getSession();
$session->set('send_params', $params);
// Подключаем файл помошник
require_once dirname(__FILE__). '/helper.php';
// Активируем проверку токена формы
JSession::getFormToken(true);
// Получаем форму из файла помошника
$form = ModCallbackHelper::getForm();
// Подключаем файл шаблона
require JModuleHelper::getLayoutPath('mod_callback', $params->get('layout', 'default'));
?>