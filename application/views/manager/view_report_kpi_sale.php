
<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Báo cáo tỷ lệ kpi sale theo ngoại ngữ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

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

            <?php foreach ($language as $value) { ?>

                <th style="background-color: #5189ae"  class="staff_<?php echo $value['id']; ?>">

                    <?php echo $value['name']; ?>

                </th>

            <?php } ?>

            <th class="staff_sum">

                Tổng

            </th>

        </tr>

        </thead>

        <tbody>

        <?php

        $report = array(
            array('Nhận', 'NHAN', $NHAN_L),
            array('Chưa gọi', 'CHUA_GOI', $CHUA_GOI_L),
            array('Xử Lý', 'XU_LY', $XU_LY_L),
            array('Nghe Máy', 'NGHE_MAY', $NGHE_MAY_L),
            array('Ko Nghe Máy', 'KHONG_NGHE_MAY', $KHONG_NGHE_MAY_L),
            array('Contact chết', 'LC', $LC_L),
            array('L1', 'L1', $L1_L),
            array('L2', 'L2', $L2_L),
            array('L3', 'L3', $L3_L),
            array('L4', 'L4', $L4_L),
            array('L5', 'L5', $L5_L),
            array('L6', 'L6', $L6_L),
            array('L7', 'L7', $L7_L),
            array('L8', 'L8', $L8_L),
        );

        foreach ($report as $values) {

            list($name, $value2, $total) = $values;

            ?>

            <tr>

                <td> <?php echo $name; ?> </td>

                <?php foreach ($language as $value) { ?>

                    <td>

                        <?php echo $value[$value2]; ?>

                    </td>

                <?php } ?>

                <td class="show_detail">

                    <?php echo $total; ?>

                </td>

            </tr>

        <?php } ?>

        <?php

        $report2 = array(
            array('Nghe Máy/Xử lý', 'NGHE_MAY', 'XU_LY', ($XU_LY_L != 0) ? round(($NGHE_MAY_L / $XU_LY_L) * 100, 2) : 'NAN', 70),
            array('Ko Nghe Máy/Xử lý', 'KHONG_NGHE_MAY', 'XU_LY', ($XU_LY_L != 0) ? round(($KHONG_NGHE_MAY_L / $XU_LY_L) * 100, 2) : 'NAN', 25),
            array('L2/Xử lý', 'L2', 'XU_LY', ($XU_LY_L != 0) ? round(($L2_L / $XU_LY_L) * 100, 2) : 'NAN', 40),
            array('L3/Nhận', 'L3', 'NHAN', ($NHAN_L != 0) ? round(($L3_L / $NHAN_L) * 100, 2) : 'NAN', 35),
            array('L5/Nhận', 'L5', 'NHAN', ($NHAN_L != 0) ? round(($L5_L / $NHAN_L) * 100, 2) : 'NAN', 20),
        );

        foreach ($report2 as $values) {

            list($name, $tu_so, $mau_so, $total, $limit) = $values;

            ?>

            <tr>

                <td> <?php echo $name; ?> </td>

                <?php foreach ($language as $value) { ?>

                    <td <?php

                    if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

                        echo 'style="background-color: #a71717;color: #fff;"';

                    } else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

                        echo 'style="background-color: #0C812D;color: #fff;"';

                    }

                    ?>>

                        <?php

                        echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'NAN';

                        ?>

                    </td>

                    <?php

                }

                ?>

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