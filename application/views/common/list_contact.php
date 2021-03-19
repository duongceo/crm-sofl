
<?php if(isset($progressType)) { ?>

<div class="container">

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <h1 class="text-center text-uppercase red margintop20 marginbottom20"> <?php echo $progressType?> </h1>

            <?php if (isset($progress['progressbar'])) { ?>

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
            <?php } ?>

        </div>

    </div>

    <?php if (in_array($this->role_id, array(3, 12, 5, 7, 9))) { ?>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h3 class="text-center marginbottom20">Doanh thu</h3>
			</div>
		</div>
<!--		--><?php //print_arr($progress) ?>
    	<h4>Học viên mới</h4>
        <div class="row">
			<?php foreach ($progress['new'] as $key => $value) {?>
				<div class="col-md-3">
					<div class="panel panel-success text-center">
						<div class="panel-heading"><?php echo $key; ?></div>
						<div class="panel-body" style="color: #006cf1"><?php echo h_number_format($value[0]['RE']) ?></div>
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
            <?php foreach ($progress['old'] as $key => $value) {?>
                <div class="col-md-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading"><?php echo $key; ?></div>
                        <div class="panel-body" style="color: #006cf1"><?php echo h_number_format($value[0]['RE']) ?></div>
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

<?php if (isset($progress_sale)) {
	 $this->load->view('sale/view_process');
	 $this->load->view('sale/sale_have_to_call');
 } ?>

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

	if ($this->controller == 'student') {
		$this->load->view('student/modal/merge_contact_modal');
	}

?>
