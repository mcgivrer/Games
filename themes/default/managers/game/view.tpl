<section id="content">
<?= __renderEntity('game','view',$data); ?>
<?= __renderPartial('index','randomgames',$data); ?>
</section>
<aside id="sidebar">
<?= __renderEntity('game','resume',$data); ?>
</aside>