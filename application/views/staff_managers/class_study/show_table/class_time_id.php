<td class="text-center">
	<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['class_time_id']) && !empty($row['class_time_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['class_time_id']) {
				echo $value2['classroom_id'] . ' : ' .$value2['time'] . '<br>';
				echo 'Thứ : ' . $value2['days'];
				break;
			}
		}
	} else echo 'Chưa có thời gian học của lớp này';
	?>
</td>
