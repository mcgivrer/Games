<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title><?= __s('application','page_title',(isset($data['game'])?" &gt; ".$data['game']->getInfo('support')." &gt; ".$data['game']->getInfo('title'):""))?></title>
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/screen.css" media="screen" id="<?=$data['theme']?>" />
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/jquery.lightbox-0.5.css" media="screen" id="<?=$data['theme']?>.lightbox" />
        <script type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="scripts/jquery.lightbox-0.5.pack.js"></script>
        <script type="text/javascript" src="themes/<?=$data['theme']?>/scripts/theme.js"></script>
    </head>
    <body>
        <div id="page">
          <header id="header">
          	<div class="theme">
          		<form name="theme" method="post" action="?action=setTheme">
					<p><?= __('application','theme_title')?> <select id="theme" name="theme" onchange="submit();">
          			<?php foreach($data['themes'] as $theme) :?>
          			<option value="<?= $theme->shortname?>" <?=($theme->shortname == $data['theme']?"selected = \"selected\"":"")?>><?= $theme->name?></option>
          			<?php endforeach;?>
          			</select></p>
          		</form>
          	</div>
            <h1><?= __('application','title') ?></h1>
          </header>
          	<? __render();?>
          <div class="clear"></div>
          <footer id="footer">
            <p>Copyright &copy; 2010 - Frédéric Delorme&lt;<a href="mailto:frederic.delorme@gmail.com&subject=Demo PHP" title="">frederic.delorme@gmail.com</a>&gt;</p>
          </footer>
        </div>
    </body>
</html>