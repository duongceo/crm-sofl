

<div class="row">

   <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Báo cáo tư vấn tuyển sinh từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

    </div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

    <?php $this->load->view('common/content/filter'); ?>

</form> 

<table class="table table-bordered table-striped view_report gr4-table table-fixed-head">

    <thead>

        <tr>

            <th style="background: none" class="staff_0"></th>

            <?php
				foreach ($staffs as $value) {

					if ($value['NHAN'] > 0) {

						?>

						<th class="staff_<?php echo $value['id']; ?>">

							<?php echo $value['name']; ?>

						</th>

						<?php

					}

				}

            ?>

            <th class="staff_sum">

                Tổng

            </th>

        </tr>

    </thead>

    <tbody>

        <?php

        $report = array(

            array('Nhận', 'NHAN', $NHAN),

            array('Chưa gọi', 'CHUA_GOI', $CHUA_GOI),
			
			array('Xử Lý', 'XU_LY', $XU_LY),
			array('Nghe Máy', 'NGHE_MAY', $NGHE_MAY),
			array('Ko Nghe Máy', 'KHONG_NGHE_MAY', $KO_NGHE_MAY),

//			array('Lượt gọi', 'LUOT_GOI', $LUOT_GOI),
			
//            array('LC', 'LC', $LC),

            array('L1', 'L1', $L1),
            array('L2', 'L2', $L2),
            array('L3', 'L3', $L3),
            array('L4', 'L4', $L4),
            array('L5', 'L5', $L5),
            array('L6', 'L6', $L6),
            array('L7', 'L7', $L7),
            array('L8', 'L8', $L8),

//            array('Còn cứu được', 'CON_CUU_DUOC', $CON_CUU_DUOC),

//            array('Từ chối mua', 'TU_CHOI_MUA', $TU_CHOI_MUA),

//            array('L6', 'L6', $L6),

//            array('L6 chưa giao hàng (COD)', 'CHUA_GIAO_HANG_COD', $CHUA_GIAO_HANG_COD),

//            array('L6 chưa giao hàng (chuyển khoản + khác)', 'CHUA_GIAO_HANG_TRANSFER', $CHUA_GIAO_HANG_TRANSFER),

//            array('Đang giao hàng', 'DANG_GIAO_HANG', $DANG_GIAO_HANG),

//            array('Đã thu COD', 'DA_THU_COD', $DA_THU_COD),

//            array('Hủy đơn', 'HUY_DON', $HUY_DON),

//            array('L8', 'L8', $L8),

        );

        foreach ($report as $values) {

            list($name, $value2, $total) = $values;

            ?>

            <tr>

                <td> <?php echo $name; ?> </td>

                <?php

                foreach ($staffs as $value) {

                    if ($value['NHAN'] > 0 || $value['L5'] > 0 ) {

                        ?>

                        <td class="show_detail" staff_id = "<?php echo $value['id']; ?>" type_contact = "<?php echo $value2; ?>" time_start = "<?php echo $startDate; ?>" time_end = "<?php echo $endDate; ?>" total = "<?php echo $value[$value2]; ?>">

                            <?php echo $value[$value2]; ?>

                        </td>

                        <?php

                    }

                }

                ?>

                <td class="show_detail">

                    <?php echo $total; ?>

                </td>

            </tr>

            <?php

        }

        ?>

        <?php

        $report2 = array(

            array('Nghe Máy/Xử lý', 'NGHE_MAY', 'XU_LY', ($XU_LY != 0) ? round(($NGHE_MAY / $XU_LY) * 100, 2) : 'không thể chia cho 0', 70),
            array('Ko Nghe Máy/Xử lý', 'KHONG_NGHE_MAY', 'XU_LY', ($XU_LY != 0) ? round(($KO_NGHE_MAY / $XU_LY) * 100, 2) : 'không thể chia cho 0', 25),
            array('L5/Xử lý', 'L5', 'XU_LY', ($XU_LY != 0) ? round(($L5 / $XU_LY) * 100, 2) : 'không thể chia cho 0', 20),

//            array('L6/L1', 'L6', 'L1', ($L1 != 0) ? round(($L6 / $L1) * 100, 2) : 'không thể chia cho 0', 80),
//
//            array('L6/L2', 'L6', 'L2', ($L2 != 0) ? round(($L6 / $L2) * 100, 2) : 'không thể chia cho 0', 80),
//
//            array('L8/L6', 'L8', 'L6', ($L6 != 0) ? round(($L8 / $L6) * 100, 2) : 'không thể chia cho 0', 80),
//
//            array('L8/L1', 'L8', 'L1', ($L1 != 0) ? round(($L8 / $L1) * 100, 2) : 'không thể chia cho 0', 60),
//
//            array('L7L8/L1', 'L7L8', 'L1', ($L1 != 0) ? round(( ($DA_THU_COD + $L8) / $L1) * 100, 2) : 'không thể chia cho 0', 60),
//
//            array('L8/L2', 'L8', 'L2', ($L2 != 0) ? round(($L8 / $L2) * 100, 2) : 'không thể chia cho 0', 60),
//
//            array('Hủy đơn/L6', 'HUY_DON', 'L6', ($L6 != 0) ? round(($HUY_DON / $L6) * 100, 2) : 'không thể chia cho 0', 0),
//
//            array('LC/L1', 'LC', 'L1', ($L1 != 0) ? round(($LC / $L1) * 100, 2) : 'không thể chia cho 0', 0),
//
//            array('0.5/L1', 'CON_CUU_DUOC', 'L1', ($L1 != 0) ? round(($CON_CUU_DUOC / $L1) * 100, 2) : 'không thể chia cho 0', 0),

        );

        foreach ($report2 as $values) {

            list($name, $tu_so, $mau_so, $total, $limit) = $values;

            ?>

            <tr>

                <td> <?php echo $name; ?> </td>

                <?php

                foreach ($staffs as $value) {

                    if ($value['NHAN'] > 0 || $value['L5'] > 0 ) {

                        ?>

                        <td <?php

                        if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

                            echo 'style="background-color: #a71717;color: #fff;"';

                        } else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

                            echo 'style="background-color: #0C812D;color: #fff;"';

                        }

                        ?>>

                        <?php

							echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'không thể chia cho 0';

                            ?>

                        </td>

                                <?php

                            }

                        }

                        ?>

                <td <?php

                if ($total < $limit && $limit > 0) {

                    echo 'style="background-color: #a71717;color: #fff;"';

                } else if ($total >= $limit && $limit > 0) {

                    echo 'style="background-color: #0C812D;color: #fff;"';

                }

                ?>>

                <?php echo $total . '%'; ?>

                </td>

            </tr>

    <?php

}

