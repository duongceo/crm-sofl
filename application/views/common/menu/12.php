
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
<!--		<li>-->
<!--			<a href="--><?php //echo base_url('staff_managers/class_time'); ?><!--">-->
<!--				<img src="--><?php //echo base_url(); ?><!--public/images/view-all.png">-->
<!--				<span>Danh sách phòng & ca học</span>-->
<!--			</a>-->
<!--		</li>-->
		<li>
			<a href="#submenu" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span>Danh sách contact</span>
			</a>
			<ul class="collapse list-unstyled" id="submenu">
				<li>
					<a href="<?php echo base_url('danh-sach-hoc-vien.html'); ?>">
						<img src="<?php echo base_url(); ?>public/images/view-all.png">
						<span>Danh sách học viên đã đăng ký</span>
					</a>
				</li>

				<li>
					<a href="<?php echo base_url('student/contact_sort_class'); ?>">
						<img src="<?php echo base_url(); ?>public/images/view-all.png">
						<span>Danh sách học viên đã xếp lớp</span>
					</a>
				</li>

				<li>
					<a href="<?php echo base_url('student/contact_unsort_class'); ?>">
						<img src="<?php echo base_url(); ?>public/images/view-all.png">
						<span>Danh sách học viên chưa xếp lớp</span>
					</a>
				</li>

                <li>
                    <a href="<?php echo base_url('student/contact_reserve'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png">
                        <span>Danh sách học viên bảo lưu</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('student/contact_refund'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png">
                        <span>Danh sách học viên rút học phí</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('student/contact_truant'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png">
                        <span>Danh sách HV có nghỉ học</span>
                    </a>
                </li>

				<li>
					<a href="<?php echo base_url('student/view_all_contact'); ?>">
						<img src="<?php echo base_url(); ?>public/images/view-all.png">
						<span>Danh sách tất cả học viên</span>
					</a>
				</li>
			</ul>
		</li>

		<li>
			<a href="#submenu_manager" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span>Quản lý</span>
			</a>
			<ul class="collapse list-unstyled" id="submenu_manager">
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
                    <a href="<?php echo base_url('staff_managers/book'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png">
                        <span> Quản lý sách </span>
                    </a>
                </li>

				<li>
					<a href="<?php echo base_url('staff_managers/teacher'); ?>">
						<img src="<?php echo base_url(); ?>public/images/view-all.png">
						<span> Quản lý giảng viên </span>
					</a>
				</li>

                <li>
                    <a href="<?php echo base_url('student/manager_diligence'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png">
                        <span> Kiểm tra chuyên cần </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('staff_managers/teacher/statistical_salary_teacher'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png">
                        <span> Thống kê lương giáo viên </span>
                    </a>
                </li>

			</ul>
		</li>

		<li>
			<a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Thêm mới contact </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('student/cost_branch'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Cập nhật chi tiêu tại cơ sở </span>
			</a>
		</li>

		<li>
			<a href="#homeSubmenu_3" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/report.png">
				<span>Báo Cáo</span>
			</a>
			<ul class="collapse list-unstyled" id="homeSubmenu_3">

				<li>

					<a href="<?php echo base_url('manager/view_report_revenue'); ?>">

						<img src="<?php echo base_url(); ?>public/images/dollar.png">

						<span> Báo cáo doanh thu </span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_payment_method'); ?>">

						<img src="<?php echo base_url(); ?>public/images/dollar.png">

						<span> Báo cáo doanh thu - HTTT </span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_revenue_class'); ?>">

						<img src="<?php echo base_url(); ?>public/images/dollar.png">

						<span> Báo cáo doanh thu lớp học</span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_student_branch'); ?>">

						<img src="<?php echo base_url(); ?>public/images/view-general-report.png">

						<span> Báo cáo học viên tại cơ sở  </span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_class_study'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Xem báo cáo lớp học </span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_care_L7'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Xem báo các trạng thái L7</span>

					</a>

				</li>

			</ul>
		</li>

		<li>

			<a href="<?php echo base_url('home/logout'); ?>">

				<img src="<?php echo base_url(); ?>public/images/logout.png">

				<span> Đăng xuất  </span>

			</a>

		</li>

    </ul>

</nav>
