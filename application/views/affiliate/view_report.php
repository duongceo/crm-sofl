<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Báo cáo doanh thu cá nhân từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

    </div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

    <?php $this->load->view('common/content/filter'); ?>

</form>




<!-- Vẽ biểu đồ -->
<script>
    /* load các loại biểu đồ của google ở đây */
    $(document).ready(function () {
        google.charts.load('current', {packages: ['corechart', 'bar','line']});
        google.charts.setOnLoadCallback(drawL1);

    });
</script>

<!-- Vẽ biểu đồ Số contact-->
<div id="chart_L1" style="width: 100%; height: 500px;"></div>
<script>
    function drawL1() {
        var chartL1 = document.getElementById('chart_L1');
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'day');
        data.addColumn('number', 'tổng doanh thu');
        data.addColumn('number', 'hoa hồng');
        data.addRows([
<?php
foreach ($per_day as $key => $value) {
    $date = explode('/', $key);
    echo "[new Date(" . $date[2] . ", " . ($date[1] - 1) . "," . $date[0] . ")," . $value['revenue'] . ",". $value['commission'] . "],";
}
?>
        ]);
        var materialOptions = {
            title: 'Báo cáo doanh thu cá nhân',
            series: {
                0: {axis: 'vnd', type: 'line'},
                1: {axis: 'vnd', type: 'line'},
            },
            axes: {
                y: {
                    contact: {label: 'Số lượng contact'}
                }
            }
        };
        function drawMaterialChart() {
            var materialChart = new google.visualization.ComboChart(chartL1);
            materialChart.draw(data, materialOptions);
        }
        drawMaterialChart();
    }

</script>

