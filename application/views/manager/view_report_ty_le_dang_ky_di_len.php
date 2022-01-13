
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo trạng thái chăm sóc lớp học từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
    </div>
</div>

<form action="#" method="GET" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/filter'); ?>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped view_report gr4-table" style="table-layout: fixed; width: 100%">
        <thead>
            <tr>
                <th style="background: none"></th>
                <?php foreach ($level as $item) { ?>
                    <?php list($name, $value2, $total) = $item; ?>
                    <th>
                        <?php echo $name; ?>
                    </th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($branch as $key_branch => $value_branch) { ?>
                <tr>
                    <td style="background-color: #8aa6c1"> <?php echo $value_branch['name']; ?> </td>
                    <?php foreach ($level as $item) { ?>
                        <?php list($name, $value2, $total) = $item; ?>
                        <td>
                            <?php echo $value_branch[$name]; ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<div>
    <p> Ghi chú: </p>
    - LV0 : 0-40% <br>
    - LV1 : 40-60% <br>
    - LV2 : 60-70% <br>
    - LV3 : 70-80% <br>
    - LV4 : 80-90% <br>
    - LV5 : 90-100% <br>
    - LV6 : 100%
</div>