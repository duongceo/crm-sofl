<tr class="filter_tv_dk">
    <td class="text-right"> Contact Tư vấn/Đăng ký </td>
    <td>
        <select class="form-control filter selectpicker" name="filter_tv_dk">
            <option value="" <?php if (!isset($_GET['filter_tv_dk'])) { ?> selected="selected" <?php } ?>>  
            </option>

            <option value="0" <?php if (isset($_GET['filter_tv_dk']) && $_GET['filter_tv_dk'] == 'no') echo 'selected'; ?>> Đăng ký 
            </option>

            <option value="1" <?php if (isset($_GET['filter_tv_dk']) && $_GET['filter_tv_dk'] == 'yes') echo 'selected'; ?>>  Tư vấn 
            </option>
        </select>
    </td>
</tr>