?>

    </tbody>

</table>

<hr>
<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo tổng quan ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<table class="table table-bordered table-striped view_report gr4-table">

	<thead>

	<tr>

		<th style="background: none" class="staff_0"></th>

		<?php
		foreach ($language as $value) {

//			if ($value['NHAN'] > 0) {

				?>

				<th class="staff_<?php echo $value['id']; ?>">

					<?php echo $value['name']; ?>

				</th>

				<?php

//			}

		}

		?>

		<th class="staff_sum">

			Tổng

		</th>

	</tr>

	</thead>

	<tbody>

	<?php

	$report = array(

		array('Nhận', 'NHAN', $NHAN),
		array('Chưa gọi', 'CHUA_GOI', $CHUA_GOI),
		array('Xử Lý', 'XU_LY', $XU_LY),
		array('Nghe Máy', 'NGHE_MAY', $NGHE_MAY),
		array('Ko Nghe Máy', 'KHONG_NGHE_MAY', $KO_NGHE_MAY),

//			array('Lượt gọi', 'LUOT_GOI', $LUOT_GOI),

//            array('LC', 'LC', $LC),

		array('L1', 'L1', $L1),
		array('L2', 'L2', $L2),
		array('L3', 'L3', $L3),
		array('L4', 'L4', $L4),
		array('L5', 'L5', $L5),
		array('L6', 'L6', $L6),
		array('L7', 'L7', $L7),
		array('L8', 'L8', $L8),

//            array('Còn cứu được', 'CON_CUU_DUOC', $CON_CUU_DUOC),

//            array('Từ chối mua', 'TU_CHOI_MUA', $TU_CHOI_MUA),

//            array('L6', 'L6', $L6),

//            array('L6 chưa giao hàng (COD)', 'CHUA_GIAO_HANG_COD', $CHUA_GIAO_HANG_COD),

//            array('L6 chưa giao hàng (chuyển khoản + khác)', 'CHUA_GIAO_HANG_TRANSFER', $CHUA_GIAO_HANG_TRANSFER),

//            array('Đang giao hàng', 'DANG_GIAO_HANG', $DANG_GIAO_HANG),

//            array('Đã thu COD', 'DA_THU_COD', $DA_THU_COD),

//            array('Hủy đơn', 'HUY_DON', $HUY_DON),

//            array('L8', 'L8', $L8),

	);

	foreach ($report as $values) {

		list($name, $value2, $total) = $values;

		?>

		<tr>

			<td> <?php echo $name; ?> </td>

			<?php

			foreach ($language as $value) {

//				if ($value['NHAN'] > 0 || $value['L5'] > 0 ) {

					?>

					<td class="show_detail" staff_id = "<?php echo $value['id']; ?>" type_contact = "<?php echo $value2; ?>" time_start = "<?php echo $startDate; ?>" time_end = "<?php echo $endDate; ?>" total = "<?php echo $value[$value2]; ?>">

						<?php echo $value[$value2]; ?>

					</td>

					<?php

//				}

			}

			?>

			<td class="show_detail">

				<?php echo $total; ?>

			</td>

		</tr>

		<?php

	}

	?>

	<?php

	$report2 = array(

		array('Nghe Máy/Xử lý', 'NGHE_MAY', 'XU_LY', ($XU_LY != 0) ? round(($NGHE_MAY / $XU_LY) * 100, 2) : 'không thể chia cho 0', 70),
		array('Ko Nghe Máy/Xử lý', 'KHONG_NGHE_MAY', 'XU_LY', ($XU_LY != 0) ? round(($KO_NGHE_MAY / $XU_LY) * 100, 2) : 'không thể chia cho 0', 25),
		array('L5/Xử lý', 'L5', 'XU_LY', ($XU_LY != 0) ? round(($L5 / $XU_LY) * 100, 2) : 'không thể chia cho 0', 20),

//            array('L6/L1', 'L6', 'L1', ($L1 != 0) ? round(($L6 / $L1) * 100, 2) : 'không thể chia cho 0', 80),
//
//            array('L6/L2', 'L6', 'L2', ($L2 != 0) ? round(($L6 / $L2) * 100, 2) : 'không thể chia cho 0', 80),
//
//            array('L8/L6', 'L8', 'L6', ($L6 != 0) ? round(($L8 / $L6) * 100, 2) : 'không thể chia cho 0', 80),
//
//            array('L8/L1', 'L8', 'L1', ($L1 != 0) ? round(($L8 / $L1) * 100, 2) : 'không thể chia cho 0', 60),
//
//            array('L7L8/L1', 'L7L8', 'L1', ($L1 != 0) ? round(( ($DA_THU_COD + $L8) / $L1) * 100, 2) : 'không thể chia cho 0', 60),
//
//            array('L8/L2', 'L8', 'L2', ($L2 != 0) ? round(($L8 / $L2) * 100, 2) : 'không thể chia cho 0', 60),
//
//            array('Hủy đơn/L6', 'HUY_DON', 'L6', ($L6 != 0) ? round(($HUY_DON / $L6) * 100, 2) : 'không thể chia cho 0', 0),
//
//            array('LC/L1', 'LC', 'L1', ($L1 != 0) ? round(($LC / $L1) * 100, 2) : 'không thể chia cho 0', 0),
//
//            array('0.5/L1', 'CON_CUU_DUOC', 'L1', ($L1 != 0) ? round(($CON_CUU_DUOC / $L1) * 100, 2) : 'không thể chia cho 0', 0),

	);

	foreach ($report2 as $values) {

		list($name, $tu_so, $mau_so, $total, $limit) = $values;

		?>

		<tr>

			<td> <?php echo $name; ?> </td>

			<?php

			foreach ($language as $value) {

//				if ($value['NHAN'] > 0 || $value['L5'] > 0 ) {

					?>

					<td <?php

					if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

						echo 'style="background-color: #a71717;color: #fff;"';

					} else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

						echo 'style="background-color: #0C812D;color: #fff;"';

					}

					?>>

						<?php

						echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'không thể chia cho 0';

						?>

					</td>

					<?php

//				}

			}

			?>

			<td <?php

			if ($total < $limit && $limit > 0) {

				echo 'style="background-color: #a71717;color: #fff;"';

			} else if ($total >= $limit && $limit > 0) {

				echo 'style="background-color: #0C812D;color: #fff;"';

			}

			?>>

				<?php echo $total . '%'; ?>

			</td>

		</tr>

		<?php

	}

	?>

	</tbody>

</table>

<?php //$this->load->view('common/modal/view_detail_infor');  ?>

<?php //$this->load->view('common/content/pagination');  ?>


