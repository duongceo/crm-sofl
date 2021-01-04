s
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

                <span> Danh sách contact mới (<?php echo $this->L['L1']; ?>)</span>

            </a>

        </li>

        <li>

            <a href="<?php echo base_url('marketing/view_all'); ?>">

                <img src="<?php echo base_url(); ?>public/images/view-all.png"> 

                <span> Danh sách toàn bộ contact (<?php echo $this->L['all']; ?>)</span>

            </a>

        </li>

        <li>
            <a href="#homeSubmenu_1" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>Quản Lý</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_1">
            
                <li>

                    <a href="<?php echo base_url('MANAGERS/channel'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/channel.png">  

                        <span> Quản lý kênh </span>

                    </a>

                </li>
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

                    <a href="<?php echo base_url('MANAGERS/landingpage').'?filter_number_records=10'; ?>">

                        <img src="<?php echo base_url(); ?>public/images/landing-page.png">  

                        <span> Quản lý landing page </span>

                    </a>

                </li>

<!--                <li>-->
<!---->
<!--                    <a href="--><?php //echo base_url('MANAGERS/marketers'); ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/marketer.png">   -->
<!---->
<!--                        <span> Quản lý Marketer </span> -->
<!---->
<!--                    </a>-->
<!---->
<!--                </li>-->
<!---->
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
    
            </ul>
        </li>
        

        <li>
            <a href="#homeSubmenu_2" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>Báo Cáo</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_2">

                <li>

                    <a href="<?php echo base_url('marketing/view_report_quality_contact'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/quality.png"> 

                        <span> Báo cáo hiệu quả Marketing</span>

                    </a>

                </li>

                <li>

                    <a href="<?php echo base_url('manager/view_report_source'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/report.png">

                        <span> Xem báo cáo theo nguồn </span>

                    </a>

                </li>

				<li>

					<a href="<?php echo base_url('manager/view_report_revenue'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

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

					<a href="<?php echo base_url('marketing/view_table_compare'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Bảng đánh giá </span>

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
