
<div class="container">
    <div class="row">
        <h1 class="text-center">Thống kê lương giáo viên từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?><b class="text-primary"></b></h1>

        <div class="col-md-8 col-md-offset-2 col-xs-12">
            <form action="#" method="GET" id="action_contact" class="form-inline">
                <?php $this->load->view('common/content/filter'); ?>
            </form>
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
                        <td class="text-center text-primary">
                            <a href="" class="btn btn-success">
                                Xuất file excel
                            </a>
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
                                    <td class="text-center text-primary">
                                        <a href="" class="btn btn-success">
                                            Xuất file excel
                                        </a>
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

