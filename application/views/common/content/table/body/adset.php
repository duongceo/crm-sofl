<td class="center tbl_adset">
	<?php
	if (isset($value['adset_id']) && !empty($value['adset_id'])) {
		foreach ($adset as $key2 => $value2) {
			if ($value2['id'] == $value['adset_id']) { 
				echo $value2['name'];
				break;
			}
		}
	} else echo 'UNKNOWN';
	?>
</td>