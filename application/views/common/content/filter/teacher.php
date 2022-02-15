
<tr>
    <td class="text-right"> Giáo viên </td>
    <td>
        <select class="form-control teacher_select2" name="filter_teacher_id[]" multiple>
            <?php foreach ($teacher as $key => $value) { ?>
                <option value="<?php echo $value['id']; ?>"
                <?php
                if (isset($_GET['filter_teacher_id']) && !empty($_GET['filter_teacher_id'])) {
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
            placeholder: 'Giáo viên',
            width: '100%'
        });
    });
</script>