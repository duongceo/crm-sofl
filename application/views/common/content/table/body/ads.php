<td class="text-center tbl_ads">
	<?php
	if (isset($value['ad_id']) && !empty($value['ad_id'])) {
		foreach ($ad as $key2 => $value2) {
			if ($value2['id'] == $value['ad_id']) { 
				echo $value2['name'];
				break;
			}
		}
	} else echo 'UNKNOWN';
	?>
</td>
