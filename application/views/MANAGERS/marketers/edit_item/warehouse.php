<tr id="warehouse-row">
    <td class="text-right">
        Chọn kho email
    </td>
    <td>
        <select class="form-control selectpicker" name="edit_<?php echo $key;?>[]" multiple>
            <option value="0"> Chọn kho email </option>
            <?php
            $warehouses = explode(',', $row['warehouse']);
            foreach ($arr as $key => $value) {
                ?>
                <option value="<?php echo $value['id'] ?>" <?php foreach($warehouses as $w_value){if($w_value == $value['id']){ echo 'selected';}} ?>> <?php echo $value['name'] ?></option>
                <?php
            }
            ?>
        </select>
    </td>
</tr>

