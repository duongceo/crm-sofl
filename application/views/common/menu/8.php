
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
            <a href="<?php echo base_url('student/get_class_attendance'); ?>">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span> Điểm danh lớp </span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url('staff_managers/class_study'); ?>">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span> Danh sách lớp học </span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url('staff_managers/teacher/order_teacher_abroad'); ?>">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span> Order lịch học giáo viên bản ngữ</span>
            </a>
        </li>

        <li>
            <a href="https://docs.google.com/spreadsheets/d/169-619KYMGNLZSonynjiS5NB-4Mkr2Apy_wIEFg1s8o/edit?usp=sharing" target="_blank">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span> Nội quy - Thưởng - Vi phạm đối với GV </span>
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
