<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h3 class="text-center marginbottom20">Tiến độ công việc hôm nay</h3>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-primary text-center">
				<div class="panel-heading">Xử lý Contact L1</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Tổng</div>
								<div class="panel-body">
									<button class="btn btn-success btn-block contact-sale-have-to-call" type="L1"><?php echo $progress_sale['L1'];?></button>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Đã gọi</div>
								<div class="panel-body">
									<button class="btn btn-warning btn-block"><?php echo $progress_sale['L1_XULY'];?></button>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Tiến độ</div>
								<div class="panel-body">
									<button class="btn btn-warning btn-block"><?php echo round($progress_sale['L1_XULY'] / $progress_sale['L1'] * 100, 2);?> %</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-primary text-center">
				<div class="panel-heading">Xử lý Contact Không Nghe Máy</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Lần 1</div>
								<div class="panel-body">
									<button class="btn btn-success btn-block contact-sale-have-to-call" type="KNM_LAN_1"><?php echo $progress_sale['KNM_LAN_1'];?></button>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Lần 2</div>
								<div class="panel-body">
									<button class="btn btn-success btn-block contact-sale-have-to-call" type="KNM_LAN_2"><?php echo $progress_sale['KNM_LAN_2'];?></button>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Lần 3</div>
								<div class="panel-body">
									<button class="btn btn-success btn-block contact-sale-have-to-call" type="KNM_LAN_3"><?php echo $progress_sale['KNM_LAN_3'];?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-primary text-center">
				<div class="panel-heading">Xử lý Contact L3</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Tổng</div>
								<div class="panel-body">
									<button class="btn btn-success btn-block contact-sale-have-to-call" type="L3"><?php echo $progress_sale['L3'];?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-primary text-center">
				<div class="panel-heading">Xử lý Contact L2</div>
				<div class="panel-body">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-danger text-center">
							<div class="panel-heading">Tổng</div>
							<div class="panel-body">
								<button class="btn btn-success btn-block contact-sale-have-to-call" type="L2"><?php echo $progress_sale['L2'];?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
