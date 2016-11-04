<?php
/**
 * @package		Joomla.Site
 * @subpackage	Templates.beez5
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// check modules
$showRightColumn	= ($this->countModules('position-3') or $this->countModules('position-6') or $this->countModules('position-8'));
$showbottom			= ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showleft			= ($this->countModules('position-4') or $this->countModules('position-7') or $this->countModules('position-5'));

if ($showRightColumn==0 and $showleft==0) {
	$showno = 0;
}

JHtml::_('behavior.framework', true);

// get params
$color			= $this->params->get('templatecolor');
$logo			= $this->params->get('logo');
$navposition	= $this->params->get('navposition');
$app			= JFactory::getApplication();
$doc			= JFactory::getDocument();
$templateparams	= $app->getTemplate(true)->params;

?>
<?php if(!$templateparams->get('html5', 0)): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php else: ?>
	<?php echo '<!DOCTYPE html>'; ?>
<?php endif; ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>
		<script
			src="https://code.jquery.com/jquery-2.2.4.js"
			integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
			crossorigin="anonymous">

		</script>
		<script>
			$.noConflict();
		</script>

		<jdoc:include type="head" />
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/maincss.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/print.css" type="text/css" media="Print" />

<?php /* 
	$files = JHtml::_('stylesheet', 'templates/'.$this->template.'/css/general.css', null, false, true);
	if ($files):
		if (!is_array($files)):
			$files = array($files);
		endif;
		foreach($files as $file):
?>
		<link rel="stylesheet" href="<?php echo $file;?>" type="text/css" />
<?php
	 	endforeach;
	endif;

?>
		<?php if ($this->direction == 'rtl') : ?>
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template_rtl.css" type="text/css" />
		<?php endif; */ ?>
<?php /*
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/bootstrap/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/bootstrap/css/bootstrap-responsive.min.css" type="text/css" />

        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/bootstrap/js/bootstrap.js"></script>
*/?>
	</head>

	<body>
<div id="smoke">
                                
                            </div>
<div id="all">
	<div id="back">
	<?php if(!$templateparams->get('html5', 0)): ?>
		<div id="header">
			<?php else: ?>
		<header id="header">
			<?php endif; ?>
					<nav class="navbar navbar-default navbar-fixed-top">
						<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-controls="navbar">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a class="navbar-brand" href="/"><img class="img-responsive" src="/images/logo.png" alt="Shein Candles"></a>
							</div>
							<div class="collapse navbar-collapse" id="navbar-collapse-1">
								<div class="navbar-right">
									<jdoc:include type="modules" name="position-1" />
								</div>
							</div>
						</div>
					</nav>
					<div class="contacts-phones">
						<div class="row">
							<div class="col-sm-6">
								<span>Возникли вопросы?</span>
								<span>Звоните:</span>
							</div>
							<div class="col-sm-6">
								<a href="tel:+380577507300" style="font-size: 1em; font-weight: bold;">+38 057 750 73 00</a>&nbsp;&nbsp;
								<a href="tel:+380987373300" style="font-size: 1em; font-weight: bold;">+38 098 73 73 300</a>
							</div>
						</div>
					</div>
					<div class="logoheader">
						<img src="<?php echo $this->baseurl ?>/images/logo.png" alt="" />
					</div><!-- end logoheader -->
                </header><!-- end header -->
		
		<div id="<?php echo $showRightColumn ? 'contentarea2' : 'contentarea'; ?>">
					
								<jdoc:include type="modules" name="position-7" style="beezDivision" headerLevel="3" />
								
								<jdoc:include type="modules" name="position-5" style="beezTabs" headerLevel="2"  id="3" />

					<div id="<?php echo $showRightColumn ? 'wrapper' : 'wrapper2'; ?>" <?php if (isset($showno)){echo 'class="shownocolumns"';}?>>

						<div id="main">

						<?php if ($this->countModules('position-12')): ?>
							<div id="top"><jdoc:include type="modules" name="position-12"   />
							</div>
						<?php endif; ?>


							<jdoc:include type="message" />
							<jdoc:include type="component" />

						<?php if ($this->countModules('position-10')): ?>
							<div id="top"><jdoc:include type="modules" name="position-10"   />
							</div>
						<?php endif; ?>

						</div><!-- end main -->

					</div><!-- end wrapper -->

				<?php if ($showRightColumn) : ?>
					<h2 class="unseen">
						<?php echo JText::_('TPL_BEEZ5_ADDITIONAL_INFORMATION'); ?>
					</h2>
					<div id="close">
						<a href="#" onclick="auf('right')">
							<span id="bild">
								<?php echo JText::_('TPL_BEEZ5_TEXTRIGHTCLOSE'); ?></span></a>
					</div>

				<?php if (!$templateparams->get('html5', 0)): ?>
					<div id="right">
				<?php else: ?>
					<aside id="right">
				<?php endif; ?>

						<a id="additional"></a>
						<jdoc:include type="modules" name="position-6" style="beezDivision" headerLevel="3"/>
						<jdoc:include type="modules" name="position-8" style="beezDivision" headerLevel="3"  />
						<jdoc:include type="modules" name="position-3" style="beezDivision" headerLevel="3"  />

				<?php if(!$templateparams->get('html5', 0)): ?>
					</div><!-- end right -->
				<?php else: ?>
					</aside>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($navposition=='center' and $showleft) : ?>

				<?php if (!$this->params->get('html5', 0)): ?>
					<div class="left <?php if ($showRightColumn==NULL){ echo 'leftbigger';} ?>" id="nav" >
				<?php else: ?>
					<nav class="left <?php if ($showRightColumn==NULL){ echo 'leftbigger';} ?>" id="nav">
				<?php endif; ?>

						<jdoc:include type="modules" name="position-7"  style="beezDivision" headerLevel="3" />
						<jdoc:include type="modules" name="position-4" style="beezHide" headerLevel="3" state="0 " />
						<jdoc:include type="modules" name="position-5" style="beezTabs" headerLevel="2"  id="3" />

				<?php if (!$templateparams->get('html5', 0)): ?>
					</div><!-- end navi -->
				<?php else: ?>
					</nav>
				<?php endif; ?>
			<?php endif; ?>

					<div class="wrap"></div>
                                 

				</div> <!-- end contentarea -->

			</div><!-- back -->

		</div><!-- all -->

		<div id="footer-outer">

		<?php /**-** if ($showbottom) : ?>
			<div id="footer-inner">

				<div id="bottom">
					
				</div>
			</div>
		<?php endif ; **+**/?>

			<div id="footer-sub">

			<?php if (!$templateparams->get('html5', 0)): ?>
				<div id="footer">
			<?php else: ?>
				<footer id="footer">
			<?php endif; ?>

					<jdoc:include type="modules" name="position-14" />
					

			<?php if (!$templateparams->get('html5', 0)): ?>
				</div><!-- end footer -->
			<?php else: ?>
				</footer>
			<?php endif; ?>

			</div>

		</div>
		<jdoc:include type="modules" name="debug" />


    <!-- Call -->



<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter31138241 = new Ya.Metrika({
                    id:31138241,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/31138241" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    <!-- RedHelper -->
<script id="rhlpscrtg" type="text/javascript" charset="utf-8" async="async" 
 src="https://web.redhelper.ru/service/main.js?c=candles">
</script> 
<!--/Redhelper -->

	</body>
</html>
