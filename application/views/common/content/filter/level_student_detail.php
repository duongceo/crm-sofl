<?php if (isset($level_student_detail)) { ?>
    <tr>
        <td class="text-right"> Trạng thái chi tiết học viên </td>
        <td>
            <select class="form-control selectpicker" name="filter_level_student_detail[]" multiple>
                <?php
                foreach ($level_student_detail as $key => $value) {
                    ?>
                    <option value="<?php echo $value['level_id']; ?>"
                    <?php
                    if (isset($_GET['filter_level_student_detail'])) {
                        foreach ($_GET['filter_level_student_detail'] as $value2) {
                            if ($value2 == $value['level_id']) {
                                echo 'selected';
                                break;
                            }
                        }
                    }
                    ?>>
                        <?php echo $value['level_id'] .' - '.$value['name']; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </td>
    </tr>
<?php } ?>