
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

			<a href="<?php echo base_url(); ?>">

				<img src="<?php echo base_url(); ?>public/images/new.png">

				<span> Học viên và Doanh thu hôm nay </span>

			</a>

		</li>

		<li>

			<a href="<?php echo base_url('marketing/view_table_compare'); ?>">

				<img src="<?php echo base_url(); ?>public/images/report.png">

				<span> Bảng đánh giá </span>

			</a>

		</li>

		<li>

			<a href="<?php echo base_url('manager/view_report_revenue'); ?>">

				<img src="<?php echo base_url(); ?>public/images/dollar.png">

				<span> Báo cáo doanh thu </span>

			</a>

		</li>

		<li>

			<a href="<?php echo base_url('manager/view_report_student_branch'); ?>">

				<img src="<?php echo base_url(); ?>public/images/view-general-report.png">

				<span> Báo cáo học viên tại cơ sở  </span>

			</a>

		</li>

		<li>

			<a href="<?php echo base_url('marketing/view_report_quality_contact'); ?>">

				<img src="<?php echo base_url(); ?>public/images/quality.png">

				<span> Báo cáo hiệu quả Marketing</span>

			</a>

		</li>

		<li>

			<a href="<?php echo base_url('quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html'); ?>">

				<img src="<?php echo base_url(); ?>public/images/tvts.png">

				<span> Xem báo cáo TVTS </span>

			</a>

		</li>

		<li>

			<a href="<?php echo base_url('manager/view_report_source'); ?>">

				<img src="<?php echo base_url(); ?>public/images/report.png">

				<span> Xem báo cáo theo nguồn </span>

			</a>

		</li>

		<li>

			<a href="<?php echo base_url('manager/view_report_sale_source'); ?>">

				<img src="<?php echo base_url(); ?>public/images/report.png">

				<span> Xem báo cáo theo Nguồn - Sale </span>

			</a>

		</li>

		<li>
			<a href="<?php echo base_url('student/cost_branch'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Thống kê chi tiêu tại cơ sở </span>
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
