
<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
        </div>

	<ul class="list-unstyled components">

<!--		<li>-->
<!--			<a href="--><?php //echo base_url('staff_managers/class_time'); ?><!--">-->
<!--				<img src="--><?php //echo base_url(); ?><!--public/images/view-all.png">-->
<!--				<span>Danh sách phòng & ca học</span>-->
<!--			</a>-->
<!--		</li>-->

		<li>
			<a href="<?php echo base_url('danh-sach-hoc-vien.html'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span>Danh sách học viên đã đăng ký</span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('student/view_all_contact'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span>Danh sách tất cả học viên</span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('staff_managers/classroom'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Quản lý phòng học
                </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('staff_managers/class_study'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Quản lý lớp học </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Thêm mới contact </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('manager/view_report_revenue'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Báo cáo doanh thu </span>
			</a>
		</li>

		<li>

			<a href="<?php echo base_url('home/logout'); ?>">

				<img src="<?php echo base_url(); ?>public/images/logout.png">

				<span> Đăng xuất  </span>

			</a>

		</li>

    </ul>

</nav>
