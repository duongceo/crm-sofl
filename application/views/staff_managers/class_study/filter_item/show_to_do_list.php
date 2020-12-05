<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h3 class="text-center marginbottom20">Tiến độ công việc hôm nay</h3>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary text-center">
				<div class="panel-heading">Các lớp chưa khai giảng</div>
				<div class="panel-body">
					<div class="row">
						<?php
						unset($language[3]);
						$tomorrow = date("d/m/Y", strtotime('tomorrow'));
						$before_4_day = date("d/m/Y", strtotime("+4 day"));
//						echo $before_4_day; die();
						foreach ($language as $value) { ?>
							<div class="col-md-4">
								<div class="panel panel-danger text-center">
									<div class="panel-heading"><?php echo $value['name']?></div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-6">
												<div class="panel panel-warning text-center">
													<div class="panel-heading">1 ngày</div>
													<div class="panel-body">
														<a class="btn btn-success btn-block" href="<?php echo base_url().'staff_managers/class_study?filter_date_time_start='.$tomorrow.'-'.$tomorrow.'&filter_arr_language_id='.$value['id']?>">Lọc</a>
<!--														<button class="btn btn-success btn-block">Chọn</button>-->
													</div>
												</div>
											</div>

											<div class="col-md-6">
												<div class="panel panel-warning text-center">
													<div class="panel-heading">4 ngày</div>
													<div class="panel-body">
														<a class="btn btn-success btn-block" href="<?php echo base_url().'staff_managers/class_study?filter_date_time_start='.$before_4_day.'-'.$before_4_day.'&filter_arr_language_id='.$value['id']?>">Lọc</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

<!--						<div class="col-md-4">-->
<!--							<div class="panel panel-danger text-center">-->
<!--								<div class="panel-heading">Hàn</div>-->
<!--								<div class="panel-body">-->
<!--									<button class="btn btn-success btn-block contact-sale-have-to-call" type="L1">--><?php //echo $progress_sale['L1'];?><!--</button>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-primary text-center">
				<div class="panel-heading">Các lớp đã khai giảng</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-9">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Các lớp đã khai giảng</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-4">
											<div class="panel panel-warning text-center">
												<div class="panel-heading">Giai đoạn 1</div>
												<div class="panel-body">
													<a class="btn btn-success btn-block" href="<?php echo base_url().'staff_managers/class_study?filter_arr_lesson_learned=4'?>">Lọc</a>
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="panel panel-warning text-center">
												<div class="panel-heading">Giai đoạn 2</div>
												<div class="panel-body">
													<a class="btn btn-success btn-block" href="<?php echo base_url().'staff_managers/class_study?filter_distance=gd2'?>">Lọc</a>
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="panel panel-warning text-center">
												<div class="panel-heading">Giai đoạn 3</div>
												<div class="panel-body">
													<a class="btn btn-success btn-block" href="<?php echo base_url().'staff_managers/class_study?filter_distance=gd3'?>">Lọc</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Các lớp đã kết thức</div>
								<div class="panel-body">
									<div class="panel panel-warning text-center">
										<div class="panel-heading">Các lớp đã kết thức</div>
										<div class="panel-body">
											<a class="btn btn-success btn-block" href="<?php echo base_url().'staff_managers/class_study?filter_arr_character_class_id=3'?>">Lọc</a>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>
