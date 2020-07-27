<td class="text-center tbl_source">
	<?php
	foreach ($sources as $key2 => $value2) {
		if ($value2['id'] == $value['source_id']) {
			echo $value2['name'];
			break;
		}
	}
	?>
</td>
