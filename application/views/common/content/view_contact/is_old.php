<tr>
	<td class="text-right">Là học viên cũ ko</td>
	<td>  <?php
		if ($rows['is_old'] == 1) {
			echo 'Học viên cũ';
		} else echo "Học viên mới";

		?>
	</td>
</tr>
