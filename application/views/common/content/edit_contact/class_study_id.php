
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<tr>
    <td class="text-right">  Mã lớp học </td>
    <td>
		<select class="form-control course_code_select" name="class_study_id">
			<option value=""> Chọn mã lớp học </option>
			<?php foreach ($class_study as $key => $value) { ?>
				<option value="<?php echo $value['class_study_id']; ?>" <?php if ($rows['class_study_id'] == $value['class_study_id']) echo "selected"; ?>>
					<?php echo $value['class_study_id']; ?>
				</option>
			<?php } ?>

		</select>

		<div class="input-group-btn">
			<a target="_blank" href="<?php echo base_url('staff_managers/class_study')?>" class="btn btn-success">Tạo mã lớp</a>
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
