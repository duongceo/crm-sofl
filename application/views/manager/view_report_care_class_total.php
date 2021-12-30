
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
    <table class="table table-bordered table-striped view_report gr4-table" style="table-layout: fixed; width: 100%">
        <thead>
            <tr>
                <th style="background: none"></th>
                <?php foreach ($language_study as $item) { ?>
                    <th colspan="<?php echo count($report) ?>">
                        <?php echo $item['name']; ?>
                    </th>
                <?php } ?>
            </tr>

            <tr>
                <th style="background: none"></th>
                <?php
                foreach ($language_study as $item) {
                    foreach ($report as $value) {
                        list($name, $value2, $total) = $value;
                        ?>
                        <th style="background-color: #1b6d85">
                            <?php echo $name; ?>
                        </th>
                    <?php } ?>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($branch as $key_branch => $value_branch) { ?>
                <tr>
                    <td style="background-color: #8aa6c1"> <?php echo $key_branch; ?> </td>
                    <?php foreach ($language_study as $value_language) { ?>
                        <td><?php echo $value_branch[$value_language['name']]['CHUA_CHAM']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['DA_CHAM']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['LAN_1']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['LAN_2']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['LAN_3']; ?></td>
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
    <table class="table table-bordered table-striped view_report gr4-table" style="table-layout: fixed; width: 100%">
        <thead>
        <tr>
            <th style="background: none"></th>
            <?php foreach ($language_study as $item) { ?>
                <th colspan="<?php echo count($report) ?>">
                    <?php echo $item['name']; ?>
                </th>
            <?php } ?>
        </tr>

        <tr>
            <th style="background: none"></th>
            <?php
            foreach ($language_study as $item) {
                foreach ($report as $value) {
                    list($name, $value2, $total) = $value;
                    ?>
                    <th style="background-color: #1b6d85">
                        <?php echo $name; ?>
                    </th>
                <?php } ?>
            <?php } ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($data_end_expected as $key_branch => $value_branch) { ?>
            <tr>
                <td style="background-color: #8aa6c1"> <?php echo $key_branch; ?> </td>
                <?php foreach ($language_study as $value_language) { ?>
                    <td><?php echo $value_branch[$value_language['name']]['CHUA_CHAM']; ?></td>
                    <td><?php echo $value_branch[$value_language['name']]['DA_CHAM']; ?></td>
                    <td><?php echo $value_branch[$value_language['name']]['LAN_1']; ?></td>
                    <td><?php echo $value_branch[$value_language['name']]['LAN_2']; ?></td>
                    <td><?php echo $value_branch[$value_language['name']]['LAN_3']; ?></td>
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
    <table class="table table-bordered table-striped view_report gr4-table" style="table-layout: fixed; width: 100%">
        <thead>
            <tr>
                <th style="background: none"></th>
                <?php foreach ($language_study as $item) { ?>
                    <th colspan="<?php echo count($report) ?>">
                        <?php echo $item['name']; ?>
                    </th>
                <?php } ?>
            </tr>

            <tr>
                <th style="background: none"></th>
                <?php
                foreach ($language_study as $item) {
                    foreach ($report as $value) {
                        list($name, $value2, $total) = $value;
                        ?>
                        <th style="background-color: #1b6d85">
                            <?php echo $name; ?>
                        </th>
                    <?php } ?>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data_end_real as $key_branch => $value_branch) { ?>
                <tr>
                    <td style="background-color: #8aa6c1"> <?php echo $key_branch; ?> </td>
                    <?php foreach ($language_study as $value_language) { ?>
                        <td><?php echo $value_branch[$value_language['name']]['CHUA_CHAM']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['DA_CHAM']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['LAN_1']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['LAN_2']; ?></td>
                        <td><?php echo $value_branch[$value_language['name']]['LAN_3']; ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>