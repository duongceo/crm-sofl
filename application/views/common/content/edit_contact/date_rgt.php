<tr>
    <td class="text-right"> Ngày contact về </td>
    <td>

        <div class="input-group" style="margin: 0;">

            <input type="text" class="form-control datetimepicker" name="date_rgt"

                <?php if (!empty($rows['date_rgt'])) { ?>

                    value="<?php echo date('d-m-Y H:i', $rows['date_rgt']); ?>"

                <?php } ?>
            />

            <div class="input-group-btn">

                <button class="reset_datepicker btn btn-success"> Reset</button>

            </div><!-- /btn-group -->

        </div><!-- /input-group -->

    </td>
</tr>