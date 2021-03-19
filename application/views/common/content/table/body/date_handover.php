<td class="text-center tbl_date_handover">
	<?php 
		if (isset($value['date_handover']) && !empty($value['date_handover'])) {
			echo date('d/m/Y H:i', $value['date_handover']);
		} else {
			echo "";
		}
	?>
</td>