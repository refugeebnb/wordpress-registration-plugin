<div id="crud-area">
	<h2><span class="icon-flag"></span> Languages</h2>
	<div class="container-fluid">
		<form method='post' class="sz-slim-form" id="app-language-crud">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Language (in English)</label>
						<input class="form-control" name="<?= RefugeeBnb::NAME?>[Lang][name]" placeholder="E.g. Korean, Japanese, Bahasa, etc."/>
						<div class="hint"></div>
					</div>
					<div class="form-group">
						<label>Display Language (in Native Language)</label>
						<input class="form-control" name="<?= RefugeeBnb::NAME?>[Lang][display]" placeholder="E.g. 한국어, 日本語, Bahasa, etc."/>
						<div class="hint"></div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>IP Look Table</label>
						<div class="table-responsive table-slim">
						<table class="table" id="lookup-table">
							<thead>
								<tr><th>Start of IP Range</th><th>End of IP Range</th></tr>
							</thead>
							<tbody>
								<?php for($x=0;$x<1;$x++): ?>
								<tr>
									<td><input class="form-control" name="<?= RefugeeBnb::NAME?>[Lang][start][]" placeholder="E.g. 1.1.0.0"/></td>
									<td><input class="form-control" name="<?= RefugeeBnb::NAME?>[Lang][end][]" placeholder="E.g. 1.1.255.255"/></td>
								</tr>
								<?php endfor;?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2" class="text-center">
										<input class="form-control" name="<?= RefugeeBnb::NAME?>[Lang][lookup]" type="hidden"/>
										<div class="hint"></div>
										<a class="btn btn-success btn-sm" id="add-lookup-row"><?= RefugeeBnb::icon("plus")?> Add Lookup Row</a>
									</td>
								</tr>
							</tfoot>
						</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<button class="btn btn-primary" type="submit" id="submit-language"><?= RefugeeBnb::icon("paperplane")?> Add/Update Language</button>
					<button class="btn btn-danger clear-lang-form" type="button"><?= RefugeeBnb::icon("close")?> Clear Form</button>
				</div>
			</div>
		</form>
		
		<div class="panel panel-default" id="app-language-table">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead><tr><th>Language</th><th>Actions</th></tr></thead>
					<tbody><?php foreach((array)$options['Langs'] as $slug=>$lang) include"lang-row.php"; ?></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php include_once "page-translate.php";?>
<script>var <?= RefugeeBnb::NAME?> = <?= json_encode($options['Langs'])?>;</script>