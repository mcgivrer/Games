<article class="game">
	<form id="upload" method="POST" enctype="multipart/form-data" action="index.php&no-cache" >
		<h2><?= __s('game','master_title',$data['game']->getInfo('support'), $data['game']->getInfo('title') )?></h2>
		<div class="file">
			<a href="<?= $data['game']->getPicture('cover',1,"","#")?>" rel="lightbox" title="<?= __s('game','cover_show',$data['game']->getInfo('support'),$data['game']->getInfo('title')) ?>">
			    <span class="cover"><img src="<?= $data['game']->getPictureThumb('cover',1,__('game','default_image_cover'))?>" title="cover for <?= $data['game']->getInfo('title') ?>" alt="box cover of game '<?=$data['game']->getInfo('title') ?>'"></span>
			</a>
			<div id="game-infos" class="block">
				<h3><?= __('game','info_title')?></h3>
				<div class="block-content">		
				<div class="note"><span class="legend"><?= __('list','note')?></span><span><?=$data['game']->getInfo('note') ?></span></div>
				<ul class="infos">
					<li><div class="label"><?= __('list','author')?></div><?= $data['game']->getInfo('author') ?></li>
					<li>
						<div class="label"><?= __('list','comment')?></div>
						<div class="comment">
				    	<?= $data['game']->getInfo('comment') ?>
						</div>
					</li>
					<li><div class="label"><?= __('game','tags_label')?></div><?=$data['game']->getInfo('tags')?></li>
				</ul>
				</div>
			</div>
			<?php if(count($data['game']->getPictures('screenshots'))>0):?>
			<div class="clear"></div>
			<div class="block gallery">
				<h3><?= __('game','gallery_title')?></h3>
				<div class=" block-content gallery-content">
				<?php foreach($data['game']->getPictures('screenshots') as $id => $picture) :?>
					<a class="screenshot" rel="lightbox[galery]" href="<?= $picture['image']?>" title="<?= __s('game','sc_show',$data['game']->getInfo('support'),$data['game']->getInfo('title'),$id) ?>">
						<div><img src="<?=$picture['thumb'][$data['size-screenshot']]?>" title="" /></div>
					</a>
				<?php endforeach;?>
				<div class="clear"></div>
				</div>
			</div>
			<?php else:?>
				<div class="clear"></div>
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
	</form>
	<div class="clear"></div>
</article>