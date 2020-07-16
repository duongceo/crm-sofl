

<tr>

	<td class="text-right">

		Chọn tài khoản

	</td>

	<td>

		<!--<select style="width: 100%;" class="form-control select_course" name="add_<?php //echo $key;?>" multiple="multiple"> -->

		<select style="width: 100%;" id="channel-val" class="form-control select_course" name="edit_<?php echo $key;?>" multiple="multiple">
			<?php foreach ($arr as $value) { ?>
				<option value="<?php echo $value['fb_id_account'] ?>" <?php if ($value['fb_id_account'] == $row['account_fb_id']) echo 'selected'?>> <?php echo $value['name'] ?></option>
			<?php } ?>
		</select>

	</td>

</tr>


<script>
	$(document).ready(function() {
		$('.select_course').select2({
			placeholder: 'Chọn tài khoản',
		});

	});
</script>

