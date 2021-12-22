<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog btn-very-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Chăm sóc lớp học</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('staff_managers/class_study/action_edit_care_class') ?>" method="POST" class="form-inline" role="form">
                    <input type="hidden" name="id" value="<?php echo $class[0]['id']; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-1 table-view-1">
                                <tr>
                                    <td class="text-right">Số lần chăm sóc</td>
                                    <td>
                                        <select class="form-control selectpicker" name='number_care'>
                                            <option value="0">Chưa chăm sóc</option>
                                            <option value="1" <?php echo $class[0]['number_care'] == 1 ? 'selected' : ''; ?>>Chăm sóc lần 1</option>
                                            <option value="2" <?php echo $class[0]['number_care'] == 2 ? 'selected' : ''; ?>>Chăm sóc lần 2</option>
                                            <option value="3"> <?php echo $class[0]['number_care'] == 3 ? 'selected' : ''; ?>Chăm sóc lần 3</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">Gủi phiếu khảo sát</td>
                                    <td>
                                        <select class="form-control selectpicker" name="survey">
                                            <option value="0">Chưa gửi</option>
                                            <option value="1" <?php echo $class[0]['survey'] == 1 ? 'selected' : ''; ?>>Đã gửi</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
                                <tr>
                                    <td class="text-right">Gửi phiếu đánh giá</td>
                                    <td>
                                        <select class="form-control selectpicker" name="rate">
                                            <option value="0" >Chưa gửi</option>
                                            <option value="1" <?php echo $class[0]['rate'] == 1 ? 'selected' : ''; ?>>Lần 1</option>
                                            <option value="2" <?php echo $class[0]['rate'] == 2 ? 'selected' : ''; ?>>Lần 2</option>
                                            <option value="3" <?php echo $class[0]['rate'] == 3 ? 'selected' : ''; ?>>Lần 3</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">Đánh giá tình hình lớp</td>
                                    <td>
                                        <select class="form-control selectpicker" name="class_care_status">
                                            <option value="0">Bình thường</option>
                                            <option value="1" <?php echo $class[0]['class_care_status'] == 1 ? 'selected' : ''; ?> style="background-color: #BE3E41; color: #fff;">Cần đặc biệt chăm sóc</option>
                                            <option value="2" <?php echo $class[0]['class_care_status'] == 2 ? 'selected' : ''; ?> style="background-color: #BF9D60; color: #fff;">Cần theo dõi chăm sóc</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center">Người chăm sóc</td>
                                    <td>
                                        <select class="form-control selectpicker" name="staff_customer_id">
                                            <option value="0">Người chăm sóc</option>
                                            <?php foreach ($staff_customer as $item) { ?>
                                                <option value="<?php echo $item['id'] ?>" <?php echo ($item['id'] == $class[0]['staff_customer_id']) ? 'selected' : ''?>>
                                                    <?php echo $item['name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg" style="width: 130px;">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
