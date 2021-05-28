
<div class="container">
	<div class="row">
		<h1 class="text-center">Chọn cơ sở của lớp học cần điểm danh</h1>
		<br>
		<?php foreach ($branch as $item) { ?>
			<div class="col-md-8 col-xs-12 col-md-offset-4">
				<a class="btn btn-success" href="<?php echo base_url() . 'student/chose_language?branch_id=' . $item['id']?>">
					<?php echo $item['name'] . ' - ' . $item['address']?>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
