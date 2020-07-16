<tr id="warehouse-row">

    <td class="text-right">

        Chọn kho email

    </td>
    
    <td>

        <select class="form-control selectpicker" name="add_<?php echo $key;?>[]" multiple>

            <option value="0"> Chọn kho email </option>

            <?php foreach ($arr as $key => $value) {

                ?>

                <option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>

                <?php

            }

            ?>

        </select>

    </td>

</tr>

