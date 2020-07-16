
<h4 class="text-center"> Danh sách này bao gồm những campaign tự tạo nhưng chưa xác định thuộc marketer nào. Hãy tích chọn những campaign của bạn và xác nhận </h4>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form action="#" method="POST">
            <table class="table table-bordered table-striped select-sale-active">
                <?php
                foreach ($campaign as $value) {
                    ?>
                    <tr>
                        <td> 
                            <input type="checkbox" name="campaign_id[]" value="<?php echo $value['id']; ?>" /> 
                        </td>
                        <td> <?php echo $value['name']; ?> </td>
                    </tr>
                <?php }
                ?>
            </table>
            <div class="text-center">
                <a href="<?php echo base_url().'marketer/update_link'?>" class="btn btn-warning show_popup">Bỏ qua</a>
                <input type="submit" class="btn btn-success show_popup" value="Lưu lại" />
            </div>
        </form>
    </div>
</div>
