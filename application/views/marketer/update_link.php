<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<h4 class="text-center"> Danh sách này bao gồm những link trachking bạn đã tạo nhưng chưa bổ sung thông tin campaign. Hãy bổ sung và xác nhận </h4>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form action="#" method="POST">
            <table class="table table-bordered table-striped">
                <thead class="table-head-pos">
                    <tr>
                        <td>
                            Link
                        </td>
                        <td>
                            Campaign
                        </td>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($link as $l_value) {
                    ?>
                    <tr>
                        <td> <?php echo $l_value['url']; ?> </td>
                        <td style="min-width:150px">
                            <input type="hidden" value="<?php echo $l_value['id']; ?>" name="link_id_<?php echo $l_value['id']; ?>[link_id]">
                            <select class="form-control campaign_select2" name="link_id_<?php echo $l_value['id']; ?>[campaign_id]">
                                <option value="0"></option>
                                <?php foreach ($campaign as $c_key => $c_value) {
                                    if ($c_value['channel_id'] == $l_value['channel_id']) {?>
                                        <option value="<?php echo $c_value['id']; ?>"><?php echo $c_value['name']; ?></option>
                                    <?php }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
            <div class="text-center">
                <a href="<?php echo base_url() . 'marketer' ?>" class="btn btn-warning show_popup">Bỏ qua</a>
                <input type="submit" class="btn btn-success show_popup" value="Lưu lại" />
            </div>
        </form>
    </div>
</div>
<script> 
$(document).ready(function() {
    $('.campaign_select2').select2({
        width: '100%'
    });
});
</script>