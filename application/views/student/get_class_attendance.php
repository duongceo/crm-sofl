
<div class="container">
	<div class="row">
		<h1 class="text-center">Chọn ngoại ngữ của lớp học cần điểm danh</h1>
		<br>
		<div class="col-xs-12">
			<form action="<?php echo base_url()?>student/get_class_attendance" class="form-inline text-center" method="GET">
				<div class="form-group">
					<input style="border-radius: 5px; padding: 20px; margin-bottom: 10px;" type="text" class="form-control" name="search_class" placeholder="Tìm mã lớp" value="<?php echo (isset($_GET['search_class'])) ? $_GET['search_class'] : ''?>">
					<input type="hidden" name="branch_id" value="<?php echo $branch_id?>">
					<input type="hidden" name="language_id" value="<?php echo $language_id?>">
				</div>
					<button style="padding: 10px; margin-bottom: 10px;" class="btn btn-primary" type="submit">
					Tìm Lớp <span class="glyphicon glyphicon-search"></span>
				</button>
			</form>
		</div>
		<div class="clearfix"></div>

		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Mã lớp</th>
						<th>Khóa học</th>
						<th>Giảng viên</th>
						<th>Điểm danh</th>
						<th>Kiểm tra chuyên cần</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($class as $item) { ?>
						<tr>
							<td class="text-center"><?php echo $item['class_study_id']?></td>
							<td class="text-center"><?php echo $item['level_language_name']?></td>
							<td class="text-center"><?php echo $item['teacher_name']?></td>
							<td class="text-center">
								<a class="btn btn-success" href="<?php echo base_url().'student/attendance_class?class_study_id='.$item['class_study_id']?>">Điểm danh lớp</a>
							</td>
							<td class="text-center">
								<a class="btn btn-primary" href="<?php echo base_url().'student/manager_diligence?class_study_id='.$item['class_study_id']?>">Kiểm tra chuyên cần</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

