<tr>
    <td class="text-right"> Chăm sóc lớp </td>
    <td>
        <select class="form-control selectpicker" name="filter_arr_number_care">
            <option value="">Chăm sóc lớp</option>
            <option value="0" <?php echo (isset($_GET['filter_arr_number_care']) && $_GET['filter_arr_number_care'] == '0') ? 'selected' : ''; ?>>Chưa chăm sóc</option>
            <option value="1" <?php echo (isset($_GET['filter_arr_number_care']) && $_GET['filter_arr_number_care'] == 1) ? 'selected' : ''; ?>>Chăm sóc lần 1</option>
            <option value="2" <?php echo (isset($_GET['filter_arr_number_care']) && $_GET['filter_arr_number_care'] == 2) ? 'selected' : ''; ?>>Chăm sóc lần 2</option>
            <option value="3" <?php echo (isset($_GET['filter_arr_number_care']) && $_GET['filter_arr_number_care'] == 3) ? 'selected' : ''; ?>>Chăm sóc lần 3</option>
        </select>
    </td>
</tr>