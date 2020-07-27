<td class="text-center tbl_branch">
	<?php
		if (isset($value['branch_id']) && !empty($value['branch_id']))
			foreach ($branch as $key2 => $value2) {
			if ($value2['id'] == $value['branch_id']) {
				echo $value2['name'];
				break;
			}
		} else echo 'UNKNOWN';
	?>
</td>
