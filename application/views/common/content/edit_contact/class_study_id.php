<!--<tr>
    <td class="text-right">  Mã khóa học </td>
    <td>  
        <select class="form-control select_course_code selectpicker" name="course_code">
            <option value="0"> Chọn mã khóa học </option>
            <?php foreach ($courses as $key => $value) { ?>
                <option value="<?php echo $value['course_code']; ?>"
                        <?php if ($rows['course_code'] == $value['course_code']) echo "selected"; ?>>
                            <?php echo $value['course_code']; ?> 
                </option>
            <?php } ?>
        </select>
    </td>
</tr>-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<tr>
    <td class="text-right">  Mã lớp học </td>
    <td>  
        <select class="form-control course_code_select" name="class_study_id">
            <option value="0"> Chọn mã lớp học </option>
            <?php foreach ($class_study as $key => $value) { ?>
                <option value="<?php echo $value['class_study_id']; ?>" <?php if ($rows['class_study_id'] == $value['class_study_id']) echo "selected"; ?>>
					<?php echo $value['class_study_id']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>
<script> 
$(document).ready(function() {
    $('.course_code_select').select2({
        width: '100%',
    });
});
</script>
