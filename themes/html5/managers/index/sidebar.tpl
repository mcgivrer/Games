<nav id="support" class="list">
	<h2><?= __('list','list_supports')?></h2>
	<? __renderEntity('support','list',$data)?>
	<h2><?= __('list','list_games')?></h2>
	<? __renderEntity('game','list',$data)?>
</nav>