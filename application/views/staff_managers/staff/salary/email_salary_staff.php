<div class="container">
	<div class="row">
		<p>
			Công ty TNHH Dịch vụ và Đào tạo Minh Đức,
			Phòng Kế Toán SOFL thân gửi Anh/Chị bảng lương tháng ...../2022.
			Mọi thông tin, thắc mắc xin vui lòng gửi về địa chỉ email: ketoan.sofl@gmail.com trước ngày 15.
			Xin chân thành cảm ơn!
		</p>

		<table border="1" cellpadding="0" cellspacing="0"  width="100%">
			<thead>
				<tr>
					<th>Họ tên</th>
					<th>Lương cơ bản</th>
					<th>Công cơ bản/Tháng</th>
					<th>Ngày công chuyên cần</th>
					<th>Ngày OT</th>
					<th>Lương thực lĩnh</th>
					<th>Lương OT/Tháng</th>
					<th>Phạt muộn</th>
					<th>Com</th>
					<th>KPI/KOL</th>
					<th>Công đoàn</th>
					<th>Chi khác</th>
					<th>Bảo hiểm</th>
					<th>Phụ cấp</th>
					<th>Lương khác</th>
					<th>Tổng thực lĩnh</th>
					<th>Lấy phép</th>
				</tr>
			</thead>

			<tbody>
				<?php
					$salary_month = ($salary['salary_basic']/ $salary['work_per_month']) * $salary['work_diligence'];
					$salary_real = (($salary['salary_basic']/ $salary['work_per_month']) * 1.5) * $salary['work_diligence'];
					$total_salary_real = $salary_month + $salary_real - $salary['punish_late'] + $salary['com'] + $salary['kpi_per_kol'] - $salary['federation'] - $salary['cost_other'] - $salary['insurance'] + $salary['allowance'] + $salary['salary_other'];
				?>
				<tr align="center">
					<td class="text-center">
						<?php echo html_entity_decode($salary['name']) ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['salary_basic']); ?>
					</td>
					<td class="text-center">
						<?php echo $salary['work_per_month']; ?>
					</td>
					<td class="text-center">
						<?php echo $salary['work_diligence']; ?>
					</td>
					<td class="text-center">
						<?php echo $salary['work_OT']; ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary_month); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary_real); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['punish_late']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['com']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['kpi_per_kol']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['federation']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['cost_other']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['insurance']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['allowance']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($salary['salary_other']); ?>
					</td>
					<td class="text-center">
						<?php echo h_number_format($total_salary_real); ?>
					</td>
					<td class="text-center">
						<?php echo $salary['on_leave']; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
