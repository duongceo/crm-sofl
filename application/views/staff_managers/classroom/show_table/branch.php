<td class="text-center">
	<!--	--><?php //echo '<pre>';print_r($value[0]);die();?>
	<?php
	if (isset($row['branch_id']) && !empty($row['branch_id'])) {
		foreach ($value as $key2 => $value2) {
			if ($value2['id'] == $row['branch_id']) {
				echo $value2['name'];
				break;
			}
		}
	} else echo 'Ko có cơ sở';
	?>
</td>
