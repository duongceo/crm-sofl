
<!-- top navigation -->

<div class="top_nav">

    <div class="nav_menu">

        <nav class="" role="navigation">

            <ul class="nav navbar-nav">

                <li class="pull-left">

                    <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"> MENU <span class="caret"></span></a>                -->

                    <a href="#" id="sidebarCollapse"><i class="glyphicon glyphicon-align-left"></i> MENU</a>

                    <!-- <div id="filters" class="dropdown-menu mega-dropdown-menu">

                        <?php //$this->load->view('common/menu/'. $this->role_id); ?>

                    </div> -->

                    <?php //$this->load->view('common/menu/test.php') ?>

                </li>
                

               <form action="<?php echo base_url() . $controller; ?>/search" class="form-search" method="GET">

                    <input type="text" class="form-control input-navbar-search" name="search_all" placeholder="Tìm mọi thứ...." 

                           value="<?php echo isset($_GET['search_all']) ? $_GET['search_all'] : ''; ?>">

                    <span class="input-group-btn">

                        <button class="btn btn-default btn-navbar-search" type="submit">

                            <span class="glyphicon glyphicon-search"></span>

                        </button>

                    </span>

                </form>

                <li class="dropdown-hover float-right">

                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                        <img src="<?php echo $this->session->userdata('image_staff'); ?>" alt=""> <?php echo $this->session->userdata('name'); ?> &nbsp;&nbsp;&nbsp;&nbsp;

                        <span class=" fa fa-angle-down"></span>

                    </a>
					<!--
                    <ul class="dropdown-menu dropdown-usermenu pull-left">

                        <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out pull-left"></i> Đăng xuất</a></li>

                    </ul>
					-->
                </li>
				
                <a href="<?php echo base_url(); ?>" class="logo pull-right">

                    <img src="<?php echo base_url(); ?>style/img/logo.png" class="logo-fix">

                </a>

				<li class="dropdown-hover pull-right" style="margin-right: 10%">

                    <a href="javascript:;" class="noti dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="position: relative"> 

                        <i class="fa fa-volume-control-phone" aria-hidden="true"></i> &nbsp;

                        Contact cần gọi lại 
						<sup> <span class="badge bg-red" id="num_noti"></span> </sup>

                    </a>

                    <ul class="dropdown-menu" id="noti_contact_recall">

                    </ul>

                </li>

            </ul>

        </nav>

    </div>

</div>

<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
        </div>

    <ul class="list-unstyled components">
		<li>
			<a href="#submenu" data-toggle="collapse" aria-expanded="false">
				<img src="<?php echo base_url(); ?>public/images/view-all.png">
				<span>Danh sách contact</span>
			</a>
			<ul class="collapse list-unstyled" id="submenu">
				<li>
					<a href="<?php echo base_url(); ?>">
						<img src="<?php echo base_url(); ?>public/images/new.png">
						<span> Danh sách contact mới (<?php echo $this->L['L1'];?>) </span>
					</a>
				</li>

				<li>
					<a href="<?php echo base_url('tu-van-tuyen-sinh/contact-con-cuu-duoc.html'); ?>">

						<img src="<?php echo base_url(); ?>public/images/can-save.png">

						<span>Danh sách contact còn cứu được (<?php echo $this->L['can_save'];?>) </span>

					</a>
				</li>

				<li>
					<a href="<?php echo base_url('tu-van-tuyen-sinh/contact-co-lich-hen.html'); ?>">

						<img src="<?php echo base_url(); ?>public/images/call-back.png">

						<span> Danh sách contact có lịch hẹn gọi lại (<?php echo $this->L['has_callback'];?>) </span>

					</a>
				</li>

<!--				<li>-->
<!--					<a href="--><?php //echo base_url('sale/contact_handle_marketer'); ?><!--">-->
<!---->
<!--						<img src="--><?php //echo base_url(); ?><!--public/images/call-back.png">-->
<!---->
<!--						<span> Danh sách contact xử lý với mkt </span>-->
<!---->
<!--					</a>-->
<!--				</li>-->

				<li>
					<a href="<?php echo base_url('tu-van-tuyen-sinh/xem-tat-ca-contact.html'); ?>">

						<img src="<?php echo base_url(); ?>public/images/view-all.png">

						<span> Danh sách toàn bộ contact (<?php echo $this->L['all'];?>) </span>

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
        
<!--        <li>-->
<!--            <a href="--><?php //echo base_url('MANAGERS/course'); ?><!--">-->
<!--                <i class="glyphicon glyphicon-cog"></i>-->
<!--                <span>Cài đặt khóa học</span>-->
<!--            </a>-->
<!--        </li>-->

        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>Báo Cáo</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="<?php echo base_url('quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/tvts.png"> 

                        <span> Xem báo cáo TVTS chi tiết </span>

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

					<a href="<?php echo base_url('manager/view_report_sale_handle'); ?>">

						<img src="<?php echo base_url(); ?>public/images/report.png">

						<span> Báo cáo xử lý contact </span>

					</a>

				</li>
<!--                <li>-->
<!--                    <a href="--><?php //echo base_url('tu-van-tuyen-sinh/xem-bao-cao.html'); ?><!--">-->
<!---->
<!--                        <img src="--><?php //echo base_url(); ?><!--public/images/report.png"> -->
<!---->
<!--                        <span> Xem báo cáo </span>-->
<!---->
<!--                    </a>-->
<!--                </li>-->
                
            </ul>
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

<!-- /top navigation -->
