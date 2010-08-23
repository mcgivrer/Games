<div id="support" class="list">
	<h2><?= __('list','list_supports')?></h2>
	<ul>
    <? foreach($data['supports'] as $id=>$support): ?>
        <li<?= ($data['support_selected']==$support->getAttribute('name')?" class=\"selected\"":"")?>>
        	<a href="<?= "?games/".$support->getAttribute('name') ?>" title="<?= __s('list','list_view_title',$support->getInfo('description'))?>"><?= $support->getInfo('name')?></a>
        </li>
    <? endforeach; ?>
	</ul>
	<h2><?= __('list','list_games')?></h2>
    <ul>
    <? foreach($data['games'] as $id=>$game): ?>
    	<?php if($id!="meta") :?>
        <li<?= ($data['game_selected']==$game['id']?" class=\"selected\"":"")?>><a href="<?= "?game/".$game['id'] ?>" title="<?= __s('game','view_title',$game['title'])?>"><?= $game['title']?></a></li>
        <?php endif;?>
    <? endforeach; ?>
    </ul>
</div>