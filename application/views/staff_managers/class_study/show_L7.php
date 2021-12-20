<div class="modal fade show_L7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thống kê L7</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tổng sĩ số</th>
                                <th>Bảo lưu</th>
                                <th>Bỏ học</th>
                                <th>Chuyển lớp</th>
                                <th>Kết thúc khóa học</th>
                                <th>Đăng ký lên</th>
                                <th>Tỷ lệ đky lên</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="text-center"><?php echo $L7 ?></td>
                                <td class="text-center"><?php echo $L7_1 ?></td>
                                <td class="text-center"><?php echo $L7_2 ?></td>
                                <td class="text-center"><?php echo $L7_3 ?></td>
                                <td class="text-center"><?php echo $L7_4 ?></td>
                                <td class="text-center"><?php echo $L7_6 ?></td>
                                <td class="text-center"><?php echo ($L7 != 0) ? round($L7_6/$L7, 2) * 100 : 0 ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
