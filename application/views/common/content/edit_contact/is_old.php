<tr>
    <td class="text-right"> Học viên mới hay cũ ? </td>
    <td>  
        <div class="radio">
            <label class="radio-inline" style="width: 45%">
                <input type="radio" name="is_old" value="0" <?php if($rows['is_old'] == 0){echo 'checked="checked"';} ?>> Mới
            </label>
            <label class="radio-inline" style="width: 45%">
                <input type="radio" name="is_old" value="1" <?php if($rows['is_old'] == 1){echo 'checked="checked"';} ?>> Cũ
            </label>
        </div>
    </td>
</tr>
