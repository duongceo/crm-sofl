
<div class="modal fade show_class_own_teacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog btn-very-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Danh sách các lớp của giáo viên đã từng dạy</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped list_contact list_contact_2">
                    <thead class="table-head-pos">
                        <tr>
                            <th>Mã lớp</th>
                            <th>Ngày khai giảng</th>
                            <th>Ngày kết thúc</th>
                            <th>Khung giờ</th>
                            <th>Ngày học</th>
                            <th>Sĩ số</th>
                            <th>Trình độ</th>
                            <th>Lương/Buổi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($class as $item) { ?>
                            <tr class="text-center">
                                <td><?php echo $item['class_study_id'] ?></td>
                                <td><?php echo date('d/m/Y', $item['time_start']) ?></td>
                                <td><?php echo ($item['time_end_real']) ? date('d/m/Y', $item['time_end_real']) : '' ?></td>
                                <td><?php echo $item['day_display'] ?></td>
                                <td><?php echo $item['time_display'] ?></td>
                                <td><?php echo $item['number_student'] ?></td>
                                <td><?php echo $item['level_study_class'] ?></td>
                                <td><?php echo h_number_format($item['salary_per_day']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
