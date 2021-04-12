
<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

	<div class="sidebar-header">
		<h3>Menu :))</h3>
	</div>

    <ul class="list-unstyled components">
        <li>
            <a href="<?php echo base_url('customer_care'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách học viên đang học </span>
			</a>
        </li>

		<li>
			<a href="<?php echo base_url('customer_care/view_contact_recall'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách hẹn gọi lại </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('customer_care/view_all_contact'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Danh sách tất cả học viên </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Thêm mới contact </span>
			</a>
		</li>

		<ul class="collapse list-unstyled" id="homeSubmenu_5">
			<li>

				<a href="<?php echo base_url('manager/view_report_customer_care'); ?>">

					<img src="<?php echo base_url(); ?>public/images/report.png">

					<span> Xem báo chăm sóc hv đi lên </span>

				</a>

			</li>

			<li>

				<a href="<?php echo base_url('manager/view_report_care_L7'); ?>">

					<img src="<?php echo base_url(); ?>public/images/report.png">

					<span> Xem báo các trạng thái L7</span>

				</a>

			</li>

		</ul>

        <li>
			<a href="<?php echo base_url('home/logout'); ?>">
				<img src="<?php echo base_url(); ?>public/images/logout.png">
				<span> Đăng Xuất </span>
			</a>
        </li>
    </ul>
</nav>
