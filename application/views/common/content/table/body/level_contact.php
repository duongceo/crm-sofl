<td class="text-center tbl_level_contact">
	<?php if (isset($value['level_contact_id']) && $value['level_contact_id'] != '0') {
		echo $value['level_contact_id'];
	} else {
		echo 'Contact chưa được chăm sóc!';
	}
	?>
</td>
