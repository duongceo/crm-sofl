
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />


<div class="container margintop45 marginbottom35">
    <?php echo validation_errors(); ?>
    <div class="row">
        <div class="col-md-7 col-md-offset-1">
            <h3 class="text-center marginbottom20"> Thêm mới contact </h3>
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
                            <input type="email" class="form-control" name="email" value="
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
							} else {
								echo set_value('phone');
							} ?>
							"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Địa chỉ
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Địa chỉ" name="address" value="
                            <?php if (isset($_GET['address'])) {
								echo $_GET['address'];
							} else {
								echo set_value('address');
							} ?>
							"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            Mã lớp học
                        </div>
                        <div class="col-md-8">
							<select class="form-control select_course" name="class_study_id" multiple="multiple">
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
										<?php if (set_value('source_id') == $value['id']) echo "selected"; ?>>
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
								<option value="">Chọn kênh quảng cáo</option>
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
                            Hình thức mua
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="payment_method_rgt">
                                <option value="1"> Thanh toán bằng tiền mặt </option>
                                <option value="2"> Chuyển khoản </option>
                                <option value="3"> ATM </option>
<!--                                <option value="4"> Thanh toán trực tiếp </option>-->
                                <option value="5"> VISA </option>
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
                            <input type="text" class="form-control" placeholder="Học phí" name="fee" value=""/>
                        </div>
                    </div>
                </div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4 text-right">
							Đã đóng
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" placeholder="" name="paid" value="0"/>
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
