
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Thống kê tiền lương giáo viên từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
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
                <th>Lương giáo viên</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($branch as $key_branch => $value_branch) { ?>
                <tr>
                    <td style="background-color: #8aa6c1"> <?php echo $value_branch['name']; ?> </td>
                    <td>
                        <?php echo h_number_format($value_branch['salary_teacher']); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td style="background-color: #3a87ad"><h5>Tổng</h5></td>
                <td><?php echo h_number_format($total) ?></td>
            </tr>
        </tbody>
    </table>
</div>