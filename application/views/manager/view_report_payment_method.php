<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo doanh thu từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<div class="table-responsive">
	<table class="table table-bordered table-striped view_report">
		<thead>
			<tr>
				<th style="background: none" rowspan="2"></th>
				<th rowspan="2">Tiền Mặt</th>
				<th rowspan="2">Quẹt thẻ</th>
				<th style="background-color: #1e5f24" colspan="<?php echo count($account_banking) + 1;?>">Chuyển khoản</th>
			</tr>
			<tr>
				<?php foreach ($account_banking as $item) { ?>
					<th style="background-color: #1e5f24">
						<?php echo $item['bank'];?>
					</th>
				<?php } ?>
				<th style="background-color: #3e5f5f">Tổng CK</th>
			</tr>
		</thead>

		<tbody>
		<?php foreach ($re as $value) { ?>
			<tr>
			<td style="background-color: #8aa6c1">
				<?php echo $value['branch_name']; ?>
			</td>
				<?php foreach ($payment_method_rgt as $value_payment) { ?>
					<?php
					if ($value_payment['id'] == 4) {
						foreach ($account_banking as $account) { ?>
							<td>
							<?php echo number_format($value[$value_payment['id']][$account['bank']]['re_total'], 0, ",", "."); ?>
							</td>
						<?php } ?>
							<td>
								<?php echo number_format($value[$value_payment['id']]['re_total'], 0, ",", "."); ?>
							</td>
					<?php } else { ?>
						<td>
							<?php echo number_format($value[$value_payment['id']]['re_total'], 0, ",", "."); ?>
						</td>
					<?php } ?>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>

<hr>
<h3 class="text-center">Thống kê tiền mặt theo ngày</h3>
<div class="row">
    <div class="col-lg-2 col-md-2 col-xs-5" style="padding-right: 0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped view_report">
                <thead class="table-head-pos">
                    <tr>
                        <th style="height: 50px; background: none;"></th>
                        <th style="background-color: #147c67"">Tổng tiền</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cash as $key => $item) { ?>
                        <tr>
                            <td style="background: #48baad; height: 50px;"> <?php echo $key; ?> </td>
                            <td> <?php echo number_format($item['total'], 0, ",", "."); ?> </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-10 col-md-10 col-xs-7" style="padding-left: 0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped view_report gr4-table">
                <thead class="table-head-pos">
                    <tr>
                        <?php foreach ($date as $item) { ?>
                            <th style="min-width: 180px; height: 50px; background-color: #4689c8"> <?php echo $item ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cash as $key_report => $item_report) { ?>
                    <tr>
                        <?php foreach ($date as $item) { ?>
                            <td style="height: 50px;"><?php echo number_format($item_report[$item], 0, ",", ".")?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
