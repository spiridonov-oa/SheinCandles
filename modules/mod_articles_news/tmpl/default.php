<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="newsflash<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :  ?>
<?php
	$images = json_decode($item->images) ; // декодируем данные о рисунке , на выходе получаем объект
	$introtext = strip_tags($item->introtext) ; // вырезаем из текста html теги
	$introtext = mb_substr($introtext,0,300,'utf-8'); // обрезаем текст
?>
	<div class="newsflash_news">
		<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
                <a href="<?php echo $item->link; ?>">
		<?php  if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
		<?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
			<img <?php if ($images->image_intro_caption) :echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';endif; ?> src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" />
		
		<?php endif; ?>
                        <p>
                <?php echo $introtext.' ...'; ?>
                </p>
                </a>
        </div>
        <div class="separator"></div>   
<?php endforeach; ?>
</div>
