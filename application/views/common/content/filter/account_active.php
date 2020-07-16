<tr class="filter_account_active">
    <td class="text-right"> Contact kích hoạt khóa học ? </td>
    <td>
        <select class="form-control filter selectpicker" name="filter_account_active">
            <option value="" <?php if (!isset($_GET['filter_account_active'])) { ?> selected="selected" <?php } ?>>  </option>
            <option value="1" <?php if (isset($_GET['filter_account_active']) && $_GET['filter_account_active'] == 'yes') echo 'selected'; ?>> Đã kích hoạt </option>
            <option value="0" <?php if (isset($_GET['filter_account_active']) && $_GET['filter_account_active'] == 'no') echo 'selected'; ?>>  Chưa kích hoạt </option>
        </select>
    </td>
</tr>