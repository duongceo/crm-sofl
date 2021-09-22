<div class="modal fade show_mechanism_teacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog btn-very-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nhập cơ chế giáo viên</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('staff_managers/teacher/action_mechanism') ?>" method="POST" class="form-inline" role="form">
                    <input type="hidden" id="class_study_id" name="class_study_id">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-1 table-view-1">
                                <tr>
                                    <td class="text-right">Cơ chế</td>
                                    <td>
                                        <select class="form-control selectpicker" name="mechanism">
                                            <option value="">Cơ chế</option>
                                            <option value="1">Thưởng</option>
                                            <option value="0">Phạt</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">Số tiền</td>
                                    <td>
                                        <input type="number" class="form-control" name="money" />
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
                                <tr>
                                    <td class="text-right">Lý do</td>
                                    <td>
                                        <textarea class="form-control" name="reason" rows="3"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Ngày</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control datetimepicker" name="time_created">
                                        </div><!-- /input-group -->
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
