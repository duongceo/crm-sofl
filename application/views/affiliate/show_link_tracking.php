<?php if ($home_page != '') { ?>
    <i class="fa fa-link" aria-hidden="true"></i><b>Link tracking theo course</b>
    <div class="input-group has-success"> 
        <input type="text" id="id_link_tracking_home" class="form-control" value="<?php echo $home_page ?>">
        <span style="cursor:pointer" class="input-group-addon copy_link_tracking" id_link_tracking="home"><i class="fa fa-files-o" aria-hidden="true"></i></span>
    </div>
    <small>Bạn sẽ nhận ngay hoa hồng 40% cho mỗi đơn hàng thành công.</small><br>
    <small>Học viên sẽ được giảm giá theo chính sách trên lakita.vn</small><br>
    <br>
<?php } ?>
<?php if (!empty($landingpage)) { ?>
    <i class="fa fa-link" aria-hidden="true"></i><b>Link tracking theo Landingpage</b>
    <?php foreach ($landingpage as $value) {
        ?>
        <div class="input-group has-success"> 
            <input type="text" id="id_link_tracking_<?php echo $value['id'] ?>" class="form-control" value="<?php echo $value['url'] ?>">
            <span style="cursor:pointer" class="input-group-addon copy_link_tracking" id_link_tracking="<?php echo $value['id'] ?>"><i class="fa fa-files-o" aria-hidden="true"></i></span>
        </div>
        <?php
    }
    ?>
	<small>Bạn sẽ nhận ngay hoa hồng 40% cho mỗi đơn hàng thành công.</small><br>
    <small>Link này để đặt lên langding page - trang bạn sale khóa học.</small><br>

    <small>Giá khóa học trên các landing page là khác nhau. Bạn sẽ được nhận hoa hồng theo giá trên Landing page.</small><br>

    <small>Học viên được ưu đãi cao hơn khi lakita có chương trình khuyến mãi những ngày lễ tết</small><br>
    <br>
    <?php
}
?>

