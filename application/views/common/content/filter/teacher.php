<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<tr class="filter_sale_id">
    <td class="text-right"> Giảng viên </td>
    <td>
        <select class="form-control teacher_select2" name="filter_teacher_id[]" multiple>
            <?php foreach ($staffs as $key => $value) {
                ?>
                <option value="<?php echo $value['id']; ?>"
                <?php
                if (isset($_GET['filter_teacher_id'])) {
                    foreach ($_GET['filter_teacher_id'] as $value2) {
                        if ($value2 == $value['id']) {
                            echo 'selected';
                        }
                    }
                }
                ?>>
                            <?php echo $value['name']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>
<script> 
$(document).ready(function() {
    $('.teacher_select2').select2({
        width: '100%'
    });
});
</script>