<tr>

    <td class="text-right"> Ngày đăng ký học</td>

    <td> 

        <div class="input-group">

           <input type="text" class="form-control datetimepicker" name="date_rgt_study"

        	<?php if ($rows['date_rgt_study'] > 0) { ?>

                   value="<?php echo date('d-m-Y H:i', $rows['date_rgt_study']); ?>"

			<?php } ?> />

            <div class="input-group-btn">

                <button class="reset_datepicker btn btn-success"> Reset</button>

            </div><!-- /btn-group -->

        </div><!-- /input-group -->

    </td>

</tr>
