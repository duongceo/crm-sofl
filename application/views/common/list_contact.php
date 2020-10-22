
<?php if(isset($progressType)) { ?>

<div class="container">

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <h1 class="text-center text-uppercase red margintop20 marginbottom20"> <?php echo $progressType?> </h1>

        <?php //print_arr($progress)?>

            <?php foreach ($progress['progressbar'] as $team) { ?>

                <div class="row">

                    <div class="col-md-4 text-right text-uppercase margintop5">

                        <?php echo $team['name'] . ' (' . $team['count'] . '/' . $team['kpi'] . ') (' . $team['type'] . ')'; ?>

                    </div>

                    <div class="col-md-6">

                        <div class="progress skill-bar">

                            <div class="progress-bar progress-bar-striped active <?php echo getProgressBarClass($team['progress']); ?>" role="progressbar" aria-valuenow="<?php echo $team['progress'] ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $team['progress'].'%' ?>">

                                <span class="skill text-uppercase"> 

                                    <?php// echo $marketer['name'] . ' (' . $marketer['totalC3'] . '/' . $marketer['targets'] . ')'; ?> 

                                    <?php echo $team['progress'] ?>% 

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

    <?php if (in_array($this->role_id, array(3, 12, 5, 7))) { ?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h3 class="text-center marginbottom20">Doanh thu</h3>
			</div>
		</div>

    	<h4>Học viên mới</h4>
        <div class="row">
            <?php foreach ($language_study as $key => $value) {?>
                <div class="col-md-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading"><?php echo $value['name']; ?></div>
                        <div class="panel-body" style="color: #006cf1"><?php echo h_number_format($progress['new'][$value['language_id']][0]['RE']) ?></div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-md-3">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">Tổng</div>
                    <div class="panel-body" style="color: #006cf1"><?php echo h_number_format($progress['total_new']); ?></div>
                </div>
            </div>
        </div>

        <h4>Học viên cũ</h4>
        <div class="row">
            <?php foreach ($language_study as $key => $value) {?>
                <div class="col-md-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading"><?php echo $value['name']; ?></div>
                        <div class="panel-body" style="color: #006cf1"><?php echo h_number_format($progress['old'][$value['language_id']][0]['RE']) ?></div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-md-3">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">Tổng</div>
                    <div class="panel-body" style="color: #006cf1"><?php echo h_number_format($progress['total_old']); ?></div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>

<?php } ?>

<?php if (isset($progress_sale)) { ?>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h3 class="text-center marginbottom20">Tiến độ công việc hôm nay</h3>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-primary text-center">
					<div class="panel-heading">Xử lý Contact L1</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								<div class="panel panel-danger text-center">
									<div class="panel-heading">Tổng</div>
									<div class="panel-body">
										<button class="btn btn-success btn-block contact-sale-have-to-call" type="L1"><?php echo $progress_sale['L1'];?></button>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="panel panel-danger text-center">
									<div class="panel-heading">Đã gọi</div>
									<div class="panel-body">
										<button class="btn btn-warning btn-block"><?php echo $progress_sale['L1_XULY'];?></button>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="panel panel-danger text-center">
									<div class="panel-heading">Tiến độ</div>
									<div class="panel-body">
										<button class="btn btn-warning btn-block"><?php echo round($progress_sale['L1_XULY'] / $progress_sale['L1'] * 100, 2);?> %</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-primary text-center">
					<div class="panel-heading">Xử lý Contact Không Nghe Máy</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								<div class="panel panel-danger text-center">
									<div class="panel-heading">Lần 1</div>
									<div class="panel-body">
										<button class="btn btn-success btn-block contact-sale-have-to-call" type="KNM_LAN_1"><?php echo $progress_sale['KNM_LAN_1'];?></button>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="panel panel-danger text-center">
									<div class="panel-heading">Lần 2</div>
									<div class="panel-body">
										<button class="btn btn-success btn-block contact-sale-have-to-call" type="KNM_LAN_2"><?php echo $progress_sale['KNM_LAN_2'];?></button>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="panel panel-danger text-center">
									<div class="panel-heading">Lần 3</div>
									<div class="panel-body">
										<button class="btn btn-success btn-block contact-sale-have-to-call" type="KNM_LAN_3"><?php echo $progress_sale['KNM_LAN_3'];?></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-primary text-center">
					<div class="panel-heading">Xử lý Contact L3</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<div class="panel panel-danger text-center">
									<div class="panel-heading">Tổng</div>
									<div class="panel-body">
										<button class="btn btn-success btn-block contact-sale-have-to-call" type="L3"><?php echo $progress_sale['L3'];?></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-primary text-center">
					<div class="panel-heading">Xử lý Contact L2</div>
					<div class="panel-body">
						<div class="col-md-8 col-md-offset-2">
							<div class="panel panel-danger text-center">
								<div class="panel-heading">Tổng</div>
								<div class="panel-body">
									<button class="btn btn-success btn-block contact-sale-have-to-call" type="L2"><?php echo $progress_sale['L2'];?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('common/modal/sale_have_to_call'); ?>
<?php } ?>

<?php //if (isset($sale_call_process)) { ?>
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-md-8 col-md-offset-2">-->
<!--                <div class="table-responsive">-->
<!--                    <table class="table table-bordered table-expandable table-striped">-->
<!--                        <thead>-->
<!--                            <tr>-->
<!--                                <th>Tổng contact cần gọi</th>-->
<!--                                <th>Contact mới</th>-->
<!--                                <th>Contact cần gọi lại</th>-->
<!--                            </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                            <tr>-->
<!--                                <td style="text-align: center" class="center" type="total">--><?php //echo $sale_call_process['have_call']['total_have_call_contact'] ?><!--</td>-->
<!--                                <td style="cursor:pointer; text-align: center" class="center contact-sale-have-to-call" type="new">--><?php //echo $sale_call_process['have_call']['new_contact'] ?><!--</td>-->
<!--                                <td style="cursor:pointer; text-align: center" class="center contact-sale-have-to-call" type="call_back">--><?php //echo $sale_call_process['have_call']['recall_contact'] ?><!--</td>-->
<!--                            </tr>-->
<!--                        <tbody>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row">-->
<!--            <div class="col-md-8 col-md-offset-2">-->
<!--                <div class="table-responsive">-->
<!--                    <table class="table table-bordered table-expandable table-striped">-->
<!--                        <thead>-->
<!--                            <tr>-->
<!--                                <th colspan="2">Contact còn cứu được</th>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <th>Đã gọi dưới 3 lần</th>-->
<!--                                <th>Đã gọi trên 3 lần</th>-->
<!--                            </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                            <tr>-->
<!--                                <td style="cursor:pointer; text-align: center" class="center contact-sale-have-to-call" type="less_3">--><?php //echo $sale_call_process['can_save']['call_less_3'] ?><!--</td>-->
<!--                                <td style="cursor:pointer; text-align: center" class="center contact-sale-have-to-call" type="more_3">--><?php //echo $sale_call_process['can_save']['call_more_3'] ?><!--</td>-->
<!--                            </tr>-->
<!--                        <tbody>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php //} ?>

<?php if (isset($progressType_mkt)) { ?>
	<div class="container">

		<div class="row">

			<div class="col-md-10 col-md-offset-1">

				<h1 class="text-center text-uppercase red margintop20"> <?php echo $progressType_mkt ?> <?php echo round(($C3Team / $C3Total) * 100, 1) ?>% (<?php echo $C3Team . '/' . $C3Total ?>)</h1>

				<!-- Skill Bars -->

				<?php foreach ($marketers as $marketer) { ?>

					<div class="row">

						<div class="col-md-4 text-right text-uppercase margintop5">

							<?php echo $marketer['name'] . ' (' . $marketer['totalC3'] . '/' . $marketer['targets'] . ')'; ?>

						</div>

						<div class="col-md-6">

							<div class="progress skill-bar ">

								<div class="progress-bar progress-bar-striped active <?php echo getProgressBarClass($marketer['progress']); ?>" role="progressbar" aria-valuenow="<?php echo $marketer['progress'] ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $marketer['progress'].'%' ?>">

									<span class="skill text-uppercase">

										<?php // echo $marketer['name'] . ' (' . $marketer['totalC3'] . '/' . $marketer['targets'] . ')'; ?>

										<?php echo $marketer['progress'] ?>%

									</span>

								</div>

							</div>

						</div>

					</div>

				<?php } ?>

			</div>

		</div>

	</div>

<?php } ?>

<div class="row total">

     <div class="col-md-10 col-md-offset-1">

<!--        <h3 class="text-center marginbottom20"> --><?php //echo $titleListContact; ?><!-- <sup> <span class="badge bg-red"> --><?php //echo $total_contact; ?><!-- </span> </sup></h3>-->
        <h3 class="text-center marginbottom20"> <?php echo (isset($progressType_mkt)) ? $titleListContact_mkt : $titleListContact ; ?> <sup> <span class="badge bg-red"> <?php echo $total_contact; ?> </span> </sup></h3>

    </div>

</div>

<form action="<?php echo base_url() . $actionForm; ?>" method="POST" id="action_contact" 

      class="form-inline <?php echo ($total_contact > 0) ? '' : 'empty'; ?>">

    <?php $this->load->view('common/content/filter'); ?>

    <?php $this->load->view('common/content/tbl_contact'); ?>

    <?php

    if (isset($informModal)) {

        foreach ($informModal as $modal) {

            //  $this->load->view('manager/modal/divide_contact');

            $this->load->view($modal);

        }

    }

    ?>
	
	<?php
        $this->load->view('manager/modal/divide_contact_auto');
    ?>

</form>

<?php

if (isset($outformModal)) {

    foreach ($outformModal as $modal) {

        //  $this->load->view('manager/modal/divide_contact');

        $this->load->view($modal);

    }

}

?>

<?php

//$this->load->view('manager/modal/divide_one_contact');
