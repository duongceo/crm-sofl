<?php if (isset($customer_call_status)) { ?>
    <tr>
        <td class="text-right"> Trạng thái gọi cskh </td>
        <td>
            <select class="form-control selectpicker" name="filter_customer_care_call_id[]" multiple>
                <?php
                foreach ($customer_call_status as $key => $value) {
                    ?>
                    <option value="<?php echo $value['id']; ?>" 
                    <?php
                    if (isset($_GET['filter_customer_care_call_id'])) {
                        foreach ($_GET['filter_customer_care_call_id'] as $value2) {
                            if ($value2 == $value['id']) {
                                echo 'selected';
                                break;
                            }
                        }
                    }
                    ?>>
                    <?php echo $value['name']; ?>
                    </option>
        <?php
    }
    ?>
            </select>
        </td>
    </tr>
<?php } ?>
