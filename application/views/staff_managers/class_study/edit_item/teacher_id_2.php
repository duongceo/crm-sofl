<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>-->

<tr>

	<td class="text-right">Giảng viên 2</td>

	<td>

		<select class="form-control teacher_id_select" name="edit_teacher_id_2">
			<option value="0"> Chọn giảng viên</option>
			<?php foreach ($arr as $key => $value) { ?>
				<option value="<?php echo $value['id'] ?>"<?php echo ($row['teacher_id_2'] == $value['id'])?'selected':''?>> <?php echo $value['name'] ?></option>
			<?php } ?>
		</select>

	</td>

</tr>

<script>
	$(document).ready(function() {
		$('.teacher_id_select').select2({
			width: '100%',
		});
	});
</script>
