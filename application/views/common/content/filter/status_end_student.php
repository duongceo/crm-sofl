<?php if (isset($status_end_student)) { ?>
    <tr>
        <td class="text-right"> Trạng thái HV cuối khóa </td>
        <td>
            <select class="form-control selectpicker" name="filter_status_end_student_id[]" multiple>
                <?php
                foreach ($status_end_student as $key => $value) {
                    ?>
                    <option value="<?php echo $value['id']; ?>"
                        <?php
                        if (isset($_GET['filter_status_end_student_id'])) {
                            foreach ($_GET['filter_status_end_student_id'] as $value2) {
                                if ($value2 == $value['id']) {
                                    echo 'selected';
                                    break;
                                }
                            }
                        }
                        ?>>
                        <?php echo $value['status']; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </td>
    </tr>
<?php } ?>