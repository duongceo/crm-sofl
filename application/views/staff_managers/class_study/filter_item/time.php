<tr>
    <td class="text-right"> Khung giờ </td>
    <td>
        <select class="form-control item_id" name="filter_arr_multi_time_id[]" multiple>
            <?php foreach ($time as $key => $value) { ?>
                <option value="<?php echo $value['id']; ?>" <?php if (in_array($value['id'], $_GET['filter_arr_multi_time_id'])) echo 'selected'; ?>>
                    <?php echo $value['times']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>