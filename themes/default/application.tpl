<?echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title><?= __('home','title').(isset($data['game'])?" - ".$data['game']->getInfo('title'):"")?></title>
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/screen.css" media="screen" id="<?=$data['theme']?>" />
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/jquery.lightbox-0.5.css" media="screen" id="<?=$data['theme']?>.lightbox" />
        <script type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="scripts/jquery.lightbox-0.5.pack.js"></script>
        <script>
        $(document).ready(function() {
		   $('a[rel*=lightbox]').lightBox({
			overlayBgColor: '#000',
			overlayOpacity: 0.8,
			imageLoading: 'images/icons/lightbox/lightbox-btn-loading.gif',
			imageBtnClose: 'images/icons/lightbox/lightbox-btn-close.gif',
			imageBtnPrev: 'images/icons/lightbox/lightbox-btn-prev.gif',
			imageBtnNext: 'images/icons/lightbox/lightbox-btn-next.gif',
			containerResizeSpeed: 350,
			txtImage: '<?= __('lightbox','image_lightbox_label')?>',
			txtOf: '<?= __('lightbox','image_lightbox_de_label')?>'
		   });
		});
		</script>
    </head>
    <body>
        <div id="page">
          <div id="header">
            <h1><?= __('home','title') ?></h1>
          </div>
          	<? __render();?>
          <div class="clear"></div>
          <div id="footer">
            <p>Copyright &copy; 2010 - Frédéric Delorme&lt;<a href="mailto:frederic.delorme@gmail.com&subject=Demo PHP" title="">frederic.delorme@gmail.com</a>;&gt;</p>
          </div>
        </div>
    </body>
</html>