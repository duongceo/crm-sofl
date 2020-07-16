<!-- ẩn tạm icon dẫn đến chức năng tải file đối soát l7,l8, cước để update chức năng tự động phân contact cho cskh -->

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

                <li class="dropdown-hover float-left">

                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                        <img src="<?php echo $this->session->userdata('image_staff'); ?>" alt=""> <?php echo $this->session->userdata('name'); ?> &nbsp;&nbsp;&nbsp;&nbsp;

                        <span class="fa fa-angle-down"></span>

                    </a>

                    <ul class="dropdown-menu dropdown-usermenu pull-left">

                        <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out pull-left"></i> Đăng xuất</a></li>

                    </ul>

                </li>

                <a href="<?php echo base_url(); ?>" class="logo pull-right">

                    <img src="<?php echo base_url(); ?>style/img/logo5.png" class="logo-fix">

                </a>


                <form action="<?php echo base_url() . $controller; ?>/search" class="form-search" method="GET">

                    <input type="text" class="form-control input-navbar-search" name="search_all" placeholder="Tìm mọi thứ...." 

                           value="<?php echo isset($_GET['search_all']) ? $_GET['search_all'] : ''; ?>">

                    <span class="input-group-btn">

                        <button class="btn btn-default btn-navbar-search" type="submit">

                            <span class="glyphicon glyphicon-search"></span>

                        </button>

                    </span>

                </form>

                <li class="dropdown-hover">

                    <a href="javascript:;" class="noti dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="position: relative"> 

                        <i class="fa fa-volume-control-phone" aria-hidden="true"></i> &nbsp;

                        Contact cần gọi lại <sup> <span class="badge bg-red" id="num_noti"></span> </sup>

                    </a>

                    <ul class="dropdown-menu" id="noti_contact_recall">

                    </ul>

                </li>
                

            </ul>

        </nav>

    </div>

</div>

<!-- /top navigation -->

<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
        </div>

    <ul class="list-unstyled components">

        <li>
            <a href="#homeSubmenu_1" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>Danh sách contact</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_1">
                
                <li>

                    <a href="<?php echo base_url(); ?>">

                        <img src="<?php echo base_url(); ?>public/images/L6.png"> 

                        <span> Danh sách contact đồng ý mua  (<?php echo $this->L['L6']; ?>)</span>

                    </a>

                </li>

                <li>

                    <a href="<?php echo base_url('cod/contact-dang-giao-hang.html'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/pending.png"> 

                        <span>  Contact đang giao hàng  (<?php echo $this->L['pending']; ?>)</span>

                    </a>

                </li>

                <li>

                    <a href="<?php echo base_url('cod/contact-chuyen-khoan.html'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/banking.png"> 

                        <span> Contact chuyển khoản  (<?php echo $this->L['transfer']; ?>) </span> 

                    </a>

                </li>
				
				<li>
                    <a href="<?php echo base_url('cod/contact-da-nhan-hang.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/pending.png"> 
                        <span>  Contact đã nhận hàng  (<?php echo $this->L['receive']; ?>) </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('cod/contact-da-cham-soc-hom-nay.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/pending.png"> 
                        <span>  Contact đã chăm sóc hôm nay  (<?php echo $this->L['care_today']; ?>) </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('cod/contact-can-cham-soc.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/pending.png"> 
                        <span>  Contact cần chăm sóc  (<?php echo $this->L['call_back']; ?>) </span>
                    </a>
                </li>

                <li>

                    <a href="<?php echo base_url('cod/xem-tat-ca-contact.html'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/view-all.png"> 

                        <span> Danh sách toàn bộ contact  (<?php echo $this->L['all']; ?>) </span>

                    </a>

                </li>

            </ul>
        </li>         


        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>File đối soát Viettel</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="<?php echo base_url('cod/tai-file-doi-soat-l7.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/compare.png"> 
                        <span> Tải file đối soát Viettel L7   </span> 
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cod/tai-file-doi-soat-l8.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/L8.png"> 
                        <span> Tải file đối soát Viettel L8 </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('cod/tai-file-doi-soat-cuoc.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/fee.png"> 
                        <span> Tải file cước phí COD </span>
                    </a>
                </li>

                <li>

                    <a href="<?php echo base_url('cod/tracking'); ?>">

                        <img src="<?php echo base_url(); ?>public/images/tracking.png"> 

                        <span> Theo dõi đơn hàng Viettel </span> 

                    </a>

                </li>
                
            </ul>
        </li>

        
        <li>
            <a href="#homeSubmenu_2" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/report.png">
                <span>File đối soát VNPOST</span>
            </a>
            <ul class="collapse list-unstyled" id="homeSubmenu_2">
                
                <li>
                    <a href="<?php echo base_url('cod/tai-file-doi-soat-l8-vnpost.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/L8.png"> 
                        <span> Tải file đối soát VNPOST L8 </span>
                    </a>
                </li>
                
            </ul>
        </li>

        <li>

            <a href="<?php echo base_url('cod/report_cod_operation'); ?>">

                <img src="<?php echo base_url(); ?>public/images/fee.png"> 

                <span> Xem báo cáo COD  </span>

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