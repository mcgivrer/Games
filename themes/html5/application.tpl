<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title><?= __s('application','page_title',$data['page-title'])?></title>
        <link rel="stylesheet" type="text/css" href="themes/default/styles/manager.css" media="screen" id="<?=$data['theme']?>" />
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/screen.css" media="screen" id="<?=$data['theme']?>" />
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/jquery.lightbox-0.5.css" media="screen" id="<?=$data['theme']?>.lightbox" />
        <!--[if IE]>
		<script type="text/javascript" src="themes/<?=$data['theme']?>/scripts/html5shiv.js"></script>
		<![endif]-->
        <script type="text/javascript" src="public/scripts/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="themes/<?=$data['theme']?>/scripts/theme.js"></script>
        <script type="text/javascript" src="public/scripts/jquery.lightbox-0.5.pack.js"></script>
    </head>
    <body>
        <div id="page">
          <header id="header">
          	<div class="theme">
          		<form name="theme" method="post" action="?theme/">
					<p><?= __('application','theme_title')?> <select id="theme" name="theme" onchange="submit();">
          			<?php foreach($data['themes'] as $theme) :?>
          			<option value="<?= $theme->shortname?>" <?=($theme->shortname == $data['theme']?"selected = \"selected\"":"")?>><?= $theme->name?></option>
          			<?php endforeach;?>
          			</select></p>
          		</form>
          		<form name="theme" method="post" action="?search/&action=search">
          			<p><input type="search" name="search" id="search" placeholder="search" size="14" maxlength="30"/></p>
          		</form>
				<? __renderPartial('user','admin/user',$data)?>
          	</div>
            <h1><?= __s('application','title',$data['page-title']) ?></h1>
          </header>
          	<? __render();?>
          <div class="clear"></div>
          <footer id="footer">
            <p><?=__s('application','footer', __s('application','generatedTime',__enlapsedTime()));?></p>
          </footer>
        </div>
    </body>
</html>