<h2><span class="icon-truck"></span> Other Providers</h2>
<div class="container-fluid">
	<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>User</th>
					<th>Services</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($users as $user):?>
			<tr>
				<td>
					<?= $user->user_email?>
				</td>
				<td>
					<?= get_user_meta($user->ID,'service',true); ?>
				</td>
			</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	</div>
</div>
