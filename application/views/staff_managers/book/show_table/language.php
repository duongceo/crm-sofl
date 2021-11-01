<td class="text-center">
	<?php
	if (isset($row['language_id']) && !empty($row['language_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['language_id']) {
				echo $value2['name'];
				break;
			}
		}
	} else echo 'Chưa có ngôn ngữ của lớp này';
	?>
</td>
