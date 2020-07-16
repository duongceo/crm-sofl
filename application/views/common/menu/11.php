<!-- <ul class="nav-list list-inline display-flex">

    <li>

        <a data-filter=".97" href="<?php echo base_url() ?>manager_customer_care/report">

            <img src="<?php echo base_url(); ?>public/images/view-general-report.png"> 

            <span> Báo cáo

            </span>

        </a>

    </li>
    <li>

        <a href="<?php echo base_url('MANAGERS/teacher'); ?>">

            <img src="<?php echo base_url(); ?>public/images/courses.png"> 

            <span> Cài đặt giảng viên</span>

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
</ul>
 -->

<nav id="sidebar">
    <div id="dismiss">
        <i class="glyphicon glyphicon-arrow-left"></i>
    </div>

        <div class="sidebar-header">
            <h3>Menu :))</h3>
        </div>

    <ul class="list-unstyled components">
        <li>
            <a href="<?php echo base_url() ?>manager_customer_care/report">
                <img src="<?php echo base_url(); ?>public/images/view-general-report.png">  
                <span> Báo Cáo</span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url() ?>manager_customer_care/report_operation_bi">
                <img src="<?php echo base_url(); ?>public/images/power_bi.png">  
                <span> Báo Cáo Vận Hành BI</span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url('MANAGERS/teacher'); ?>">
                <img src="<?php echo base_url(); ?>public/images/courses.png"> 
                <span> Cài đặt giảng viên</span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url('MANAGERS/course'); ?>">
                <img src="<?php echo base_url(); ?>public/images/courses.png"> 
                <span> Cài đặt khóa học </span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url('home/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i>  Đăng Xuất</a>
        </li>

    </ul>

</nav>
