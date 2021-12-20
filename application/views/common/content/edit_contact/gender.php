<tr>
    <td class="text-right"> Giới tính </td>
    <td>
        <div class="radio">
            <label class="radio-inline" style="width: 45%">
                <input type="radio" name="gender" value="1" <?php if($rows['gender'] == 1){echo 'checked="checked"';} ?>> Nam
            </label>
            <label class="radio-inline" style="width: 45%">
                <input type="radio" name="gender" value="0" <?php if($rows['gender'] == 0){echo 'checked="checked"';} ?>> Nữ
            </label>
        </div>
    </td>
</tr>
