<div class="container">
	<div class="row">
		<h1 class="text-center">Chọn ngoại ngữ của lớp học cần điểm danh</h1>
		<br>
		<div class="text-center">
			<?php foreach ($language as $item) { ?>
				<a class="btn btn-lg btn-primary" href="<?php echo base_url() . 'student/get_class_attendance?branch_id='.$branch_id.'&language_id=' . $item['id']?>">
					<?php echo $item['name']?>
				</a>
			<?php } ?>
		</div>
	</div>
</div>
