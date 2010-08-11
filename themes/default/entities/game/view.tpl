<div id="game">
	<form id="upload" method="POST" enctype="multipart/form-data" action="index.php&no-cache" >
		<h2><?= $data->getInfo('support') ?> / <?= $data->getInfo('title') ?></h2>
		<div class="file">
			<a href="<?= $data->getPicture('cover',1,"","#")?>" title="open cover picture in full size">
			    <img src="<?= $data->getPictureThumb('cover',1,__('game','default_image_cover'))?>" title="cover for <?= $data->getInfo('title') ?>" alt="box cover of game '<?=$data->getInfo('title') ?>'">
			</a>			
			<ul class="infos">
				<li><span class="label"><?= __('list','author')?></span><?= $data->getInfo('author') ?></li>
				<li><span class="label"><?= __('list','note')?></span><?= $data->getInfo('note') ?></li>
				<li>
					<span class="label fullwidth"><?= __('list','comment')?></span>
					<div class="comment">
			    	<?= $data->getInfo('comment') ?>
					</div>
				</li>
			</ul>
			<?php if($roles['admin']):?>
			<div class="upload">
				<input type="hidden" name="entity" value="<?=$data->getInfo('entityName')?>"/>
				<input type="hidden" name="gid" value="<?=$data->getInfo('id')?>"/>
				<input name="txt_file" type="file" id="txt_file" size="50" value="file"/> <br/>
	  			<input type="submit" name="upload" value="Upload" accesskey="ENTER" tabindex="1" />
  			</div>
  			<?php endif;?>
		</div>
	</form>
</div>