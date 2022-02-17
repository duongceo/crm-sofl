<tr>
    <td class="text-right"> Nhân viên trực page </td>
    <td>
        <select class="form-control selectpicker" name="filter_care_page_staff_id[]" multiple>
            <?php foreach ($care_page_staff as $key => $value) { ?>
                <option value="<?php echo $value['id']; ?>"
                    <?php
                    if (isset($_GET['filter_care_page_staff_id'])) {
                        foreach ($_GET['filter_care_page_staff_id'] as $value2) {
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