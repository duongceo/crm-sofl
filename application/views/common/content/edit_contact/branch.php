
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>-->

<tr>
	<td class="text-right"> Cơ sở </td>
	<td>
		<select class="form-control selectpicker" type="branch" name="branch_id">
			<option value="0">Chọn cơ sở</option>
			<?php foreach ($branch as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $rows['branch_id']) ? 'selected' : ''; ?>>
					<?php echo $value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>

<tr class="ajax_class_id">
	<td class="text-right"> Mã lớp học </td>
	<td>
		<div class="input-group">
			<select class="form-control course_code_select" name="class_study_id">
				<option value=""> Chọn mã lớp học </option>
				<?php foreach ($class_study as $key => $value) { ?>
					<option value="<?php echo $value['class_study_id']; ?>" <?php if ($rows['class_study_id'] == $value['class_study_id']) echo "selected"; ?>>
						<?php echo $value['class_study_id']; ?>
					</option>
				<?php } ?>
			</select>

			<div class="input-group-btn">
				<a style="margin: auto;" target="_blank" href="<?php echo base_url('staff_managers/class_study')?>" class="btn btn-success">Tạo mã lớp</a>
			</div>
		</div>
	</td>
</tr>

<script>
	$(document).ready(function() {
		$('.course_code_select').select2({
			width: '100%',
		});
	});
</script>
