
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
		<!-- <li>
			<a href="<?php echo base_url('staff_managers/class_time'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span>Danh sách phòng & ca học</span>
			</a>
		</li> -->

		<li>
			<a href="<?php echo base_url('danh-sach-hoc-vien.html'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span>Danh sách học viên</span>
			</a>
		</li>

        <li>
            <a href="<?php echo base_url('staff_managers/branch'); ?>">
                <img src="<?php echo base_url(); ?>public/images/new.png"> 
                <span> Quản lý cơ sở - chi nhánh
                </span>
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
			<a href="<?php echo base_url('staff_managers/language_study'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Quản lý ngoại ngữ </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('staff_managers/level_language'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Quản lý Khóa học </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('staff_managers/teacher'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Quản lý giáo viên </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('staff_managers/staff'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Quản lý nhân viên </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('student/cost_branch'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Chi tiêu và thống kê tại cơ sở </span>
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
