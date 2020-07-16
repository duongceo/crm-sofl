
<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Báo cáo chất lượng contact từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

    </div>

</div>


<form action="#" method="GET" id="action_contact" class="form-inline">

    <?php $this->load->view('common/content/filter'); ?>

</form>

<div class="row">

     <table class="table table-bordered table-striped view_report gr4-table"> 
        <thead class="table-head-pos">
            <tr>
					<th rowspan = "2" style="font-weight: bold">Khóa học</th>
                <!--<th style="font-weight: bold">C3</th>-->
					<th colspan = "5" style="font-weight: bold"> Số Lượng</th>
					<th colspan = "6" style="font-weight: bold; background-color: blue"> Tỷ Lệ</th>
					<th colspan = "6" style="font-weight: bold; background-color: purple"> Hiệu quả đầu tư</th>
				<tr>
					<th style="font-weight: bold">C3</th>
					<th style="font-weight: bold">L1</th>
					<th style="font-weight: bold">L2</th>
					<th style="font-weight: bold">L6</th>
					<th style="font-weight: bold">L8</th>
					<th style="font-weight: bold; background-color: blue">L1/C3</th>
					<th style="font-weight: bold; background-color: blue">L2/L1</th>
					<th style="font-weight: bold; background-color: blue">L6/L1</th>
					<th style="font-weight: bold; background-color: blue">L6/L2</th>
					<th style="font-weight: bold; background-color: blue">L8/L6</th>
					<th style="font-weight: bold; background-color: blue">L8/L1</th>
					<th style="font-weight: bold; background-color: purple">Chi phí MKT</th>
					<th style="font-weight: bold; background-color: purple">Re Dự Kiến</th>
					<th style="font-weight: bold; background-color: purple">Re Thực Tế</th>
					<th style="font-weight: bold; background-color: purple">Ma/Re Dự Kiến</th>
					<th style="font-weight: bold; background-color: purple">Ma/Re Thực Tế</th>
					<th style="font-weight: bold; background-color: purple">Ma/L8</th>
				</tr>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $course => $value) { ?>
                <tr>
                    <td style="background-color: red ;color: #FFF;font-weight: bold"><?php echo $value['course_code'] ?></td>
                    <td><?php echo $value['C3'] ?></td> 
                    <td><?php echo $value['L1'] ?></td>
                    <td><?php echo $value['L2'] ?></td>
                    <td><?php echo $value['L6'] ?></td>
                    <td><?php echo $value['L8'] ?></td>
					<td><?php echo $value['L1/C3'].'%' ?></td>
                    <td><?php echo $value['L2/L1'].'%' ?></td>
                    <td <?php if ($value['L6/L1'] < 40) {echo 'style="background-color: #a71717;color: #fff;"';}?>><?php echo $value['L6/L1'].'%' ?></td>
                    <td <?php if ($value['L6/L2'] < 45) {echo 'style="background-color: #a71717;color: #fff;"';}?>><?php echo $value['L6/L2'].'%' ?></td>
                    <td <?php if ($value['L8/L6'] < 55) {echo 'style="background-color: #a71717;color: #fff;"';}?>><?php echo $value['L8/L6'].'%'?></td>
                    <td <?php if ($value['L8/L1'] < 35) {echo 'style="background-color: #a71717;color: #fff;"';}?>><?php echo $value['L8/L1'].'%'?></td>
					<td><?php echo $value['Ma_mkt']?></td>
                    <td><?php echo $value['Re_du_kien']?></td>
                    <td><?php echo $value['Re_thuc_te']?></td>
                    <td><?php echo $value['Ma_Re_du_kien'].'%' ?></td>
                    <td><?php echo $value['Ma_Re_thuc_te'].'%' ?></td>
                    <td><?php echo $value['Gia_L8'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>   
    
</div>