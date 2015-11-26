
<!-- ADMIN/INDEX TEMPLATE -->

<!--
<pre><?php echo "templates/admin/data/index.tpl.php <br>"; print_r($values); ?></pre>
-->

<table class="table table-striped">
	<thead>
		<tr>
			<th>Stamp</th>
			<th>Sensor</th>
			<th>Temperature</th>
			<th>Humidity</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $values as $value ): ?>
			<tr>
				<td><?= $value['stamp'] ?></td>
				<td><?= $value['sensor'] ?></td>
				<td><?= $value['temperature'] ?></td>
				<td><?= $value['humidity'] ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>