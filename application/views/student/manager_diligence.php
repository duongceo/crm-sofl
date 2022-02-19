
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
						<th>Giáo viên dạy</th>
						<th>Trạng thái</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($list_diligence as $item) { ?>
						<tr>
							<td class="text-center"><?php echo date('d-m-Y', $item['time_update']) ?></td>
							<td class="text-center">
                                <?php echo $item['class_study_id'] ?>
                            </td>
							<td class="text-center" column="diligence" item_id="<?php echo $item['class_study_id'] ?>" date_update="<?php echo $item['time_update'] ?>" lesson_learned="<?php echo $item['lesson_learned'] ?>">
                                Buổi <?php echo $item['lesson_learned'] ?>
                                <input type="hidden" class="value_current" value="<?php echo $item['lesson_learned']?>">
                                <?php if ($this->role_id == 12) { ?>
                                    <button style="margin-right: 0" class="btn btn-default btn-sm update_data_inline">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>
                                <?php } ?>
                            </td>
							<td><?php echo $item['lecture'] ?></td>
							<td class="text-center">
                                <?php if ($item['speaker'] == 1) {
                                    echo 'Giáo viên Việt';
                                } else {
                                    echo 'Giáo viên bản ngữ';
                                } ?>
                            </td>
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

