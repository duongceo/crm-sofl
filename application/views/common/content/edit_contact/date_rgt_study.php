  <tr>
	<td class="text-right"> Ngày đăng ký học </td>
	<td>
		<input type="text" class="form-control"
		<?php if ($rows['date_rgt_study'] > 0) { ?>
		   placeholder="<?php echo date(_DATE_FORMAT_, $rows['date_rgt_study']); ?>"
		   <?php } ?>
		   disabled />
	</td>
</tr>
