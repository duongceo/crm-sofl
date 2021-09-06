
<div class="container">
	<div class="row">
		<br>
		<h1 class="text-center">Danh sách học viên điểm danh lớp <b class="text-primary"><?php echo $class ?></b></h1>
		<br>
		<div>
			<div class="form-group">
				<div class="row">
				<div class="col-md-5 col-xs-4 offset-md-4 text-right">
					Ngày điểm danh
				</div>
				<div class=' col-md-3 col-xs-8 input-group date'>
					<input type='text' class="form-control" name='date_diligence' value="" style="z-index: 0" />
					<span class="input-group-addon">
	                    <span class="glyphicon glyphicon-calendar"></span>
	                </span>
				</div>
			</div>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered table-striped table-fixed-head">
				<thead>
					<tr>
						<th>Mã lớp</th>
						<th>Tên học viên</th>
						<th>Đi học</th>
						<th>Nghỉ có phép</th>
						<th>Nghỉ không phép</th>
						<th>Điểm</th>
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
								<input type="text" name="score" value="<?php echo ($item['score'] != '') ? $item['score'] : ''?>" style="width: 50%">
							</td>
							<td class="text-center">
								<input type="text" name="note_<?php echo $item['id']?>" value="<?php echo ($item['note'] != '') ? $item['note']:''?>" style="width: 100%">
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td class="text-center" style="font-size: 16px;">
							Số buổi học
						</td>
						<td class="text-center">
							<input type="text" class="lesson_learned" name="lesson_learned" value="">
						</td>
					</tr>

					<tr>
						<td class="text-center" style="font-size: 16px;">
							Tiến độ bài học
						</td>
						<td class="text-center">
							<textarea class="lecture" name="lecture" value=""></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="text-center">
				<button class="btn btn-lg btn-success btn-attendance">Lưu</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(function () {
        $('.date').datetimepicker();
    });
</script>

<script type="text/javascript">
	$(document).on('click', '.btn-attendance', function (e) {
		e.preventDefault();
		let lesson_learned = $('.lesson_learned').val();
		let date_diligence = $('.date_diligence').val();
		let lecture = $('.lecture').val();
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
				data_attendance: JSON.stringify(data),
				lesson_learned: lesson_learned,
				date_diligence: date_diligence,
				lecture: lecture,
			},
			success: function (data) {
				data = JSON.parse(data);
				if (data.good == 1) {
					$.notify(data.message, {
						position: "top left",
						className: 'success',
						showDuration: 200,
						autoHideDelay: 5000
					});
				} else {
					$.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
						position: "top left",
						className: 'error',
						showDuration: 200,
						autoHideDelay: 7000
					});
				}
			},
		});
	});
</script>
