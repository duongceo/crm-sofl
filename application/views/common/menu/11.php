
<nav id="sidebar">
	<div id="dismiss">
		<i class="glyphicon glyphicon-arrow-left"></i>
	</div>

	<div class="sidebar-header">
		<h3>Menu :))</h3>
	</div>

	<ul class="list-unstyled components">
		<li>
			<a href="<?php echo base_url('care_page'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách Contact đã nhập vào hôm nay </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('care_page/view_all_contact'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách tất cả contact đã nhập </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">

				<img src="<?php echo base_url(); ?>public/images/add-contact.png">

				<span> Thêm mới contact </span>

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
