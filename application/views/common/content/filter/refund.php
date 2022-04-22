<tr>
    <td class="text-right"> Hoàn học phí </td>
    <td>
        <select class="form-control selectpicker" name="filter_refund">
            <option value="">Không lọc</option>
			<option value="1" <?php echo (isset($_GET['filter_refund']) && $_GET['filter_refund'] == 1) ? 'selected' : '' ?>>Chỉ tính hoàn học phí </option>
			<option value="2" <?php echo (isset($_GET['filter_refund']) && $_GET['filter_refund'] == 2) ? 'selected' : '' ?>>Chỉ tính chi tiêu cơ sở </option>
        </select>
    </td>
</tr>
