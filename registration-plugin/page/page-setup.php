<h2><span class="icon-params"></span> Setup</h2>
<div class="cotnainer-fluid">
	<form method='post' class="sz-slim-form" id="app-setup-crud">
		<?php foreach($this->setupFields as $slug=>$params):?>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label><?= $params[0];?></label>
					<?php if(!isset($params[1]) || $params[1] == 'text'):?>
					<input type="text" class="form-control" name="<?= RefugeeBnb::NAME."[" . $slug . "]"?>"
						placeholder="<?= isset($params[2])?$params[2]:$params[0]?>"
						value="<?= isset($options[$slug])?$options[$slug]:""?>"
						/>
					<?php elseif($params[1]=='textarea'):?>
					<textarea class="form-control" name="<?= RefugeeBnb::NAME."[" . $slug . "]"?>"
						placeholder="<?= isset($params[2])?$params[2]:$parms[0]?>"><?= isset($options[$slug])?$options[$slug]:""?></textarea>
					<?php endif;?>
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<div class="row">
			<div class="col-sm-12">
				<button class="btn btn-danger">
					<?= RefugeeBnb::icon("paperplane");?> Submit
				</button>
			</div>
		</div>
	</form>
</div>