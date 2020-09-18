<?php if (isset($level_contact_detail)) { ?>
    <tr>
        <td class="text-right"> Trạng thái chi tiết contact </td>
        <td>
            <select class="form-control selectpicker" name="filter_level_contact_detail[]" multiple>
                <?php
                foreach ($level_contact_detail as $key => $value) {
                    ?>
                    <option value="<?php echo $value['level_id']; ?>"
                    <?php
                    if (isset($_GET['filter_level_contact_detail'])) {
                        foreach ($_GET['filter_level_contact_detail'] as $value2) {
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