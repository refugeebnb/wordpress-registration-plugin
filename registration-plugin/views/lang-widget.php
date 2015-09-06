<div class="btn-group" id="top-selector">
	<button type="button" class="btn btn-app dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		English <span class="caret"></span>
	</button>
	<ul class="dropdown-menu dropdown-menu-right">
		<li><a data-target="english">English</a></li>
		<?php foreach($langs as $slug => $lang):?>
		<li><a data-target="<?= $slug?>"><?= $lang['display']?></a></li>
		<?php endforeach;?>
	</ul>
</div>
<script>var LangOptions = <?= json_encode($langs);?></script>
<script>var LangDefaults = <?= json_encode($langDefaults);?></script>