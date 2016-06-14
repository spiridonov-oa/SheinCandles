<?php
header('Content-Type: text/html; charset=utf-8');
// Подтверждение того, что файл вызывается внутри фреймворка.
define('_JEXEC', 1);
// Добавляем здесь столько «прыжков» чтобы прийти в корень сайта
define('JPATH_BASE', dirname(__FILE__) . '/../..');
// Подключение основных файлов фреймворка Joomla.
require_once(JPATH_BASE. '/includes/defines.php');
require_once(JPATH_BASE. '/includes/framework.php');
// Инициализация приложения, теперь мы можем обращаться к API фреймворка
JFactory::getApplication('site')->initialise();

// Стартует сессия пользователя + счётчик обращений к скрипту
$session = JFactory::getSession();
$count = $session->get('count', 0) + 1;
$session->set('count', $count);
// Получаем параметры модуля
$send_params = $session->get('send_params');
// Получаем дату
$date = JFactory::getDate();
// Преобразуем текущую дату к желаемому виду.
$datestr = $date->format ('l, d F Y в h:m:s');

// Получение данных из формы
JSession::checkToken('post') or die('@|@');
$jinput = JFactory::getApplication()->input;
$data = $jinput->get('callback', array(), 'array', 'post');
// Проверка полученных данных
if(!preg_match('/^[-\sa-zа-яё]{3,25}+$/ui', $data['name'])) { 
   $error = 1;
}
if(!preg_match('/^[-+_\s\.\(\)@a-z0-9]{5,25}+$/ui', $data['phone'])) { 
   $error = 1;
}
if(!preg_match('/^[-_\s\.,:;"!\?\+\(\)%№\*«»a-zа-яё0-9]{0,350}+$/ui', $data['message'])) { 
   $error = 1;
}

// Если есть ошибки в форме или пользователь отправил больше 7 соощений - выходим
if($error != 0 || $count>7) {
   echo 'error';
   exit;
}

// Получаем настройки сайта
$config = & JFactory::getConfig();
// Получаем экземпляр класса JMail
$mailer = JFactory::getMailer();
// Указываем отправителя письма
$mailer->setSender(array($config->get('config.mailfrom'), $config->get('config.fromname')));
// Указываем получателя письма
$mailer->addRecipient($send_params->get('cfemail'));
// Указываем тему письма
$mailer->setSubject($send_params->get('cftheme'));
// Указываем что письмо будет в формате HTML
$mailer->IsHTML(true);
// Формируем тело сообщения
if ($data['message']) {
	$body = '<div style="font-size: 14px;"><p><b>Дата и время отправки: </b>' . $datestr . '<br /><b>Имя отправителя:</b> ' . $data['name'] . '<br /><b>Телефон или E-mail:</b> ' . $data['phone'] . '<br /><b>Сообщение:</b> ' . $data['message'] . '<br /></p><p><b>Отправлено со страницы:</b> <a href="' . $data['url'] . '">&#171;' . $data['info'] . '&#187;</a><br /><b>IP отправителя:</b> ' . $_SERVER[REMOTE_ADDR] . '</p></div>';
} else {
	$body = '<div style="font-size: 14px;"><p><b>Дата и время отправки: </b>' . $datestr . '<br /><b>Имя отправителя:</b> ' . $data['name'] . '<br /><b>Телефон или E-mail:</b> ' . $data['phone'] . '<br /></p><p><b>Отправлено со страницы:</b> <a href="' . $data['url'] . '">&#171;' . $data['info'] . '&#187;</a><br /><b>IP отправителя:</b> ' . $_SERVER[REMOTE_ADDR] . '</p></div>';
}
$mailer->setBody($body);
// Отправка email сообщения
$mailer->send();

echo 'success';

?>