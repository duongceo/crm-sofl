<td class="text-center tbl_sale">
	<?php
	foreach ($presence as $key2 => $value2) {
		if ($value2['id'] == $value['presence_id']) {
			echo $value2['name'];
		}
	}
	?>
</td>
