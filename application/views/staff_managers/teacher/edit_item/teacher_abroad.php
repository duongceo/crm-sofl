<tr>
    <td class="text-right"> Giáo viên bản ngữ </td>
    <td>
        <div class="radio">
            <label class="radio-inline" style="width: 45%">
                <input type="radio" name="teacher_abroad" value="0" <?php if($row['teacher_abroad'] == 0){echo 'checked="checked"';} ?>> GV Việt
            </label>
            <label class="radio-inline" style="width: 45%">
                <input type="radio" name="teacher_abroad" value="1" <?php if($row['teacher_abroad'] == 1){echo 'checked="checked"';} ?>> GV Bản ngữ
            </label>
        </div>
    </td>
</tr>