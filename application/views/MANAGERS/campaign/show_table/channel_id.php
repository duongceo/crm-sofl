<td class="text-center">
	<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['channel_id']) && !empty($row['id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['channel_id']) {
				echo $value2['name'];
				break;
			}
		}
	} else echo 'Chưa có';
	?>
</td>
