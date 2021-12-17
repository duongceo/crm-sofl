<tr>
    <td class="text-right"> Phiếu khảo sát </td>
    <td>
        <select class="form-control selectpicker" name="filter_arr_survey">
            <option value="">Phiếu khảo sát</option>
            <option value="0" <?php echo (isset($_GET['filter_arr_survey']) && $_GET['filter_arr_survey'] == '0') ? 'selected' : ''; ?>>Chưa gửi</option>
            <option value="1" <?php echo (isset($_GET['filter_arr_survey']) && $_GET['filter_arr_survey'] == 1) ? 'selected' : ''; ?>>Đã gửi</option>
        </select>
    </td>
</tr>