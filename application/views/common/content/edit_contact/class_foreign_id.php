
<tr>
    <?php $class_foreign_id = explode(';', $rows['class_foreign_id']) ?>
    <td class="text-right"> Lớp khác </td>
    <td>
        <select class="form-control class_foreign_id" name="class_foreign_id[]" multiple>
            <?php foreach ($class_study as $key => $value) { ?>
                <option value="<?php echo $value['class_study_id']; ?>" <?php if (in_array($value['class_study_id'], $class_foreign_id)) echo "selected"; ?>>
                    <?php echo $value['class_study_id']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>

<script>
    $(document).ready(function() {
        $('.class_foreign_id').select2({
            width: '100%',
            placeholder: 'Lớp khác',
        });
    });
</script>
