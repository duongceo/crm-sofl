<tr>

	<td class="text-right"> Ngày đóng tiền</td>

	<td>

		<div class="input-group">

			<input type="text" class="form-control datetimepicker" name="date_paid"

				<?php if ($rows['date_paid'] > 0) { ?>

					value="<?php echo date('d-m-Y H:i', $rows['date_paid']); ?>"

				<?php } ?> />

			<div class="input-group-btn">

				<button class="reset_datepicker btn btn-warning"> Reset</button>

			</div><!-- /btn-group -->

		</div><!-- /input-group -->

	</td>

</tr>
