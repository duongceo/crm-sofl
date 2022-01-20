
<div class="modal fadd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog btn-very-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Xác nhận đặt lịch giáo viên bản ngữ </h4>
            </div>

            <div class="modal-body">
                <form action="<?php echo base_url('staff_managers/teacher/confirm_order') ?>" method="POST" class="form-inline" role="form">
                    <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-1 table-view-1">
                                <tr>
                                    <td class="text-right">
                                        Xác nhận của phòng đào tạo
                                    </td>
                                    <td>
                                        <input type="checkbox" class="switch_select" name="confirm" value="1" data-off-text="Chưa xác nhận" data-on-text="Đã xác nhận" data-handle-width="100">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
                                <tr>
                                    <td class="text-right">
                                        Có giáo viên không ?
                                    </td>
                                    <td>
                                        <input type="checkbox" class="switch_select" name="has_teacher" value="1" data-off-text="Chưa có" data-on-text="Đã có" data-handle-width="100">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">Giáo viên bản ngữ</td>
                                    <td>
                                        <select class="form-control select_search" name="teacher_id">
                                            <option value="0"> Chọn giáo viên</option>
                                            <?php foreach ($teacher as $key => $value) { ?>
                                                <option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>
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

<script>
    $(".switch_select").bootstrapSwitch();
</script>

<script>
    $(document).ready(function() {
        $('.select_search').select2({
            width: '100%',
        });
    });
</script>