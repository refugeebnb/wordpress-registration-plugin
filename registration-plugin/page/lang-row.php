<tr data-context="<?= $slug?>">
	<td><?= $lang['name']?></td>
	<td>
		<?= $this->icon('pen',false, "Edit",[
			'class'=>'icon-lg edit-lang','data-context' => $slug
		]);?>
		<?= $this->icon('circle-cross',false, "Delete",[
			'class'=>'icon-lg delete-lang','data-context' => $slug
		]);?>
		<?= $this->icon('speech-bubble',false, "Translate",[
			'class'=>'icon-lg translate-lang','data-context' => $slug
		]);?>
	</td>
</tr>