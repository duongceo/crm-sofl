<!-- <ul class="nav-list list-inline display-flex">

    <li>

        <a data-filter=".97" href="<?php echo base_url(); ?>">

            <img src="<?php echo base_url(); ?>public/images/new.png"> 

            <span> Danh sách contact mới  (<?php echo $this->L['L1']; ?>) </span>

        </a>

    </li>

    <li>

        <a href="<?php echo base_url('tu-van-tuyen-sinh/contact-con-cuu-duoc.html'); ?>">

            <img src="<?php echo base_url(); ?>public/images/can-save.png"> 

            <span>Danh sách contact còn cứu được  (<?php echo $this->L['can_save']; ?>) </span>

        </a>

    </li>

    <li>

        <a href="<?php echo base_url('tu-van-tuyen-sinh/contact-co-lich-hen.html'); ?>">

            <img src="<?php echo base_url(); ?>public/images/call-back.png"> 

            <span> Danh sách contact có lịch hẹn gọi lại  (<?php echo $this->L['has_callback']; ?>) </span>

        </a>

    </li>

</ul>

<ul class="nav-list list-inline display-flex">

    <li>

        <a data-filter=".97" href="<?php echo base_url('tu-van-tuyen-sinh/xem-tat-ca-contact.html'); ?>">

            <img src="<?php echo base_url(); ?>public/images/view-all.png"> 

            <span> Danh sách toàn bộ contact  (<?php echo $this->L['all']; ?>) </span>

        </a>

    </li>

    <li>

        <a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">

            <img src="<?php echo base_url(); ?>public/images/add-contact.png"> 

            <span> Thêm mới contact </span>

        </a>

    </li>

    <li>

        <a href="<?php echo base_url('tu-van-tuyen-sinh/xem-bao-cao.html'); ?>">

            <img src="<?php echo base_url(); ?>public/images/report.png"> 

            <span> Xem báo cáo </span>

        </a>

    </li>

</ul>

<ul class="nav-list list-inline display-flex">

    <li>

        <a href="<?php echo base_url('quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html'); ?>">

            <img src="<?php echo base_url(); ?>public/images/tvts.png"> 

            <span> Xem báo cáo TVTS chi tiết </span>

        </a>

    </li>

    <li>
        <a href="<?php echo base_url('MANAGERS/course'); ?>">
            <img src="<?php echo base_url(); ?>public/images/courses.png"> 
            <span> Cài đặt khóa học </span>
        </a>
    </li>

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
            <a href="<?php echo base_url(); ?>">Danh sách Contact mới (<?php echo $this->L['L1']; ?>)</a>
        </li>

        <li>
            <a href="<?php echo base_url('tu-van-tuyen-sinh/contact-con-cuu-duoc.html'); ?>">Danh sách Contact còn cứu được (<?php echo $this->L['can_save']; ?>)</a>
        </li>

        <li>
            <a href="<?php echo base_url('tu-van-tuyen-sinh/contact-co-lich-hen.html'); ?>">Danh sách Contact có lịch hẹn gọi lại (<?php echo $this->L['has_callback']; ?>)</a>
        </li>

        <li>
            <a href="<?php echo base_url('tu-van-tuyen-sinh/contact-co-lich-hen.html'); ?>">Danh sách tất cả Contact (<?php echo $this->L['all']; ?>)</a>
        </li>

        <li>
            <a href="<?php echo base_url('tu-van-tuyen-sinh/them-contact.html'); ?>">Thêm mới Contact</a>
        </li>
        
        <li>
            <a href="<?php echo base_url('MANAGERS/course'); ?>">Cài đặt khóa học</a>
        </li>

        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Báo Cáo</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="<?php echo base_url('quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html'); ?>">Báo cáo TVTS</a>
                </li>
                <li>
                    <a href="<?php echo base_url('tu-van-tuyen-sinh/xem-bao-cao.html'); ?>">Báo cáo chất lượng</a>
                </li>
                
            </ul>
        </li>

        <li>
            <a href="<?php echo base_url('home/logout'); ?>">Đăng Xuất</a>
        </li>

    </ul>

</nav>


