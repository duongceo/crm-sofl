<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<tr>

	<td class="text-right">

		<?php echo h_find_name_display($key, $this->list_view); ?>

	</td>

	<td>

<!--		<select class="form-control select_course_code selectpicker" name="add_--><?php //echo $key;?><!--">-->
<!---->
<!--			<option value="0"> Chọn --><?php //echo h_find_name_display($key, $this->list_view); ?><!-- </option>-->
<!---->
<!--			--><?php //foreach ($arr as $key => $value) { ?>
<!---->
<!--				<option value="--><?php //echo $value['course_code'] ?><!--"> --><?php //echo $value['course_code'] ?><!--</option>-->
<!---->
<!--			--><?php //} ?>
<!---->
<!--		</select>-->

		<select style="width: 100%;" class="form-control select_course" name="filter_course_code" multiple="multiple">
			<?php foreach ($course_code as $value) { ?>
				<option value="<?php echo $value['course_code'] ?>" > <?php echo $value['course_code'] ?></option>
			<?php } ?>
		</select>

	</td>

</tr>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script>
	$(document).ready(function() {
		$('.select_course').select2({
			placeholder: 'Tìm khóa học',
		});
	});
</script>
