<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo ký vọng doanh thu từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>
    </div>
</div>

<form action="#" method="GET" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/filter'); ?>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped view_report">
        <thead>
            <tr>
                <th style="background: none"></th>
                <?php foreach ($language_study as $item) { ?>
                    <th>
                        <?php echo $item['name']; ?>
                    </th>
                <?php } ?>
                <th style="background-color: #1e5f24">Tổng Cơ Sở</th>
            </tr>
        </thead>

        <tbody>
        <?php
            foreach ($branch as $key => $value) {
                $total_branch = 0;
                ?>
                <tr>
                    <td style="background-color: #8aa6c1"><?php echo $value['name']?></td>
                    <?php
                        foreach ($language_study as $item) {
                            $total_language = 0;
                            $total_branch += $value[$item['id']]['RE'];
                            $total_language += $item['id']['RE'];
                            ?>
                            <td>
                                <?php echo number_format($value[$item['id']]['RE'], 0, ",", "."); ?>
                            </td>
                    <?php } ?>

                    <td style="background-color: #b4cc46e6;"><?php echo number_format($total_branch, 0, ",", ".")?> VNĐ</td>
                </tr>
            <?php } ?>

            <tr style="background-color: #61bcb4f0;">
                <td> Tổng Tiếng </td>
                <?php foreach ($language_study as $item) { ?>
                    <td>
                        <?php echo number_format($item['RE'], 0, ",", "."); ?>
                    </td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</div>