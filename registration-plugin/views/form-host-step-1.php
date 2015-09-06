<h2 class="section-title text-center"  data-fragment="0">
	Sign Up to host a refugee for 1 year, start Jan 1, 2016.
</h2>
<form class="barren" id="shelter-providers-signup" method="post">
	<div class="console"></div>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label data-fragment="3">Email</label>
				<input class="form-control" name="<?= RefugeeBnb::NAME?>[Shelter][email]" data-fragment="3"/>
				<div class="hint"></div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label data-fragment="10">Password</label>
				<input type="password" class="form-control" name="<?= RefugeeBnb::NAME?>[Shelter][password]" data-fragment="10"/>
				<div class="hint"></div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<button type="submit" class="btn btn-app"><?= RefugeeBnb::icon("user");?> <span data-fragment="11">Express Interest</span></button>
			</div>
		</div>
	</div>
</form>