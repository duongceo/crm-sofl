
<div class="container">
	<div class="row">
		<br>
		<h1 class="text-center">Danh sách học viên điểm danh lớp <b class="text-primary"><?php echo $class ?></b></h1>
		<br>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-fixed-head">
				<thead>
					<tr>
						<th>Mã lớp</th>
						<th>Tên học viên</th>
						<th>Đi học</th>
						<th>Nghỉ có phép</th>
						<th>Nghỉ không phép</th>
						<th>Ghi chú</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($contact as $item) { ?>
						<tr>
							<td class="text-center">
								<?php echo $item['class_study_id']?>
								<input type="hidden" name="class_study_id" value="<?php echo $item['class_study_id']?>">
							</td>
							<td class="text-center">
								<?php echo $item['name']?>
							</td>
							<td class="text-center">
								<input type="radio" name="check_attend_<?php echo $item['id']?>" <?php echo ($item['presence_id'] == 1) ? 'checked':''?> contact_id="<?php echo $item['id']?>" value="1" class="form-control">
							</td>
							<td class="text-center">
								<input type="radio" name="check_attend_<?php echo $item['id']?>" <?php echo ($item['presence_id'] == 2) ? 'checked':''?> contact_id="<?php echo $item['id']?>" value="2" class="form-control">
							</td>
							<td class="text-center">
								<input type="radio" name="check_attend_<?php echo $item['id']?>" <?php echo ($item['presence_id'] == 3) ? 'checked':''?> contact_id="<?php echo $item['id']?>" value="3" class="form-control">
							</td>
							<td class="text-center">
								<input type="text" name="note_<?php echo $item['id']?>" value="<?php echo ($item['note'] != '') ? $item['note']:''?>" style="width: 100%">
							</td>

						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="text-center">
				<button class="btn btn-lg btn-success btn-attendance">Lưu</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on('click', '.btn-attendance', function (e) {
		e.preventDefault();
		let statusList = $('input[type=radio]:checked');
		let data = [];
		for (let i=0; i<statusList.length; i++) {
			let std = {
				'class_id' : $('input[name="class_study_id"]').val(),
				'contact_id' : $(statusList[i]).attr('contact_id'),
				'presence_id' : $(statusList[i]).val(),
				'note' : $('[name=note_'+$(statusList[i]).attr('contact_id')+']').val()
			};
			data.push(std)
		}

		$.ajax({
			url: $("#base_url").val() + "student/action_attendance",
			type: "POST",
			data: {
				data_attendance: JSON.stringify(data)
			},
			success: function (infor) {
				location.reload();
			},
		});
	});
</script>
