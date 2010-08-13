<nav id="support" class="list">
	<h2><?= __('list','list_supports')?></h2>
	<ul>
    <? foreach($data['supports'] as $id=>$category): ?>
        <li<?= ($data['support_selected']==$category->getAttribute('support')?" class=\"selected\"":"")?>>
        	<a href="<?= "?s=".$category->getAttribute('support') ?>" title="<?= __s('list','list_view_title',$category->getInfo('support'))?>"><?= $category->getInfo('support')?></a>
        </li>
    <? endforeach; ?>
	</ul>
	<h2><?= __('list','list_games')?></h2>
    <ul>
    <? foreach($data['games'] as $id=>$game): ?>
    	<?php if($id!="meta") :?>
        <li<?= ($data['game_selected']==$game['id']?" class=\"selected\"":"")?>><a href="<?= "?g=".$game['id'] ?>" title="<?= __s('game','view_title',$game['title'])?>"><?= $game['title']?></a></li>
        <?php endif;?>
    <? endforeach; ?>
    </ul>
</nav>