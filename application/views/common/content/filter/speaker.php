<tr>
    <td class="text-right"> Giáo viên dạy </td>
    <td>
        <select class="form-control selectpicker" name="filter_speaker">
            <option value="">Giáo viên dạy</option>
            <option value="0" <?php echo (isset($_GET['filter_speaker']) && $_GET['filter_speaker'] == '0') ? 'selected' : ''?>>Giáo viên bản ngữ</option>
            <option value="1" <?php echo (isset($_GET['filter_speaker']) && $_GET['filter_speaker'] == 1) ? 'selected' : ''?>>Giáo viên Việt</option>
        </select>
    </td>
</tr>
