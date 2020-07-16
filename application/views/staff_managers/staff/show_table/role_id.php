<td class="text-center">
	<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['role_id']) && !empty($row['role_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['role_id']) {
				echo $value2['position'];
				break;
			}
		}
	} else echo 'Ko có';
	?>
</td>
