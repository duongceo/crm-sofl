
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo lợi nhuận từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
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
                <th>Doanh thu</th>
                <th>Hoàn học phí</th>
                <th>Chi phí cơ sở</th>
                <th>Lương giáo viên</th>
                <th>Chi phí Marketing</th>
                <th>Lợi nhuận</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($branch as $key_branch => $value_branch) { ?>
                <tr>
                    <td style="background-color: #8aa6c1"> <?php echo $value_branch['name']; ?> </td>
                    <td>
                        <?php echo h_number_format($value_branch['RE']); ?>
                    </td>
                    <td>
                        <?php echo h_number_format($value_branch['refund']); ?>
                    </td>
                    <td>
                        <?php echo h_number_format($value_branch['cost_branch']); ?>
                    </td>
                    <td>
                        <?php echo h_number_format($value_branch['salary_teacher']); ?>
                    </td>
                    <td>
                        NAN
                    </td>
                    <td>
                        <?php
                            $profit = (int) $value_branch['RE'] - (int) $value_branch['refund'] - (int) $value_branch['cost_branch'] - (int) $value_branch['salary_teacher'];
                            echo h_number_format($profit);
                        ?>
                    </td>
                </tr>
            <?php } ?>
            <tr style="background-color: #2496ce">
                <td style="background-color: #3a87ad"><h5>Tổng</h5></td>
                <td><h5><?php echo h_number_format($total_re) ?></h5></td>
                <td><h5><?php echo h_number_format($total_refund) ?></h5></td>
                <td><h5><?php echo h_number_format($total_cost_branch) ?></h5></td>
                <td><h5><?php echo h_number_format($total_salary_teacher) ?></h5></td>
                <td><h5><?php echo h_number_format($total_spend_mkt) ?></h5></td>
                <td>
                    <h5>
                        <?php
                            $total_profit = (int) $total_re - (int) $total_refund - (int) $total_cost_branch - (int) $total_salary_teacher - (int) $total_spend_mkt;
                            echo h_number_format($total_profit);
                        ?>
                    </h5>
                </td>
            </tr>
        </tbody>
    </table>
</div>