<td class="text-center">
	<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['day_id']) && !empty($row['day_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['day_id']) {
				echo $value2['days'];
				break;
			}
		}
	} else echo 'Chưa xếp ngày học của lớp này';
	?>
</td>
