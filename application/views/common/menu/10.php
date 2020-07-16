<!-- <ul class="nav-list list-inline display-flex">

    <li>

        <a data-filter=".97" href="<?php echo base_url('customer_care'); ?>">

            <img src="<?php echo base_url(); ?>public/images/view-all.png"> 

            <span> Danh sách contact đã thu COD

            </span>

        </a>

    </li>
    <li>

        <a data-filter=".97" href="<?php echo base_url() ?>manager_customer_care/report">

            <img src="<?php echo base_url(); ?>public/images/view-general-report.png"> 

            <span> Báo cáo

            </span>

        </a>

    </li>
</ul>


  
<ul class="nav-list list-inline display-flex">
    <li>

        <a href="<?php echo base_url('home/logout'); ?>">

            <img src="<?php echo base_url(); ?>public/images/logout.png"> 

            <span> Đăng xuất  </span>

        </a>

    </li>
</ul> -->

<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
        </div>

    <ul class="list-unstyled components">
        <li class="active">
            <a href="<?php echo base_url('customer_care'); ?>">Danh sách Contact đã thu COD</a>
        </li>

        <li>
            <a href="<?php echo base_url() ?>manager_customer_care/report">Báo cáo</a>
        </li>

        <li>
            <a href="<?php echo base_url('home/logout'); ?>">Đăng Xuất</a>
        </li>

    </ul>

</nav>
