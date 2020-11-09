<?php if($row['date_last_update'] > 0) { ?>
	<tr>
		<td class="text-right"> Ngày sửa gần nhất </td>
		<td>  <?php
			if ($row['date_last_update'] > 0)
				echo date(_DATE_FORMAT_, $row['date_last_update']);
			?>
		</td>
	</tr>
<?php } ?>
