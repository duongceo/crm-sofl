<tr>
	<td class="text-right">  Trạng thái học viên </td>
	<td>  <?php
		foreach ($level_student as $key => $value) {
			if ($value['level_id'] == $rows['level_student_id']) {
				echo $value['name'];
				break;
			}
		}
		?>
	</td>
</tr>
