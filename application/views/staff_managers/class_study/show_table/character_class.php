<td class="text-center">
	<?php
	if (isset($row['character_class_id']) && !empty($row['character_class_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['character_class_id']) {
				echo $value2['name'];
				break;
			}
		}
	} else echo 'UNKNOW';
	?>
</td>
