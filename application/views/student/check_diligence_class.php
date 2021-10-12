
<div class="container">
	<div class="row">
		<h1 class="text-center">Kiểm tra chuyên cần lớp <b class="text-primary"><?php echo $_GET['class_study_id'] ?></b></h1>	

		<div class="clearfix"></div>

		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Ngày điểm danh</th>
						<th>Họ tên học viên</th>
						<th>Trạng thái học</th>
						<th>Buổi học</th>
						<th>Bài học</th>
						<th>Ghi chú</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($list_diligence_detail as $item) { ?>
						<tr>
							<td class="text-center"><?php echo date('d-m-Y H:i', $item['time_created']) ?></td>
							<td class="text-center"><?php echo $item['contact_name'] ?></td>
							<td class="text-center">
								<?php foreach ($presence as $value) { 
									echo ($value['id'] == $item['presence_id']) ? $value['name'] : '' ;
								} ?>
							 </td>
							<td class="text-center">Buổi <?php echo $item['lesson_learned'] ?></td>
							<td class="text-center"><?php echo $item['lecture'] ?></td>
							<td class="text-center"><?php echo $item['note'] ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

