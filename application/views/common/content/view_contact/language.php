<tr>
	<td class="text-right">Ngoại ngữ</td>
	<td>
		<?php
			if (isset($rows['language_id'])) {
				foreach ($language_study as $key => $value) {
					if ($value['id'] == $rows['language_id']) {
						echo $value['name'];
						break;
					}
				}
			} else echo "UNKNOWN";
		?>
	</td>
</tr>
