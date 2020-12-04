
<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
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


<!--        <li>-->
<!--            <a href="#homeSubmenu_1" data-toggle="collapse" aria-expanded="false">-->
<!--                <img src="--><?php //echo base_url(); ?><!--public/images/view-all.png">-->
<!--                <span>Quản lý</span>-->
<!--            </a>-->
<!--            <ul class="collapse list-unstyled" id="homeSubmenu_1">-->
<!--                <li>-->
<!---->
<!--                    <a href="--><?php //echo base_url('config/course'); ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/courses.png"> -->
<!---->
<!--                        <span> Cài đặt khóa học </span>-->
<!---->
<!--                    </a>-->
<!---->
<!--                </li>-->
<!---->
<!--                <li>-->
<!---->
<!--                    <a href="--><?php //echo base_url('MANAGERS/teacher'); ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/courses.png"> -->
<!---->
<!--                        <span> Cài đặt giảng viên</span>-->
<!---->
<!--                    </a>-->
<!---->
<!--                </li>-->
<!---->
<!--                <li>-->
<!--        -->
<!--                     <a class="add-new-tvts-modal" href="--><?php //echo base_url('quan-ly/them-tvts.html'); ?><!--"> -->
<!--                    <a href="--><?php //echo base_url('MANAGERS/manager_tvts'); ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/tvts.png"> -->
<!---->
<!--                        <span> Quản lý TVTS </span>-->
<!---->
<!--                    </a>-->
<!---->
<!--                </li>-->
<!--            </ul>-->
<!--        </li>-->
    
        <li>
            <a href="#homeSubmenu_3" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>Báo Cáo</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_3">
                <li>

                    <a href="<?php echo base_url('quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/tvts.png">

                        <span> Xem báo cáo TVTS </span>

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

				<!--

                <li>

                    <a href="<?php echo base_url('manager/view_report_sale_operation'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/L8.jpg"> 

                        <span> Xem báo cáo vận hành TVTS  </span>

                    </a>

                </li>

                <li>

                    <a href="<?php echo base_url('manager/view_report_power_bi'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/power_bi.png">

                        <span> Xem báo cáo Power BI </span>

                    </a>

                </li> -->
                
            </ul>
        </li>

        <li>
            <a href="#homeSubmenu_4" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>Thêm contact</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_4">
                
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
