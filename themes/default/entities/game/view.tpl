<div id="game">
	<form id="upload" method="POST" enctype="multipart/form-data" action="index.php&no-cache" >
		<h2><?= $data['game']->getInfo('support') ?> / <?= $data['game']->getInfo('title') ?></h2>
		<div class="file">
			<a href="<?= $data['game']->getPicture('cover',1,"","#")?>" rel="lightbox" title="<?= __s('game','cover_show',$data['game']->getInfo('support'),$data['game']->getInfo('title')) ?>">
			    <img src="<?= $data['game']->getPictureThumb('cover',1,__('game','default_image_cover'))?>" title="cover for <?= $data['game']->getInfo('title') ?>" alt="box cover of game '<?=$data['game']->getInfo('title') ?>'">
			</a>			
			<ul class="infos">
				<li><span class="label"><?= __('list','author')?></span><?= $data['game']->getInfo('author') ?></li>
				<li><span class="label"><?= __('list','note')?></span><?= $data['game']->getInfo('note') ?></li>
				<li>
					<span class="label fullwidth"><?= __('list','comment')?></span>
					<div class="comment">
			    	<?= $data['game']->getInfo('comment') ?>
					</div>
				</li>
			</ul>
			<?php if(count($data['game']->getPictures('screenshots'))>0):?>
			<div class="gallery">
				<h3><?= __('game','gallery_title')?></h3>
				<div class="gallery-content">
				<?php foreach($data['game']->getPictures('screenshots') as $id => $picture) :?>
					<a class="screenshot" rel="lightbox[galery]" href="<?= $picture['image']?>" title="<?= __s('game','sc_show',$data['game']->getInfo('support'),$data['game']->getInfo('title'),$id) ?>">
						<img src="<?=$picture['thumb'][$data['size-screenshot']]?>" title="" />
					</a>
				<?php endforeach;?>
				<div class="clear"></div>
				</div>
			</div>
			<?php else:?>
				<div class="nogallery"><p><?= __('game','no_gallery')?></p></div>
			<?php endif;?>
			<?php if($roles['admin']):?>
			<div class="upload">
				<input type="hidden" name="entity" value="<?=$data['game']->getInfo('entityName')?>"/>
				<input type="hidden" name="gid" value="<?=$data['game']->getInfo('id')?>"/>
				<input name="txt_file" type="file" id="txt_file" size="50" value="file"/> <br/>
	  			<input type="submit" name="upload" value="Upload" accesskey="ENTER" tabindex="1" />
  			</div>
  			<?php endif;?>
		</div>
		<div class="clear"></div>
	</form>
</div>