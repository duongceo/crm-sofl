
<td class="text-center tbl_language">
	<?php
	if (isset($value['language_id']) && !empty($value['language_id'])) {
		foreach ($language_study as $key2 => $value2) {
			if ($value2['id'] == $value['language_id']) {
				echo $value2['name'];
				break;
			}
		}
	} else echo 'Chưa có';
	?>
</td>
