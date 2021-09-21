
<div class="container">
    <div class="row">
        <h1 class="text-center">Thống kê lương giáo viên từ ngày <span id="start_date"><?php echo date('d-m-Y', $startDate); ?></span> đến hết ngày <span id="end_date"><?php echo date('d-m-Y', $endDate); ?></span></h1>

        <div class="col-md-8 col-md-offset-2 col-xs-12">
            <form action="#" method="GET" id="action_contact" class="form-inline">
                <?php $this->load->view('common/content/filter'); ?>
            </form>
        </div>

        <div class="col-md-10">
            <div class="text-left">
                <a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Nhập thưởng phạt giáo viên</a>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Học tên</th>
                        <th>Mã lớp</th>
                        <th>Ngày KG</th>
<!--                        <th>Ngày KT</th>-->
                        <th>Ngoại ngữ</th>
                        <th>Số buổi dạy</th>
                        <th>Lương/Buổi</th>
                        <th>Tổng lương</th>
                        <th>Phạt</th>
                        <th>Thưởng</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($rows as $item) { ?>
                    <tr>
                        <td class="text-center" rowspan="<?php echo count($item['attendance']) ?>"><?php echo $item['name'] ?></td>
                        <td class="text-center"><?php echo $item['attendance'][0]['class_study_id'] ?></td>
                        <td class="text-center"><?php echo date('d-m-Y', $item['attendance'][0]['time_start']) ?></td>
                        <td class="text-center"><?php echo $item['attendance'][0]['language'] ?></td>
                        <td class="text-center"><?php echo $item['attendance'][0]['lesson_learned'] ?> Buổi</td>
                        <td class="text-center"><?php echo h_number_format($item['attendance'][0]['salary_per_day']) ?></td>
                        <td class="text-center"><?php echo h_number_format($item['attendance'][0]['salary_per_day'] * $item['attendance'][0]['lesson_learned']) ?></td>
                        <td class="text-center">
                            <?php echo h_number_format($item['attendance'][0]['fine']) ?>
                        </td>
                        <td class="text-center">
                            <?php echo h_number_format($item['attendance'][0]['bonus']) ?>
                        </td>
                        <td class="text-center">Chưa trả</td>
                        <td class="text-center text-primary">
                            <button class="btn btn-sm btn-success export_excel" teacher_id="<?php echo $item['id'] ?>" class_id="<?php echo $item['attendance'][0]['class_study_id'] ?>">
                                File excel
                            </button>
                            <button class="btn btn-sm btn-warning send_mail">
                                Gửi mail
                            </button>
                        </td>
                    </tr>
                    <?php
                        if (count($item['attendance']) >= 2) {
                            unset($item['attendance'][0]);
                            foreach ($item['attendance'] as $item_attendance) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $item_attendance['class_study_id'] ?></td>
                                    <td class="text-center"><?php echo date('d-m-Y', $item_attendance['time_start']) ?></td>
                                    <td class="text-center"><?php echo $item_attendance['language'] ?></td>
                                    <td class="text-center"><?php echo $item_attendance['lesson_learned'] ?> Buổi</td>
                                    <td class="text-center"><?php echo h_number_format($item_attendance['salary_per_day']) ?></td>
                                    <td class="text-center"><?php echo h_number_format($item_attendance['salary_per_day'] * $item_attendance['lesson_learned']) ?></td>
                                    <td class="text-center">
                                        <?php echo h_number_format($item_attendance['fine']) ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo h_number_format($item_attendance['bonus']) ?>
                                    </td>
                                    <td class="text-center">Chưa trả</td>
                                    <td class="text-center text-primary">
                                        <button class="btn btn-sm btn-success export_excel" teacher_id="<?php echo $item['id'] ?>" class_id="<?php echo $item_attendance['class_study_id'] ?>">
                                            File excel
                                        </button>
                                        <button class="btn btn-sm btn-warning send_mail">
                                           Gửi mail
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-id" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nhập cơ chế giáo viên</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('staff_managers/teacher/action_mechanism') ?>" method="POST" class="form-inline" role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-1 table-view-1">
                                <tr>
                                    <td class="text-right"> Giáo viên </td>
                                    <td>
                                        <select class="form-control class_study_select" name="teacher_id">
                                            <option value="">Chọn giáo viên</option>
                                            <?php foreach ($teacher as $key => $value) { ?>
                                                <option value="<?php echo $value['id']; ?>">
                                                    <?php echo $value['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right">Lớp</td>
                                    <td>
                                        <select class="form-control class_study_select" name="class_study_id">
                                            <option value="">Mã lớp</option>
                                            <?php foreach ($class_study as $key => $value) { ?>
                                                <option value="<?php echo $value['class_study_id']; ?>">
                                                    <?php echo $value['class_study_id']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
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

                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
                                <tr>
                                    <td class="text-right">Số tiền</td>
                                    <td>
                                        <input type="number" class="form-control" name="money" />
                                    </td>
                                </tr>
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

<script>
    $(document).ready(function() {
        $('.class_study_select').select2({
            width: '100%',
        });
    });
</script>


