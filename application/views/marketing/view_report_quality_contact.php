
<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Báo cáo theo ngôn ngữ từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

    </div>

</div>


<form action="#" method="GET" id="action_contact" class="form-inline">

    <?php $this->load->view('common/content/filter'); ?>

</form>

<div class="row">

     <table class="table table-bordered table-striped view_report gr4-table"> 
        <thead class="table-head-pos">
            <tr>
				<th rowspan = "2" style="font-weight: bold">Ngôn ngữ</th>
				<th colspan = "2" style="font-weight: bold"> Số Lượng</th>
				<th colspan = "10" style="font-weight: bold; background-color: purple"> Chi Phí và Giá</th>
				<tr>
					<th style="font-weight: bold">Contact (C3)</th>
                    <th style="font-weight: bold">Đăng ký thành công (L5)</th>
					<th style="font-weight: bold; background-color: purple">Chi phí FB</th>
<!--					<th style="font-weight: bold; background-color: purple">Giá Contact FB</th>-->
					<th style="font-weight: bold; background-color: purple">Chi phí GG</th>
<!--					<th style="font-weight: bold; background-color: purple">Giá Contact GG</th>-->
					<th style="font-weight: bold; background-color: purple">Tổng chi phí</th>
					<th style="font-weight: bold; background-color: purple">Giá tổng</th>
					<th style="font-weight: bold; background-color: purple">Doanh thu</th>
					<th style="font-weight: bold; background-color: purple">Tổng chi phí / Doanh thu</th>
				</tr>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $course => $value) { ?>
                <tr>
                    <td style="background-color: #0EA3EF ;color: #FFF;font-weight: bold"><?php echo $value['language_name'] ?></td>
                    <td><?php echo $value['C3'] ?></td>
                    <td><?php echo $value['L5'] ?></td>
                    <td><?php echo $value['Ma_FB']?> VNĐ</td>
                    <td><?php echo $value['Ma_GG']?> VNĐ</td>
					<td><?php echo $value['Ma_mkt']?> VNĐ</td>
					<td><?php echo $value['Gia_So']?> VNĐ</td>
                    <td><?php echo $value['Re_thuc_te']?> VNĐ</td>
                    <td><?php echo $value['Ma_Re_thuc_te'].'%' ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>   
    
</div>

<hr>

<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo Marketer từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<div class="row">

	<table class="table table-bordered table-striped view_report gr4-table">
		<thead class="table-head-pos">
			<tr>
				<th rowspan = "2" style="font-weight: bold">Nhân viên</th>
				<th colspan = "2" style="font-weight: bold"> Số Lượng</th>
				<th colspan = "6" style="font-weight: bold; background-color: #1b6d85 "> Hiệu quả</th>
				<tr>
					<th style="font-weight: bold">Contact (C3)</th>
					<th style="font-weight: bold">Đăng ký thành công (L5)</th>
					<th style="font-weight: bold; background-color: #1b6d85">Chi Phí FB</th>
					<th style="font-weight: bold; background-color: #1b6d85">Chi Phí GG</th>
					<th style="font-weight: bold; background-color: #1b6d85">Tổng Chi Phí</th>
					<th style="font-weight: bold; background-color: #1b6d85">Giá Contact</th>
<!--					<th style="font-weight: bold; background-color: #1b6d85">Doanh thu</th>-->
<!--					<th style="font-weight: bold; background-color: #1b6d85">Chí Phí / Doanh thu</th>-->
				</tr>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($report_mkt as $value) { ?>
				<tr>
					<td style="background-color: #0c6681 ;color: #FFF;font-weight: bold"><?php echo $value['mkt_name'] ?></td>
					<td><?php echo $value['C3']?></td>
					<td><?php echo $value['L5']?></td>
					<td><?php echo $value['Ma_mkt_FB']?> VNĐ</td>
					<td><?php echo $value['Ma_mkt_GG']?> VNĐ</td>
					<td><?php echo $value['Ma_mkt']?> VNĐ</td>
					<td><?php echo $value['Gia_So']?> VNĐ</td>
<!--					<td>--><?php //echo $value['Re_thuc_te']?><!--</td>-->
<!--					<td>--><?php //echo $value['Ma_Re_thuc_te'].'%' ?><!--</td>-->
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
