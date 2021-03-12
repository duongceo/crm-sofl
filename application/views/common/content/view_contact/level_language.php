<tr>
	<td class="text-right"> Khóa học đăng ký</td>
	<td>
		<?php
			if (isset($rows['level_language_id'])) {
				foreach ($level_language as $key => $value) {
					if ($value['id'] == $rows['level_language_id']) {
						echo $value['name'];
						break;
					}
				}
			} else echo "UNKNOWN";
		?>
	</td>
</tr>
