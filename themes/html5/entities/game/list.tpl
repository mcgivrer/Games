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