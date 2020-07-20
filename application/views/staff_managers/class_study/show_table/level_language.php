<td class="text-center">
	<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['level_language_id']) && !empty($row['level_language_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['level_language_id']) {
				echo $value2['name'];
				break;
			}
		}
	} else echo 'Chưa có trình độ của lớp này';
	?>
</td>
