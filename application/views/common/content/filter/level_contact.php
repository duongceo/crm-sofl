<?php if (isset($level_contact)) { ?>
    <tr>
        <td class="text-right"> Trạng thái contact </td>
        <td>
            <select class="form-control level_contact_id selectpicker" name="filter_level_contact_id[]" multiple>
                <?php
                foreach ($level_contact as $key => $value) {
                    ?>
                    <option value="<?php echo $value['level_id']; ?>"
                    <?php
                    if (isset($_GET['filter_level_contact_id'])) {
                        foreach ($_GET['filter_level_contact_id'] as $value2) {
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