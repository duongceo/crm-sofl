
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />


<div class="container margintop45 marginbottom35">
    <?php echo validation_errors(); ?>
    <div class="row">
        <div class="col-md-7 col-md-offset-1">
            <h3 class="text-center marginbottom20"> Thêm mới 1 contact </h3>
            <form method="post" action="<?php echo base_url('sale/add_contact'); ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Họ tên
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Họ tên" name="name" value="
                            <?php if (isset($_GET['name'])) {
								echo $_GET['name'];
							} else {
								echo set_value('name');
							} ?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Email
                        </div>
                        <div class="col-md-8">
                            <input type="email" class="form-control" placeholder="Email" name="email" value="
                            <?php if (isset($_GET['email'])) {
								echo $_GET['email'];
							} else {
								echo set_value('email');
							} ?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Số điện thoại
                        </div>
                        <div class="col-md-8">
                            <input type="tel" class="form-control" placeholder="Số điện thoại" name="phone" value="
                            <?php if (isset($_GET['phone'])) {
								echo $_GET['phone'];
							}?>"/>
                        </div>
                    </div>
                </div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Ngày contact về
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<div class='input-group date date_rgt'>
									<input type='text' class="form-control" name='date_rgt' value="<?php if (isset($_GET['date_rgt'])) {
										echo date('m-d-Y H:m', $_GET['date_rgt']);
									}?>" />
									<span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
								</div>
							</div>
						</div>
					</div>
				</div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Học viên mới hay cũ
                        </div>
                        <div class="col-md-8">
                            <div class="radio">
                                <label class="radio-inline">
                                    <input type="radio" name="is_old" value="1" <?php echo (isset($_GET['is_old']) && $_GET['is_old']) == 1 ? 'checked':''?>> Cũ
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_old" value="0"> Mới
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Cơ sở
						</div>
						<div class="col-md-8">
							<select class="form-control" name="branch_id">
								<option value="0"> Chọn cơ sở </option>
								<?php
								foreach ($branch as $key => $value) {
									?>
									<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $_GET['branch_id']) echo 'selected'; ?>>
										<?php echo $value['name']; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Trạng thái gọi
						</div>
						<div class="col-md-8">
							<select class="form-control" name="call_status_id">
								<option value="0"> Trạng thái gọi</option>
								<?php
								foreach ($call_status as $key => $value) {
									?>
									<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $_GET['call_status_id']) echo 'selected'; ?>>
										<?php echo $value['name']; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
				</div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Trạng thái contact
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select_contact_status" name="level_contact_id">
                                <option value="">Trạng thái contact</option>
								<?php foreach ($level_contact as $key => $value) { ?>
									<option value="<?php echo $value['level_id']; ?>" <?php if ($value['level_id'] == $_GET['level_contact_id']) echo 'selected'; ?>>
										<?php echo $value['level_id'] . ' -- ' . $value['name'] .''; ?>
									</option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Trạng thái học viên
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select_contact_status" name="level_student_id">
                                <option value="">Trạng thái học viên</option>
								<?php foreach ($level_student as $key => $value) { ?>
									<option value="<?php echo $value['level_id']; ?>" <?php if ($value['level_id'] == $_GET['level_student_id']) echo 'selected'; ?>>
										<?php echo $value['level_id'] . ' -- ' . $value['name'] .''; ?>
									</option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Ngày đăng ký học
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class='input-group date'>
                                    <input type='text' class="form-control" name='date_rgt_study' value="" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Ngoại ngữ
						</div>
						<div class="col-md-8">
							<select class="form-control" name="language_id">
								<option value=""> Ngoại ngữ </option>
								<?php foreach ($language_study as $value) { ?>
									<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $_GET['language_id']) echo 'selected'; ?>>
										<?php echo $value['name']; ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Trình độ ngoại ngữ
						</div>
						<div class="col-md-8">
							<select class="form-control" name="level_language_id">
								<option value="0"> Trình độ </option>
								<?php foreach ($level_language as $value) { ?>
									<option value="<?php echo $value['id']; ?>">
										<?php echo $value['name']?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Mã lớp học (Nếu có)
                        </div>
                        <div class="col-md-8">
							<select class="form-control select_course" name="class_study_id">
								<option value="">Mã lớp học</option>
								<?php foreach ($class_study as $value) { ?>
									<option value="<?php echo $value['class_study_id']; ?>">
										<?php echo $value['class_study_id'] . ' -- ' . $value['name_class'] .''; ?>
									</option>
								<?php } ?>
							</select>
							
                        </div>
                    </div>
                </div>
				
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Nguồn kênh
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="source_id">
                                <option value="0"> Chọn nguồn kênh </option>
									<?php foreach ($sources as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"
										<?php if ($_GET['source_id'] == $value['id']) echo "selected"; ?>>
										<?php echo $value['name']; ?>
									</option>
									<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

			<?php if($this->role_id == 6){ ?>
				<div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Kênh quảng cáo
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="channel_id">
								<option value="2">Facebook Ads</option>
                               <?php foreach($channel as $value) { ?>
							   <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
							   <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
				
				<div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Campaign
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="campaign_id">
                                <option value="0"> Chọn campaign </option>
								<?php foreach ($campaign as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"
									<?php if (set_value('campaign_id') == $value['id']) echo "selected"; ?>>
									<?php echo $value['name']; ?>
									</option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Adset
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="adset_id">
                                <option value="0"> Chọn adset </option>
								<?php foreach ($adset as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>"
									<?php if (set_value('adset_id') == $value['id']) echo "selected"; ?>>
									<?php echo $value['name']; ?>
									</option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
				<div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Ad
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="ad_id">
                                <option value="0"> Chọn ad </option>
								<?php foreach ($ad as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"
									<?php if (set_value('ad_id') == $value['id']) echo "selected"; ?>>
									<?php echo $value['name']; ?>
                                    </option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
			<?php } ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Hình thức thanh toán
                        </div>
                        <div class="col-md-8">
							<select class="form-control" name="payment_method_rgt">
								<option value="1">Thanh toán trực tiếp</option>
								<?php foreach($payment_method_rgt as $value) { ?>
									<option value="<?php echo $value['id']; ?>"><?php echo $value['method']; ?></option>
								<?php } ?>
							</select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Học phí
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control money" placeholder="Học phí" name="fee" value=""/>
                        </div>
                    </div>
                </div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Đã đóng
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control money" placeholder="" name="paid" value=""/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Ngày đóng tiền
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<div class='input-group date'>
									<input type='text' class="form-control" name='date_paid' value="" />
									<span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
								</div>
							</div>
						</div>
					</div>
				</div>

<!--                <div class="form-group">-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-4 text-right">-->
<!--                            Nguồn bán -->
<!--                        </div>-->
<!--                        <div class="col-md-8">-->
<!--                            <div class="radio">-->
<!--                                <label class="radio-inline">-->
<!--                                    <input type="radio" name="source_sale_id" value="1" checked=""> Lakita-->
<!--                                </label>-->
<!--                            </div>-->
<!--                            <div class="radio">-->
<!--                                <label class="radio-inline">-->
<!--                                    <input type="radio" name="source_sale_id" value="2"> Ngoài-->
<!--                                </label>-->
<!--                            </div>-->
<!--                            <div class="radio">-->
<!--                                <label class="radio-inline">-->
<!--                                    <input type="radio" name="source_sale_id" value="3"> Thầy-->
<!--                                </label>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Ghi chú
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="3" name="note"></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script>
	$(document).ready(function() {
		$('.select_course').select2({
			placeholder: 'Tìm lớp học'
		});

	});
</script>

<script>
    $(document).ready(function() {
        $('.select_contact_status').select2({
            placeholder: 'Tìm trạng thái'
        });

    });
</script>

<script type="text/javascript">
    $(function () {
        $('.date').datetimepicker();
    });
</script>

<script  type="text/javascript">
	$('.money').simpleMoneyFormat();
</script>
