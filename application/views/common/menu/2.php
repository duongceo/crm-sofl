
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
                        <img src="<?php echo base_url(); ?>public/images/L6.png"> 
                        <span> Danh sách contact đồng ý mua  </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cod/contact-dang-giao-hang.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/pending.png"> 
                        <span>  Contact đang giao hàng  </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('cod/contact-chuyen-khoan.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/banking.png"> 
                        <span> Contact chuyển khoản  </span> 
                    </a>
                </li>
				
				<li>
                    <a href="<?php echo base_url('cod/contact-da-nhan-hang.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/pending.png"> 
                        <span>  Contact đã nhận hàng  </span>
                    </a>
                </li>

                <li>
                    <a data-filter=".97" href="<?php echo base_url('cod/xem-tat-ca-contact.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png"> 
                        <span> Danh sách toàn bộ contact  </span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="<?php echo base_url('cod/tracking'); ?>">
                <img src="<?php echo base_url(); ?>public/images/tracking.png"> 
                <span> Theo dõi đơn hàng Viettel </span> 
            </a>
        </li>

        <li>
            <a href="#doi-soat" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span>File đối soát</span>
            </a>
            <ul class="collapse list-unstyled" id="doi-soat">
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
                    <a href="<?php echo base_url('cod/tai-file-doi-soat-l8-vnpost.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/L8.png">
                        <span> Tải file đối soát VNPOST L8 </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url('cod/tai-file-doi-soat-cuoc.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/fee.png"> 
                        <span> Tải file cước phí COD </span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#ket-qua-doi-soat" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span>Kết quả đối soát</span>
            </a>
            <ul class="collapse list-unstyled" id="ket-qua-doi-soat">
                <li>
                    <a href="<?php echo base_url('cod/doi-soat-l8/xem-tat-ca.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png"> 
                        <span> Danh sách tất cả KQ đối soát L8 </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cod/doi-soat-l8.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/unsave.png"> 
                        <span> Kết quả đối soát chưa lưu (L8)</span> 
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cod/doi-soat-l8/ket-qua-doi-soat-hom-nay.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/today.png"> 
                        <span> Danh sách KQ đối soát ngày hôm nay (L8)</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#cuoc-doi-soat" data-toggle="collapse" aria-expanded="false">
                <img src="<?php echo base_url(); ?>public/images/view-all.png">
                <span>Cước đối soát</span>
            </a>
            <ul class="collapse list-unstyled" id="cuoc-doi-soat">
                <li>
                    <a href="<?php echo base_url('cod/doi-soat-cod/xem-tat-ca.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/view-all.png"> 
                        <span> Danh sách tất cả KQ đối soát cước (cước)</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cod/doi-soat-cuoc.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/unsave.png"> 
                        <span> Kết quả đối soát chưa lưu  (cước)</span> 
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('cod/doi-soat-cod/ket-qua-doi-soat-hom-nay.html'); ?>">
                        <img src="<?php echo base_url(); ?>public/images/today.png"> 
                        <span> Danh sách KQ đối soát ngày hôm nay (cước)</span>
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
