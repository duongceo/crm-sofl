<div class="container">
    <div class="row">
        <p>
            Dear Thầy/ Cô <br>
            Trung tâm gửi bảng kê lương tháng 06/2021. Nếu có thắc mắc vui lòng phản hồi lại bằng email này.
            Lương sẽ được chuyển từ ngày 10- 15 hàng tháng, nếu bên Trung tâm chưa gửi được đúng thời hạn sẽ báo trực tiếp với Thầy/ Cô.
            Khi nhận được lương vui lòng BÁO LẠI. Mọi thắc mắc về lương không giải quyết sau ngày m5.
        </p>

        <table border="1" cellpadding="0" cellspacing="0"  width="100%">
            <thead>
                <tr style="background: #53b9e9">
                    <th>Họ tên</th>
                    <th>SĐT</th>
                    <th>Mã lớp</th>
                    <th>Ngày KG</th>
                    <th>Ngoại ngữ</th>
                    <th>Số buổi dạy</th>
                    <th>Lương/Buổi</th>
                    <th>Tổng lương</th>
                    <th>Phạt</th>
                    <th>Thưởng</th>
                    <th>Tổng nhận</th>
                </tr>
            </thead>

            <tbody>
                <tr align="center">
                    <td><?php echo $teacher['name'] ?></td>
                    <td><?php echo $teacher['phone'] ?></td>
                    <td><?php echo $teacher['class_study_id'] ?></td>
                    <td><?php echo date('d-m-Y', $teacher['time_start']) ?></td>
                    <td><?php echo $teacher['language'] ?></td>
                    <td><?php echo $teacher['lesson_learned'] ?> Buổi</td>
                    <td><?php echo h_number_format($teacher['salary_per_day']) ?></td>
                    <td><?php echo h_number_format($teacher['salary_per_day'] * $teacher['lesson_learned']) ?></td>
                    <td>
                        <?php echo h_number_format($teacher['fine']) ?>
                    </td>
                    <td>
                        <?php echo h_number_format($teacher['bonus']) ?>
                    </td>
                    <td><?php echo h_number_format(($teacher['salary_per_day'] * $teacher['lesson_learned']) - $teacher['fine'] + $teacher['bonus']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>