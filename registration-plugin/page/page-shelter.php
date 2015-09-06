<h2><span class="icon-food"></span> Shelter Providers</h2>
<div class="container-fluid">
	<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>User</th>
					<th>Shelter Details</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($users as $user):
				$meta = json_decode(get_user_meta($user->ID,'shelter',true),true);	
			?>
			<tr>
				<td>
					<strong><?= $meta['name']?></strong> (<?= $user->user_email?>)<br />
					<strong>Address: </strong><?= $meta['address']?><br />
					<strong>Household Languages: </strong><?= $meta['langs']?><br />
					<strong>About Household: </strong><?= $meta['house']?><br />
					<strong>Residents in 2016: </strong><?= $meta['adults']?> Adults/<?= $meta['children']?> Children
				</td>
				<td>
					<?= "<strong>Rooms</strong>: ".$meta['rooms'];?><br />
					<?php for($x=1;$x<=$meta['rooms'];$x++):?>
					<h4>Room <?=$x;?></h4>
					<strong>Single Bed</strong>: <?= $meta['single'][$x-1]." (".ucfirst($meta['single-type'][$x-1]).")";?><br />
					<strong>Double Bed</strong>: <?= $meta['double'][$x-1]." (".ucfirst($meta['double-type'][$x-1]).")";?><br />
					<?php endfor;?>
				</td>
			</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	</div>
</div>
