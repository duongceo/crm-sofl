
<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
        </div>

    <ul class="list-unstyled components">

<!--        <li>-->
<!---->
<!--            <a href="--><?php //echo base_url('quan-ly/xem-tat-ca-contact.html'); ?><!--">-->
<!---->
<!--                <img src="--><?php //echo base_url(); ?><!--public/images/view-all.png"> -->
<!---->
<!--                <span> Danh sách toàn bộ contact (--><?php //echo $this->L['all'];?><!--)-->
<!--		-->
<!--                </span>-->
<!---->
<!--            </a>-->
<!---->
<!--        </li>-->

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

            <a href="<?php echo base_url('home/logout'); ?>">

                <img src="<?php echo base_url(); ?>public/images/logout.png"> 

                <span> Đăng xuất  </span>

            </a>

        </li>

    </ul>

</nav>
