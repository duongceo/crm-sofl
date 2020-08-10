<!-- top navigation -->

<div class="top_nav">

    <div class="nav_menu">

        <nav class="" role="navigation">

            <ul class="nav navbar-nav">

                <li class="pull-left">

                    <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"> MENU <span class="caret"></span></a>                -->

                    <a href="#" id="sidebarCollapse"><i class="glyphicon glyphicon-align-left"></i> MENU</a>

                    <!-- <div id="filters" class="dropdown-menu mega-dropdown-menu">

                    </div> -->

                    <?php //$this->load->view('common/menu/test.php') ?>

                </li>

                <!-- <li class="dropdown mega-dropdown dropdown-hover pull-right"> -->

<!--				--><?php //if (isset($this->sub_folder)) {
//					$action = base_url() . $this->sub_folder .'/'. $controller . '/search';
//				} else {
//					$action =  base_url() . $controller . '/search';
//				}
//				?>

                <form action="" class="form-search" method="GET">

                    <input style="width: 60%" type="text" class="form-control input-navbar-search" name="search_all" placeholder="Tìm mọi thứ...." 

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

<!--                        <span class=" fa fa-angle-down"></span>-->

                    </a>

                </li>

                <a href="<?php echo base_url(); ?>" class="logo pull-right">

                    <img src="<?php echo base_url(); ?>style/img/logo.png" class="logo-fix">

                </a>

            </ul>

        </nav>

    </div>

</div>

<!-- /top navigation -->

<?php $this->load->view('common/menu/'. $this->role_id); ?>

