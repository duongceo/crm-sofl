

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
                

                <form style="visibility: hidden;" action="<?php echo base_url() . $controller; ?>/search" class="form-search" method="GET">

                    <input type="text" class="form-control input-navbar-search" name="search_all" placeholder="Tìm mọi thứ...." 

                           value="<?php echo isset($_GET['search_all']) ? $_GET['search_all'] : ''; ?>">

                    <span class="input-group-btn">

                        <button class="btn btn-default btn-navbar-search" type="submit">

                            <span class="glyphicon glyphicon-search"></span>

                        </button>

                    </span>

                </form>

                <li class="dropdown-hover">


                </li>


                <li class="dropdown-hover float-right">

                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                        <img src="<?php echo $this->session->userdata('image_staff'); ?>" alt=""> <?php echo $this->session->userdata('name'); ?> &nbsp;&nbsp;&nbsp;&nbsp;

                        <span class=" fa fa-angle-down"></span>

                    </a>

                </li>

                <a href="<?php echo base_url(); ?>" class="logo pull-right">

                    <img src="<?php echo base_url(); ?>style/img/logo5.png" class="logo-fix">

                </a>


                <!-- <li class="dropdown mega-dropdown dropdown-hover pull-right">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> MENU <span class="caret"></span></a>				

                    <div id="filters" class="dropdown-menu mega-dropdown-menu">
                     
                        <ul class="nav-list list-inline display-flex show_popup">
                            <li>

                                <a href="<?php echo base_url('dai-ly/san-pham.html'); ?>">

                                    <img src="<?php echo base_url(); ?>public/images/L6.png"> 

                                    <span> Sản phẩm  </span>

                                </a>

                            </li>
                            
                            <li>

                                <a href="<?php echo base_url('affiliate/view_all_contact'); ?>">

                                    <img src="<?php echo base_url(); ?>public/images/fee.png"> 

                                    <span> Đơn hàng  </span>

                                </a>

                            </li>
                            
                            <li>

                                <a href="<?php echo base_url('affiliate/view_report'); ?>">

                                    <img src="<?php echo base_url(); ?>public/images/report.png"> 

                                    <span> Báo cáo  </span>

                                </a>

                            </li>
                            

                        </ul>
                        <ul class="nav-list list-inline display-flex show_popup">
                            <li>

                                <a href="<?php echo base_url('home/logout'); ?>">

                                    <img src="<?php echo base_url(); ?>public/images/logout.png"> 

                                    <span> Đăng xuất  </span>

                                </a>

                            </li>
                        </ul>



                    </div>				

                </li> -->

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

            <a href="<?php echo base_url('dai-ly/san-pham.html'); ?>">

                <img src="<?php echo base_url(); ?>public/images/L6.png"> 

                <span> Sản phẩm  </span>

            </a>

        </li>
        
        <li>

            <a href="<?php echo base_url('affiliate/view_all_contact'); ?>">

                <img src="<?php echo base_url(); ?>public/images/fee.png"> 

                <span> Đơn hàng  </span>

            </a>

        </li>
        
        <li>

            <a href="<?php echo base_url('affiliate/view_report'); ?>">

                <img src="<?php echo base_url(); ?>public/images/report.png"> 

                <span> Báo cáo  </span>

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