<!-- top navigation -->

<div class="top_nav">

    <div class="nav_menu">

        <nav class="" role="navigation">

            <ul class="nav navbar-nav" style="margin: 0;">

                <li class="pull-left">

                    <a href="#" id="sidebarCollapse"><i class="glyphicon glyphicon-align-left"></i> MENU</a>

                </li>

<!--				--><?php //if (isset($this->sub_folder)) {
//					$action = base_url() . $this->sub_folder .'/'. $controller . '/search';
//				} else {
//					$action =  base_url() . $controller . '/search';
//				}
//				?>

                <form action="" class="form-search" method="GET">

                    <input type="text" class="form-control input-navbar-search" name="search_all" placeholder="Tìm mọi thứ...."

                         value="<?php echo isset($_GET['search_all']) ? $_GET['search_all'] : ''; ?>">

                    <span class="input-group-btn" >

                        <button class="btn btn-default btn-navbar-search" type="submit">

                            <span class="glyphicon glyphicon-search"></span>

                        </button>

                    </span>

                </form>

				<?php if (!$this->agent->mobile) { ?>
					<li class="pull-right">

						<a href="javascript:;" class="user-profile">

							<img src="<?php echo base_url(); ?>style/img/logo.png" alt=""> <span> <?php echo $this->session->userdata('name'); ?> </span>

						</a>

					</li>

					<a href="<?php echo base_url(); ?>" class="logo pull-right">

						<img src="<?php echo base_url(); ?>style/img/logo.png" class="logo-fix">

					</a>

                    <?php if ($this->role_id == 12) { ?>
                        <li class="dropdown-hover pull-right" style="margin-right: 10%">

                            <a href="javascript:;" class="noti dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="position: relative">

                                <i class="fa fa-volume-control-phone" aria-hidden="true"></i> &nbsp;

                                Contact cần gọi lại

                                <sup> <span class="badge bg-red" id="num_noti"></span> </sup>

                            </a>

                            <ul class="dropdown-menu" id="noti_contact_recall">

                            </ul>

                        </li>
                    <?php } ?>
				<?php } ?>

            </ul>

        </nav>

    </div>

</div>

<!-- /top navigation -->

<?php $this->load->view('common/menu/'. $this->role_id); ?>

