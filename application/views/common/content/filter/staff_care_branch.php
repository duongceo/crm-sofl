<tr>
    <td class="text-right"> Chăm sóc viên cơ sở </td>
    <td>
        <select class="form-control selectpicker" name="filter_staff_care_branch_id[]" multiple>
            <?php foreach ($staff_care_branch as $key => $value) {
                ?>
                <option value="<?php echo $value['id']; ?>"
                    <?php
                    if (isset($_GET['filter_staff_care_branch_id'])) {
                        foreach ($_GET['filter_staff_care_branch_id'] as $value2) {
                            if ($value2 == $value['id']) {
                                echo 'selected';
                                break;
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