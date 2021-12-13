<tr class="ajax_level_language">
    <td class="text-right">Trình độ</td>
    <td>
        <select class="form-control item_id" name="filter_arr_multi_level_language_id" multiple>
            <option value="">Chọn trình độ</option>
            <?php foreach ($level_language as $key => $value) { ?>
                <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $_GET['filter_arr_multi_level_language_id']) echo 'selected'; ?>>
                    <?php echo $value['name']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>