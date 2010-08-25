<div id="random" class="block gallery">
	<h3><?= __('game','random_title')?></h3>
	<div class="block-content" style="text-align:center;">
	<p><?php foreach($data['randomgames'] as $id=>$rgame):?>
		<a href="<?= $rgame->getPicture('cover',1,"","#")?>" rel="lightbox[random]" title="<?= __s('game','random_show',$rgame->getInfo('support'),$rgame->getInfo('title')) ?>">
	    <span class="cover"><img src="<?= $rgame->getPictureThumb('cover',1,__('game','default_image_cover'),"120x80")?>" alt="box cover of game '<?=$rgame->getInfo('title') ?>'"></span>
		</a>
	<?php endforeach;?></p>
	</div>
</div>