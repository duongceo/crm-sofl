<td class="text-center">
<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['teacher_id']) && !empty($row['teacher_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['teacher_id']) {
				echo $value2['name'] . ' - ' . $value2['phone'];
				break;
			}
		}
	} else echo 'UNKNOWN';
	?>
</td>
