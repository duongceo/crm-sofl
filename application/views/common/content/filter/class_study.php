
<tr class="filter_class_study_id">
    <td class="text-right"> Mã lớp học </td>
    <td>
        <select class="form-control class_study_id" name="filter_class_study_id[]" multiple>
            <?php foreach ($class_study as $key => $value) { ?>
                <option value="<?php echo $value['class_study_id']; ?>"
                <?php
                if (isset($_GET['filter_class_study_id'])) {
                    foreach ($_GET['filter_class_study_id'] as $value2) {
                        if ($value2 == $value['class_study_id']) {
                            echo 'selected';
                            break;
                        }
                    }
                }
                ?>>
                <?php echo $value['class_study_id']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>
<script> 
$(document).ready(function() {
    $('.class_study_id').select2({
        width: '100%'
    });
});
</script>
