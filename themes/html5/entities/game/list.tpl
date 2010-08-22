<nav id="support" class="list">
	<h2><?= __('list','list_supports')?></h2>
	<ul>
    <? foreach($data['supports'] as $id=>$category): ?>
        <li<?= ($data['support_selected']==$category->getAttribute('name')?" class=\"selected\"":"")?>>
        	<? __link(	"games/".$category->getAttribute('name'),
        				$category->getInfo('name'),
        				__s('list','list_view_title',$category->getInfo('description'))
        				);?>
        </li>
    <? endforeach; ?>
	</ul>
	<h2><?= __('list','list_games')?></h2>
    <ul>
    <? if($data['games']) :?>
    	<? foreach($data['games'] as $id=>$game): ?>
	    	<?php if($id!="meta") :?>
	        <li<?= ($data['game_selected']==$game['id']?" class=\"selected\"":"")?>>
	        	<?php  __link(	"game/".$game['id'],
	        					$game['title'],
	        					__s('game','view_title',$game['title'])
	        					);?>
	        </li>
	        <?php endif;?>
    	<? endforeach; ?>
    <?else : ?>
    	<?= __('game','no_game')?>
    <?endif;?>
    </ul>
</nav>