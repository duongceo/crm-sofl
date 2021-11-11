
<div class="container">
    <div class="row">
        <h1 class="text-center">Thống kê lương giáo viên từ ngày <span id="start_date"><?php echo date('d-m-Y', $startDate); ?></span> đến hết ngày <span id="end_date"><?php echo date('d-m-Y', $endDate); ?></span></h1>

        <div class="col-md-8 col-md-offset-2 col-xs-12">
            <form action="#" method="GET" id="action_contact" class="form-inline">
                <?php $this->load->view('common/content/filter'); ?>
            </form>
        </div>

        <div class="clearfix"></div>
        <h1 class="text-center">Tổng lương : <span class="text-primary"><?php echo h_number_format($total_salary) ?></span></h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STK</th>
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
                        <th>Tổng</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($rows as $item) { ?>
                    <tr>
                        <td class="text-center" rowspan="<?php echo count($item['attendance']) ?>"><?php echo $item['bank'] ?></td>
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
                        <td class="text-center" rowspan="<?php echo count($item['attendance']) ?>"><?php echo h_number_format($item['total_paid']) ?></td>
                        <td class="text-center paid_salary">
                            <p class="bg-success"><?php echo $item['attendance'][0]['paid_salary'] ?></p>
                        </td>
                        <td class="text-center text-primary">
                            <button class="btn btn-sm btn-success export_excel" teacher_id="<?php echo $item['id'] ?>" class_study_id="<?php echo $item['attendance'][0]['class_study_id'] ?>">
                                File excel
                            </button>
                            <button class="btn btn-sm btn-warning send_mail_teacher" teacher_id="<?php echo $item['id'] ?>" class_study_id="<?php echo $item['attendance'][0]['class_study_id'] ?>">
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
                                    <td class="text-center paid_salary">
                                        <p class="bg-success"><?php echo $item_attendance['paid_salary'] ?></p>
                                    </td>
                                    <td class="text-center text-primary">
                                        <button class="btn btn-sm btn-success export_excel" teacher_id="<?php echo $item['id'] ?>" class_study_id="<?php echo $item_attendance['class_study_id'] ?>">
                                            File excel
                                        </button>
                                        <button class="btn btn-sm btn-warning send_mail_teacher" teacher_id="<?php echo $item['id'] ?>" class_study_id="<?php echo $item_attendance['class_study_id'] ?>">
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

<script>
    $(document).ready(function() {
        $('.class_study_select').select2({
            width: '100%',
        });
    });
</script>


