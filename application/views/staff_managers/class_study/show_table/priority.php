
<?php
	if ($row['priority_id'] == 1) {
		$color = '#2aa022';
	} else if ($row['priority_id'] == 2) {
		$color = '#d9d433';
	} else if ($row['priority_id'] == 3) {
		$color = '#cd4f4f';
	} else {
		$color = 'none';
	}
?>
<td class="text-center" style="background: <?php echo $color ?>"></td>
