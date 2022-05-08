<tr>
    <td class="text-right"> Xuất file excel </td>
    <td>
        <select class="form-control selectpicker" name="filter_export_excel">
            <option value="" <?php if (!isset($_GET['filter_export_excel']) || empty($_GET['filter_export_excel'])) { ?> selected="selected" <?php } ?>>
                Nothing selected
            </option>

            <option value="1" <?php if (isset($_GET['filter_export_excel']) && $_GET['filter_export_excel'] == 1) echo 'selected'; ?>>
                Xuất file excel
            </option>
        </select>
    </td>
</tr>
