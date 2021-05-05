
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

			<a href="<?php echo base_url('manager/view_report_revenue'); ?>">

				<img src="<?php echo base_url(); ?>public/images/report.png">

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
