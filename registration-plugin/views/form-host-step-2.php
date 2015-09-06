<form class="borren sz-slim-form" id="shelter-providers-details" method="post">
	<div class="console"></div>
	<div class="row">
		<div class="col-sm-6">
			<h2 class="section-title text-center"  data-fragment="4">I can offer</h2>
			<div class="form-group">
				<label data-fragment="13">How many rooms do you have?</label>
				<input type="number" min="1" max="5" step="1" name="<?= RefugeeBnb::NAME?>[Shelter][rooms]"/>
				<div class="hint"></div>
			</div>
			<div id="room-details"></div>
			<div class="form-group template" id="room-template">
				<h3 class="text-center section-subtitle">Room <span class='num'>#num</span></h3>
				<table class="table-responsive">
					<table class="table barren-table">
						<thead>
							<tr>
								<th data-fragment="14">Bed Type</th>
								<th data-fragment="15">How Many beds</th>
								<th data-fragment="16">Suited for</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Single</td>
								<td><input type="number" class='form-control' min="1" max="5" step="1" 
									name="<?= RefugeeBnb::NAME?>[Shelter][single][:x]"/>
								</td>
								<td>
									<input type="radio" value="child" name="<?= RefugeeBnb::NAME?>[Shelter][single-type][:x]"/> <span data-fragment="21">Child</span><br />
									<input type="radio" value="adult" name="<?= RefugeeBnb::NAME?>[Shelter][single-type][:x]"/> <span data-fragment="22">Adult</span><br />
									<input type="radio" value="both" name="<?= RefugeeBnb::NAME?>[Shelter][single-type][:x]" checked/> <span data-fragment="29">Both</span>
								</td>
							</tr>
							<tr>
								<td>Double</td>
								<td><input type="number" class='form-control' min="1" max="5" step="1" 
									name="<?= RefugeeBnb::NAME?>[Shelter][double][:x]"/>
								</td>
								<td>
									<input type="radio" value="child" name="<?= RefugeeBnb::NAME?>[Shelter][double-type][:x]"/> <span data-fragment="21">Child</span><br />
									<input type="radio" value="adult" name="<?= RefugeeBnb::NAME?>[Shelter][double-type][:x]"/> <span data-fragment="22">Adult</span><br />
									<input type="radio" value="both" name="<?= RefugeeBnb::NAME?>[Shelter][double-type][:x]" checked/> <span data-fragment="29">Both</span>
								</td>
							</tr>
						</tbody>
					</table>
				</table>
				<div class="hint"></div>
			</div>
		</div>
		<div class="col-sm-6">
			<h2 class="section-title text-center"  data-fragment="17">About you</h2>
			<div class="form-group">
				<input type="text" class='form-control' name="<?= RefugeeBnb::NAME?>[Shelter][name]"
					placeholder="Name" data-fragment="18"
				/>
				<div class="hint"></div>
			</div>
			<div class="form-group">
				<textarea type="text" class='form-control' name="<?= RefugeeBnb::NAME?>[Shelter][address]"
					placeholder="Address" data-fragment="19"
				></textarea>
				<div class="hint"></div>
			</div>
			<div class="form-group">
				<textarea type="text" class='form-control' name="<?= RefugeeBnb::NAME?>[Shelter][langs]"
					placeholder="Languages in Household" data-fragment="23"
				></textarea>
				<div class="hint"></div>
			</div>
			<div class="form-group">
				<textarea type="text" class='form-control' name="<?= RefugeeBnb::NAME?>[Shelter][house]"
					placeholder="Tell us about your household" data-fragment="24"
				></textarea>
				<div class="hint"></div>
			</div>
			
			
			<div>
				<label data-fragment="20">2016 Residents</label>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<input type="number" class='form-control' name="<?= RefugeeBnb::NAME?>[Shelter][adults]"
							placeholder="Adults" data-fragment="21"/>
						<div class="hint"></div>
					</div>
				</div>
				<div class="col-xs-6">
					<input type="number" class='form-control' name="<?= RefugeeBnb::NAME?>[Shelter][children]"
							placeholder="Children" data-fragment="22"/>
						<div class="hint"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group text-center">
				<button type="submit" class="btn btn-lg btn-app"> <span data-fragment="5">Submit</span></button>
			</div>
		</div>
	</div>
</form>