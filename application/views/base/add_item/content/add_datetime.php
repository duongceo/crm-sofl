<tr>    <td class = "text-right"> <?php echo h_find_name_display($key, $this->list_view); ?></td>    <td style="position: relative;">        <div class="input-group" style="margin: 0;">            <input type="text" class="form-control datepicker" name="add_<?php echo $key; ?>" />            <div class="input-group-btn">                <button class="reset_datepicker btn btn-primary"> Reset</button>            </div>        </div>    </td></tr>