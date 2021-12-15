<tr>
    <td class="text-right"> Ngày học </td>
    <td>
        <select class="form-control item_id" name="filter_arr_multi_day_id[]" multiple>
            <?php foreach ($day as $key => $value) { ?>
                <option value="<?php echo $value['id']; ?>" <?php if (in_array($value['id'], $_GET['filter_arr_multi_day_id'])) echo 'selected'; ?>>
                    <?php echo $value['days']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>