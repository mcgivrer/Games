<div class="user">
<? if(isset($data['user-connected'])) :?>
	<img src="<?= $data['user-connected']->getPictureThumbs('avatar')?>" alt="avatar of <?= $data['user-connected']->getInfo('username')?>"/>
	<span><?= __s('user','welcome_title',$data['user-connected']->getInfo('firstname'),$data['user-connected']->getInfo('lastname'))?></span>
	<? __link("user/edit",__('user','user_connected'),__('user','user_connected_title'), array('class'=>"button user-logout"))?>&nbsp;&gt;&nbsp;
	<? __link("user/logout",__('user','logout'),__('user','logout_title'), array('class'=>"button user-edit"))?>
<? else :?>
	<? __link("user/register",__('user','register'),__('user','register_title'), array('class'=>"button user-register"))?>
	<? __link("user/login",__('user','login'),__('user','login_title'), array('class'=>"button user-login"))?>
<? endif;?>
</div>