
<!-- sidebar -->

<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
        </div>

    <ul class="list-unstyled components">
        
        <li>
            <a href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url(); ?>public/images/new.png"> 
                <span> Danh sách contact ngày hôm nay (<?php echo $this->L['C3'];?>)</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('marketer/view_all'); ?>">
                <img src="<?php echo base_url(); ?>public/images/view-all.png"> 
                <span> Danh sách toàn bộ contact (<?php echo $this->L['all'];?>)</span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">
                <img src="<?php echo base_url(); ?>public/images/add-contact.png"> 
                <span> Thêm mới contact </span>
            </a>
        </li>
		
		<li>
            <a href="<?php echo base_url('marketer/get_ma_mkt'); ?>">
                <img src="<?php echo base_url(); ?>public/images/add-contact.png"> 
                <span> Nhập chi phí quảng cáo </span>
            </a>
        </li>

        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/compare.png">
                <span>Quản Lý</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">

                <li>
                    <a href="<?php echo base_url('MANAGERS/campaign'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/campaign.png">
                        <span> Quản lý campaign</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('MANAGERS/adset'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/adset.png">
                        <span> Quản lý Adset </span></a>
                </li>
                <li>
                    <a href="<?php echo base_url('MANAGERS/ad'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/qc.png">
                        <span> Quản lý Ad </span></a>
                </li>
                <li>
                    <a href="<?php echo base_url('MANAGERS/link'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/link.png">
                        <span> Quản lý link </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('MANAGERS/landingpage').'?filter_number_records=10'; ?>">
                        <img src="<?php echo base_url(); ?>public/images/landing-page.png">  
                        <span> Quản lý landing page </span>
                    </a>
                </li>
<!--                <li>-->
<!--                    <a href="--><?php //echo base_url('MANAGERS/course'); ?><!--">-->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/courses.png"> -->
<!--                        <span> Cài đặt khóa học </span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                --><?php //if($this->out_of_lakita == 0){ ?>
<!--                <li>-->
<!---->
<!--                    <a href="--><?php //echo base_url('warehouse'); ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/warehouse.png"> -->
<!---->
<!--                        <span> Quản lý Kho email  </span>-->
<!---->
<!--                    </a>-->
<!---->
<!--                </li>-->
<!--                --><?php //} ?>

            </ul>
        </li>

        <li>
            <a href="#homeSubmenu_1" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/dollar.png">
                <span>Báo Cáo</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_1">
                <li>
                    <a href="<?php echo base_url('marketing/view_report_quality_contact'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/quality.png"> 
                        <span>Báo cáo hiệu quả Marketing </span>
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
            </ul>
        </li>

		<?php if ($this->user_id == 15) { ?>
			<li>
				<a href="<?php echo base_url('sale/view_history_call'); ?>">
					<img src="<?php echo base_url(); ?>public/images/view-all.png">
					<span> Lịch sử cuộc gọi </span>
				</a>
			</li>
		<?php } ?>

        <li>
            <a href="<?php echo base_url('home/logout'); ?>">
                <img src="<?php echo base_url(); ?>public/images/logout.png"> 
                <span> Đăng xuất  </span>
            </a>
        </li>

    </ul>

</nav>
