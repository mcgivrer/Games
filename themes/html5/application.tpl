<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title><?= __s('application','page_title',(isset($data['game'])?" &gt; ".$data['game']->getInfo('support')." &gt; ".$data['game']->getInfo('title'):""))?></title>
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/screen.css" media="screen" id="<?=$data['theme']?>" />
        <link rel="stylesheet" type="text/css" href="themes/<?=$data['theme']?>/styles/jquery.lightbox-0.5.css" media="screen" id="<?=$data['theme']?>.lightbox" />
        <script type="text/javascript" src="scripts/jquery.lightbox-0.5.pack.js"></script>
        <!--[if IE]>
		<script type="text/javascript" src="themes/<?=$data['theme']?>/scripts/html5shiv.js"></script>
		<![endif]-->
        <script type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="themes/<?=$data['theme']?>/scripts/theme.js"></script>
    </head>
    <body>
        <div id="page">
          <header id="header">
          	<div class="user">
          			<? if(isset($data['user-connected'])) :?>
          				<? __link("user/edit",__('user','user_connected'),__('user','user_connected_title'))?>&nbsp;&gt;&nbsp;
          				<? __link("user/logout",__('user','logout'),__('user','logout_title'))?>
          			<? else :?>
          				<? __link("user/login",__('user','login'),__('user','login_title'))?>
          			<? endif;?>
          	</div>
          	<div class="theme">
          		<form name="theme" method="post" action="?action=setTheme">
					<p><?= __('application','theme_title')?> <select id="theme" name="theme" onchange="submit();">
          			<?php foreach($data['themes'] as $theme) :?>
          			<option value="<?= $theme->shortname?>" <?=($theme->shortname == $data['theme']?"selected = \"selected\"":"")?>><?= $theme->name?></option>
          			<?php endforeach;?>
          			</select></p>
          		</form>
          		<form name="theme" method="post" action="?search/&action=search">
          			<p><input type="search" name="search" id="search" placeholder="search" size="14" maxlength="30"/></p>
          		</form>
          	</div>
            <h1><?= __('application','title') ?></h1>
          </header>
          	<? __render();?>
          <div class="clear"></div>
          <footer id="footer">
            <p>Copyright &copy; 2010 - Frédéric Delorme&lt;<a href="mailto:frederic.delorme@gmail.com&amp;subject=Demo&x20;PHP" title="">frederic.delorme@gmail.com</a>&gt; - <?= __s('application','generatedTime',__enlapsedTime());?></p>
          </footer>
        </div>
    </body>
</html>