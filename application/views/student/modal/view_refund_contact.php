
<div class="modal fadd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog btn-very-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Hoàn học phí </h4>
            </div>

            <div class="modal-body">
                <form action="<?php echo base_url('student/refund_contact') ?>" method="POST" class="form-inline" role="form">
                    <input type="hidden" name="contact_id" value="<?php echo $contact_id ?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-1 table-view-1">
                                <tr>
                                    <td  class="text-right">Ngày rút học phí </td>
                                    <td>
                                        <input type="text" class="form-control datepicker" name="date" style="width: 100%;">
                                    </td>
                                </tr>

                                <tr>
                                    <td  class="text-right">Số tiền hoàn trả</td>
                                    <td>
                                        <input type="text" class="form-control money" name="cost" style="width: 100%;" />
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
                                <tr>
                                    <td class="text-right"> Thông tin ngân hàng </td>
                                    <td>
                                        <select class="form-control selectpicker" name="branch_id">
                                            <option value=""> Chọn cơ sở </option>
                                            <?php foreach ($branch as $key => $value) { ?>
                                                <option value="<?php echo $value['id']; ?>">
                                                    <?php echo $value['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">
                                        Thông tin ngân hàng
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="4" cols="50" name="bank"></textarea>
                                        </div>
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

<script type="text/javascript">
    $('.money').simpleMoneyFormat();
</script>
