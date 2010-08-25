<div class="user">
	<h3><?= __('user','details_title')?></h3>
	<ul>
		<li><span><?=__('user','details_username_label')?></span>: <?= $data['user']->getInfo('username') ?></li>
		<li><span><?=__('user','details_firstname_label')?></span>: <?= $data['user']->getInfo('firstname') ?></li>
		<li><span><?=__('user','details_lastname_label')?></span>: <?= $data['user']->getInfo('lastname') ?></li>
		<li><span><?=__('user','details_email_label')?></span>: <?= $data['user']->getInfo('email') ?></li>
	</ul>
	<div class="commands">
		<a href=""><? __link('user/list',__('user','back_list'),__('user','back_list_title'),array('class'=>"button"))?></a>
	</div>
</div>