
<td class="text-center tbl_level_language">
	<?php
	if (isset($value['level_language_id']) && !empty($value['level_language_id'])) {
		foreach ($level_language as $key2 => $value2) {
			if ($value2['id'] == $value['level_language_id']) {
				echo $value2['name'];
				break;
			}
		}
	} else echo 'Chưa có';
	?>
</td>
