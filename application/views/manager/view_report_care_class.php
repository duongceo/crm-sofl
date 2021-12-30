
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo trạng thái chăm sóc lớp học từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
    </div>
</div>

<form action="#" method="GET" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/filter'); ?>
</form>

<?php
    $report = array(
        array('Chưa chăm', 'CHUA_CHAM', $CHUA_CHAM),
        array('Đã chăm', 'DA_CHAM', $DA_CHAM),
        array('1 lần', 'LAN_1', $LAN_1),
        array('2 lần', 'LAN_2', $LAN_2),
        array('3 lần', 'LAN_3', $LAN_3),
    );
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped view_report gr4-table">
        <thead>
            <tr>
                <th style="background: none" class="staff_0"></th>
                <?php foreach ($staffs as $value) { ?>
                    <th style="background: #0f846c"  class="staff_<?php echo $value['id']; ?>">
                        <?php echo $value['name']; ?>
                    </th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
        <?php
            foreach ($report as $values) {
                list($name, $value2, $total) = $values;
            ?>
            <tr>
                <td> <?php echo $name; ?> </td>
                <?php foreach ($staffs as $value) { ?>
                    <td>
                        <?php echo $value[$value2]; ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<hr>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo chăm sóc với các lớp dự kiến kết thúc ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped view_report gr4-table">
        <thead>
            <tr>
                <th style="background: none" class="staff_0"></th>
                <?php foreach ($data_end_expected as $key => $value) { ?>
                    <th style="background: #0f846c">
                        <?php echo $key; ?>
                    </th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
            <?php
                foreach ($report as $values) {
                    list($name, $value2, $total) = $values;
                    ?>
                <tr>
                    <td> <?php echo $name; ?> </td>
                    <?php foreach ($data_end_expected as $value) { ?>
                        <td>
                            <?php echo $value[$value2]; ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<hr>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo chăm sóc với các lớp đã kết thúc trong ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped view_report gr4-table">
        <thead>
            <tr>
                <th style="background: none" class="staff_0"></th>
                <?php foreach ($data_end_real as $key => $value) { ?>
                    <th style="background: #0f846c">
                        <?php echo $key; ?>
                    </th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
            <?php
                foreach ($report as $values) {
                    list($name, $value2, $total) = $values;
                    ?>
                    <tr>
                        <td> <?php echo $name; ?> </td>
                        <?php foreach ($data_end_real as $value) { ?>
                            <td>
                                <?php echo $value[$value2]; ?>
                            </td>
                        <?php } ?>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
</div>