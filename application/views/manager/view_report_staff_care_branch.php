
<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Báo cáo tư vấn tuyển sinh từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

    </div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

    <?php $this->load->view('common/content/filter'); ?>

</form>
<div class="table-responsive">

    <table class="table table-bordered table-striped view_report gr4-table">

        <thead>

            <tr>

                <th style="background: none" class="staff_0"></th>

                <?php foreach ($staffs as $value) {

                    if ($value['NHAN'] > 0) { ?>

                    <th style="background: #0f846c"  class="staff_<?php echo $value['id']; ?>">

                        <?php echo $value['name']; ?>

                    </th>

                    <?php } ?>

                <?php } ?>

                <th class="staff_sum">

                    Tổng

                </th>

            </tr>

        </thead>

        <tbody>

        <?php

        $report = array(
            array('Nhận', 'NHAN', $NHAN),
            array('Chưa gọi', 'CHUA_GOI', $CHUA_GOI),
            array('Xử Lý', 'XU_LY', $XU_LY),
            array('Nghe Máy', 'NGHE_MAY', $NGHE_MAY),
            array('Ko Nghe Máy', 'KHONG_NGHE_MAY', $KHONG_NGHE_MAY),
            array('Contact chết', 'LC', $LC),
            array('L1', 'L1', $L1),
            array('L2', 'L2', $L2),
            array('L3', 'L3', $L3),
            array('L4', 'L4', $L4),
            array('L5', 'L5', $L5),
            array('L6', 'L6', $L6),
            array('L7', 'L7', $L7),
            array('L8', 'L8', $L8),
            array('Doanh Thu', 'RE', h_number_format($RE)),

        );

        foreach ($report as $values) {

            list($name, $value2, $total) = $values;

            ?>

            <tr <?php if (in_array($value2, array('RE', 'L5', 'L3'))) echo 'style="background-color: #6bc5e6"' ?>>

                <td> <?php echo $name; ?> </td>

                <?php foreach ($staffs as $value) {

                    if ($value['NHAN'] > 0) { ?>

                    <td class="show_detail">

                        <?php
                            if ($value2 == 'RE') {
                                echo h_number_format($value[$value2]);
                            } else {
                                echo $value[$value2];
                            }
                        ?>

                    </td>

                    <?php } ?>

                <?php } ?>

                <td class="show_detail">

                    <?php echo $total; ?>

                </td>

            </tr>

            <?php

        }

        ?>

        <?php

        $report2 = array(
            array('Nghe Máy/Xử lý', 'NGHE_MAY', 'XU_LY', ($XU_LY != 0) ? round(($NGHE_MAY / $XU_LY) * 100, 2) : 'NAN', 70),
            array('Ko Nghe Máy/Xử lý', 'KHONG_NGHE_MAY', 'XU_LY', ($XU_LY != 0) ? round(($KHONG_NGHE_MAY / $XU_LY) * 100, 2) : 'NAN', 25),
            array('L2/Xử lý', 'L2', 'XU_LY', ($XU_LY != 0) ? round(($L2 / $XU_LY) * 100, 2) : 'NAN', 40),
            array('L2/Nhận', 'L2', 'NHAN', ($NHAN != 0) ? round(($L2 / $NHAN) * 100, 2) : 'NAN', 40),
            array('L3/Nhận', 'L3', 'NHAN', ($NHAN != 0) ? round(($L3 / $NHAN) * 100, 2) : 'NAN', 35),
            array('L5+L8/Nhận', 'L5', 'NHAN', ($NHAN != 0) ? round((($L5 + $L8)/ $NHAN) * 100, 2) : 'NAN', 25),
        );

        foreach ($report2 as $values) {

            list($name, $tu_so, $mau_so, $total, $limit) = $values;

            ?>

            <tr>

                <td> <?php echo $name; ?> </td>

                <?php foreach ($staffs as $value) {

                    if ($value['NHAN'] > 0) { ?>

                    <td <?php

                    if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

                        echo 'style="background-color: #a71717;color: #fff;"';

                    } else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

                        echo 'style="background-color: #0C812D;color: #fff;"';

                    }

                    ?>>

                        <?php

                        if ($tu_so == 'L5') {

                            echo ($value[$mau_so] != 0) ? round((($value[$tu_so] + $value['L8']) / $value[$mau_so]) * 100, 2) . '%' : 'NAN';

                        } else {

                            echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'NAN';

                        }
                        ?>

                    </td>

                    <?php } ?>

                <?php } ?>

                <td <?php

                if ($total < $limit && $limit > 0) {

                    echo 'style="background-color: #a71717;color: #fff;"';

                } else if ($total >= $limit && $limit > 0) {

                    echo 'style="background-color: #0C812D;color: #fff;"';

                }

                ?>>

                    <?php echo $total . '%'; ?>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>