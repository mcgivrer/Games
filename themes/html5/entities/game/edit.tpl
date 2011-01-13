			<?php if($roles['admin']):?>
			<div class="upload">
				<input type="hidden" name="entity" value="<?=$data['game']->entityName?>"/>
				<input type="hidden" name="gid" value="<?=$data['game']->id?>"/>
				<input name="txt_file" type="file" id="txt_file" size="50" value="file"/> <br/>
	  			<input type="submit" name="upload" value="Upload" accesskey="ENTER" tabindex="1" />
  			</div>
  			<?php endif;?>