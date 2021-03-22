<tr>

	<td class="text-right"> Ngày khách hẹn gọi lại </td>

	<td>

		<div class="input-group">

			<input type="text" class="form-control datetimepicker date_recall_customer_care" name="date_recall_customer_care"

				<?php if ($rows['date_recall_customer_care'] > 0) { ?>

					value="<?php echo date('d-m-Y H:i', $rows['date_recall_customer_care']); ?>"

				<?php } ?> />

			<div class="input-group-btn">

				<button class="reset_datepicker btn btn-primary"> Reset</button>

			</div><!-- /btn-group -->

		</div><!-- /input-group -->

	</td>

</tr>
