<tr>

	<td class="text-right"> Ngày thực hiện L7</td>

	<td>

		<div class="input-group" style="margin: 0;">

			<input type="text" class="form-control datetimepicker" name="date_action_of_study"

				<?php if ($rows['date_action_of_study'] > 0) { ?>

					value="<?php echo date('d-m-Y H:i', $rows['date_action_of_study']); ?>"

				<?php } ?> />

			<div class="input-group-btn">

				<button class="reset_datepicker btn btn-success"> Reset</button>

			</div><!-- /btn-group -->

		</div><!-- /input-group -->

	</td>

</tr>
