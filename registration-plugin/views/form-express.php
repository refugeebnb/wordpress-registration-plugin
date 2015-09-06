<h2 class="section-title text-center" data-fragment="1">I have no spare beds but I would like to help in other ways.</h2>
<form class="barren" id="other-providers" method="post">
	<div class="console"></div>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label data-fragment="3">Email</label>
				<input class="form-control" name="<?= RefugeeBnb::NAME?>[Others][email]" data-fragment="3"/>
				<div class="hint"></div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label data-fragment="4">I can offer</label>
				<textarea class="form-control" name="<?= RefugeeBnb::NAME?>[Others][offer]" data-fragment="4"></textarea>
				<div class="hint"></div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<button type="submit" class="btn btn-app"><?= RefugeeBnb::icon("paperplane");?> <span data-fragment="5">Submit</span></button>
			</div>
		</div>
	</div>
</form>