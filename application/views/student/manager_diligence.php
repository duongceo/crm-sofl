
<div class="container">
	<div class="row">
		<h1 class="text-center">Kiểm tra chuyên cần lớp <b class="text-primary"><?php echo $_GET['class_study_id'] ?></b></h1>

        <?php if ($this->role_id == 12) { ?>
            <div class="col-md-8 col-md-offset-2 col-xs-12">
                <form action="#" method="GET" id="action_contact" class="form-inline">
                    <?php $this->load->view('common/content/filter'); ?>
                </form>
            </div>
        <?php } ?>

		<div class="clearfix"></div>

		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Ngày điểm danh</th>
						<th>Lớp</th>
						<th>Buổi học</th>
						<th>Bài học</th>
						<th>Trạng thái</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($list_diligence as $item) { ?>
						<tr>
							<td class="text-center"><?php echo date('d-m-Y H:i', $item['time_created']) ?></td>
							<td class="text-center"><?php echo $item['class_study_id'] ?></td>
							<td class="text-center">Buổi <?php echo $item['lesson_learned'] ?></td>
							<td><?php echo $item['lecture'] ?></td>
							<td class="text-center text-primary">
								<a href="<?php echo base_url() .'student/check_diligence_class?class_study_id='.$item['class_study_id']. '&time_update='.$item['time_update'] ?>" class="btn btn-success">Xem chi tiết</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

