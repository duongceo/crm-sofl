<tr>
    <td class="text-right"> Trạng thái thanh toán </td>
    <td>
        <select class="form-control selectpicker" name="filter_paid_status">
            <option value="" <?php if (!isset($_GET['filter_paid_status']) || empty($_GET['filter_paid_status'])) { ?> selected="selected" <?php } ?>>
                Nothing selected
            </option>

            <option value="0" <?php if (isset($_GET['filter_paid_status']) && $_GET['filter_paid_status'] == '0') echo 'selected'; ?>> Chưa thanh toán
            </option>

            <option value="1" <?php if (isset($_GET['filter_paid_status']) && $_GET['filter_paid_status'] == 1) echo 'selected'; ?>> Đã thanh toán
            </option>
        </select>
    </td>
</tr>
