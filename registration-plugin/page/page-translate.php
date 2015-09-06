<div id="translation-area">
	<h2><span class="icon-speech-bubble"></span> Translating <span class="lang-name">#Lang</span></h2>
	<div class="container-fluid">
		<form method='post' class="sz-slim-form" id="app-language-translate">
			<div class="table-responsive">
				<table class="table table-striped table-slim">
					<thead><tr><th>Source</th><th>Translated Text</th></tr></thead>
					<tbody>
					<?php foreach($this->translationFragments as $id=>$fragment):?>
						<tr>
							<td width="50%"><?= $fragment;?></td>
							<td width="50%"><input type='text' class='form-control' name="<?= RefugeeBnb::NAME?>[Lang][Translation][fragment][]"/></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
				<div class="form-group">
					<input type="hidden" name="<?= RefugeeBnb::NAME?>[Lang][Translation][slug]" value="" id="translation-lang"/>
					<div class="hint"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<button class="btn btn-primary" type="submit" id="submit-language"><?= RefugeeBnb::icon("paperplane")?> Add/Update <span class="lang-name">#Lang</span> Translation</button>
					<button class="btn btn-danger clear-translation" type="button"><?= RefugeeBnb::icon("close")?> Cancel Translation</button>
				</div>
			</div>
		</form>
	</div>
</div>