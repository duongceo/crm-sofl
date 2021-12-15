<td class="text-center">
	<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['time_id']) && !empty($row['time_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['time_id']) {
				echo $value2['times'];
				break;
			}
		}
	} else echo 'Chưa có xếp ngày lớp này';
	?>
</td>
