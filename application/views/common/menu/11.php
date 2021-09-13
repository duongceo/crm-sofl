
<nav id="sidebar">
	<div id="dismiss">
		<i class="glyphicon glyphicon-arrow-left"></i>
	</div>

	<div class="sidebar-header">
		<h3>Menu :))</h3>
		<?php if ($this->agent->mobile) { ?>
			<a href="javascript:;" class="user-profile" style="font-size: 16px; color: #f0f0f0 !important;">

				<img src="<?php echo base_url(); ?>style/img/logo.png" alt=""> <span> <?php echo $this->session->userdata('name'); ?> </span>

			</a>
		<?php } ?>
	</div>

	<ul class="list-unstyled components">
		<li>
			<a href="<?php echo base_url('care_page'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách Contact đã nhập vào hôm nay </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('care_page/contact_have_not_yet_been_divided'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách Contact chưa chia cho sale </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('care_page/view_all_contact'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách tất cả contact đã nhập </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html'); ?>">
				<img src="<?php echo base_url(); ?>public/images/report.png">
				<span> Xem sale nhận contact </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">

				<img src="<?php echo base_url(); ?>public/images/add-contact.png">

				<span> Thêm mới contact </span>

			</a>
		</li>

		<li>
			<a href="<?php echo base_url('staff_managers/class_study'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Lịch khai giảng </span>
			</a>
		</li>

		<li>

			<a href="<?php echo base_url('home/logout'); ?>">
				<img src="<?php echo base_url(); ?>public/images/logout.png">
				<span> Đăng Xuất </span>
			</a>
		</li>

	</ul>

</nav>
