<tr class="filter_sale_id">
    <td class="text-right"> Tư vấn tuyển sinh </td>
    <td>
        <select class="form-control selectpicker" name="filter_sale_study_abroad">
            <option value="">Người nhập</option>
            <?php foreach ($sale_study_abroad as $key => $value) { ?>
                <option value="<?php echo $value['id']; ?>" <?php echo (isset($_GET['filter_sale_study_abroad']) && $_GET['filter_sale_study_abroad'] == $value['id']) ? 'selected' : '' ?>>
                    <?php echo $value['name']; ?>
                </option>
            <?php } ?>
        </select>
    </td>
</tr>