<?echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title><?= __('home','title').(isset($data['game'])?" - ".$data['game']->getInfo('title'):"")?></title>
        <link rel="stylesheet" type="text/css" href="themes/default/styles/screen.css" media="screen" id="default" />
        <link rel="stylesheet" type="text/css" href="themes/default/styles/manager.css" media="screen" id="default-manager" />
        <link rel="stylesheet" type="text/css" href="themes/default/styles/jquery.lightbox-0.5.css" media="screen" id="<?=$data['theme']?>.lightbox" />
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
          	<div id="loading" class="hidden"><img src="images/icons/wait.png"/></div>
			<div class="theme">
          		<form name="theme" method="post" action="?theme/"><select id="theme" name="theme" onchange="submit();">
          			<?php foreach($data['themes'] as $theme) :?>
          			<option value="<?= $theme->shortname?>" <?=($theme->shortname == $data['theme']?"selected = \"selected\"":"")?>><?= $theme->name?></option>
          			<?php endforeach;?>
          			</select>
          		</form>
				<form name="theme" method="post" action="?search/&action=search">
					<p><input type="search" name="search" id="search" placeholder="search" size="14" maxlength="30"/></p>
				</form>
          		<? __renderPartial('user','admin/user',$data)?>
          	</div>
            <h1><?= __('home','title') ?></h1>
          </div>
          <div id="page-content"><? __render();?></div>
          <div class="clear"></div>
          <div id="footer">
            <p>Copyright &copy; 2010 - Frédéric Delorme&lt;<a href="mailto:frederic.delorme@gmail.com&subject=Demo PHP" title="">frederic.delorme@gmail.com</a>&gt;</p>
          </div>
        </div>
    </body>
</html>