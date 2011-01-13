<article id="ra<?=$data['game']->getInfo('id') ?>">
	<a class="cover" href="<?= $data['game']->getPicture('cover',1,"","#")?>" rel="lightbox" title="<?= __s('game','cover_show',$data['game']->getInfo('support'),$data['game']->getInfo('title')) ?>">
	<span><img src="<?= $data['game']->getPictureThumb('cover',1,__('game','default_image_cover'),"80x60")?>" title="cover for <?= $data['game']->getInfo('title') ?>" alt="box cover of game '<?=$data['game']->getInfo('title') ?>'"></span>
	</a><h1><?= $data['game']->getInfo('title')?></h1>
	<p><?=$data['game']->getInfo('comment')?><? __link('game/view',__('resume','readmore'),__('resume','readmore_title'),array('class'=>"readmore"))?></p>
</article>