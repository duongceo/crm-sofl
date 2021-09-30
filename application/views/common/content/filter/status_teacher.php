<?php if (isset($status_for_teacher)) { ?>
    <tr>
        <td class="text-right"> Đánh giá giáo viên </td>
        <td>
            <select class="form-control selectpicker" name="filter_status_teacher_id[]" multiple>
                <?php
                foreach ($status_for_teacher as $key => $value) {
                    ?>
                    <option value="<?php echo $value['id']; ?>"
                        <?php
                        if (isset($_GET['filter_status_teacher_id'])) {
                            foreach ($_GET['filter_status_teacher_id'] as $value2) {
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