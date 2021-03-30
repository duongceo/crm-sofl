<tr>

	<td class="text-right"> Đóng học phí</td>

	<td>

		<div class="input-group">

			<label for="price-purchase" class="sr-only">Đóng học phí</label>

			<input type="text" class="form-control money" value="0" name="paid_today"/>

			<div class="input-group-btn">
				<button type="button" class="btn btn-success" data-toggle="collapse" data-target="#paid_source_book">HV mua sách <i class="fa fa-arrow-circle-down" aria-hidden="true"></i> </button>
			</div>

		</div>

		<div class="collapse" id="paid_source_book">
			<div class="input-group">
				<input type="text" class="form-control money" value="0" name="paid_book"/>
			</div>
			<div class="input-group">
				<input type="text" class="form-control datetimepicker" placeholder="Ngày mua sách" name="date_paid_book"/>
				<div class="input-group-btn">
					<button class="reset_datepicker btn btn-warning"> Reset </button>
				</div>
			</div>
		</div>

	</td>

</tr>

<script type="text/javascript">
	$('.money').simpleMoneyFormat();
</script>
