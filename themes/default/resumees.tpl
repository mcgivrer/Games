<div class="section" id="resumees">
<? foreach($data['resumees'] as $id=>$resume):?>
	<? __renderEntity('game','resumee',$resume)?>
<? endforeach;?>
</div>