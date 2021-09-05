
<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

	<div class="sidebar-header">
		<h3>Menu :))</h3>

		<?php if ($this->agent->mobile) { ?>
			<a href="javascript:" class="user-profile" style="font-size: 16px; color: #f0f0f0 !important;">
				<img src="<?php echo base_url(); ?>style/img/logo.png" alt=""> <span> <?php echo $this->session->userdata('name'); ?> </span>
			</a>
		<?php } ?>
	</div>

    <ul class="list-unstyled components">
        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span>Danh sách contact</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>

                    <a href="<?php echo base_url(); ?>">

                        <img src="<?php echo base_url(); ?>public/images/new.png"> 

                        <span> Danh sách contact mới không trùng (<?php echo $this->L['L1'];?>)

                        <!-- <sup> <span class="badge bg-red"> <?php //echo $this->L['L1'];?> </span> </sup> -->

                        </span>

                    </a>

                </li>
                
                <li>

                    <a href="<?php echo base_url().'/quan-ly/contact-moi-trung.html'; ?>">

                        <img src="<?php echo base_url(); ?>public/images/new.png"> 

                        <span> Danh sách contact mới bị trùng (<?php echo $this->L['L1_trung'];?>)

                        </span>

                    </a>

                </li>
				
				<li>

                    <a href="<?php echo base_url().'manager/contact_cancel'; ?>">

                        <img src="<?php echo base_url(); ?>public/images/new.png"> 

                        <span> Danh sách contact rút học phí

                        </span>

                    </a>

                </li>

<!--                <li>-->
<!---->
<!--                    <a href="--><?php //echo base_url().'/quan-ly/contact-cho-chuyen.html'; ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/new.png"> -->
<!---->
<!--                        <span> Danh sách contact chờ chuyển (--><?php //echo $this->L['contact_transfer']; ?><!--)-->
<!---->
<!--                        </span>-->
<!---->
<!--                    </a>-->
<!---->
<!--                </li>-->
                
                <li>

                    <a href="<?php echo base_url('quan-ly/xem-tat-ca-contact.html'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/view-all.png"> 

                        <span> Danh sách toàn bộ contact (<?php echo $this->L['all'];?>)

            <!--<sup> <span class="badge bg-red"> <?php echo $this->L['all'];?> </span> </sup>-->

                        </span>

                    </a>

                </li>
            </ul>
        </li>
    
        <li>
            <a href="#homeSubmenu_3" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>Báo Cáo</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_3">
                <li>

                    <a href="<?php echo base_url('quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/tvts.png">

                        <span> Báo cáo TVTS </span>

                    </a>

                </li>

				<li>

					<a href="<?php echo base_url('manager/view_report_sale_handle'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Báo cáo xử lý contact </span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_sale_handle_source_data'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Báo cáo xử lý contact - Nguồn Data lạnh </span>

					</a>

				</li>

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

                    <a href="<?php echo base_url('manager/view_report_student_branch'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/view-general-report.png">

                        <span> Báo cáo học viên tại cơ sở  </span>

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

					<a href="<?php echo base_url('manager/view_report_sale_language'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Xem báo cáo theo Tiếng - Sale </span>

					</a>

				</li>
                
            </ul>
        </li>

		<li>
			<a href="#homeSubmenu_4" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/report.png">
				<span>Báo Cáo Lớp Học</span>
			</a>
			<ul class="collapse list-unstyled" id="homeSubmenu_4">
				<li>

					<a href="<?php echo base_url('manager/view_report_class_study'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Xem báo cáo lớp học</span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_revenue_class'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Báo cáo thông tin lớp học</span>

					</a>

				</li>

			</ul>
		</li>

		<li>
			<a href="#homeSubmenu_5" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/report.png">
				<span>Báo Cáo CSKH</span>
			</a>
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
		</li>

		<li>
			<a href="#homeSubmenu_compare" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/report.png">
				<span>Bảng so sánh hiệu quả</span>
			</a>
			<ul class="collapse list-unstyled" id="homeSubmenu_compare">
				<li>

					<a href="<?php echo base_url('manager/view_report_compare_source'); ?>">

						<img src="<?php echo base_url(); ?>public/images/view-all.png" alt="">

						<span> Bảng so sánh các nguồn </span>

					</a>

				</li>

				<li>

					<a href="<?php echo base_url('manager/view_report_compare_sale'); ?>">

						<img src="<?php echo base_url(); ?>public/images/view-all.png" alt="">

						<span> Bảng so sánh các sale </span>

					</a>

				</li>

			</ul>
		</li>

        <li>
            <a href="#homeSubmenu_6" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
                <span>Thêm contact</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_6">

<!--                <li>-->
<!---->
<!--                    <a class="add-new-contact-modal" href="--><?php //echo base_url('quan-ly/them-contact.html'); ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/add-contact.png"> -->
<!---->
<!--                        <span> Thêm mới contact </span>-->
<!--    -->
<!--                    </a>-->
<!---->
<!--                </li>-->

                <li>
                    <a href="<?php echo base_url('manager/them-contact-file-excel.html');?>">
                        <img src="<?php echo base_url(); ?>public/images/courses.png">
                        <span>Tải file contacts</span>
                    </a>
                </li>

				<li>
					<a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">
						<img src="<?php echo base_url(); ?>public/images/add-contact.png">
						<span> Thêm mới contact </span>
					</a>
				</li>

            </ul>
        </li>

		<li>
			<a href="<?php echo base_url('staff_managers/class_study'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Lịch khai giảng </span>
			</a>
		</li>

        <li>
			<a href="<?php echo base_url('staff_managers/level_language'); ?>">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span> Quản lý Khóa học </span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url('student/cost_branch'); ?>">
				<img src="<?php echo base_url(); ?>public/images/add-contact.png">
				<span> Thống kê chi tiêu tại cơ sở </span>
			</a>
		</li>


		<li>

			<a href="<?php echo base_url('sale/view_history_call'); ?>">

				<img src="<?php echo base_url(); ?>public/images/view-all.png">

				<span> Lịch sử cuộc gọi </span>

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
