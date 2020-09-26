<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h3 class="text-center marginbottom20"> Báo cáo marketing từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

    </div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

    <?php $this->load->view('common/content/filter'); ?>

</form>


<div class="row">
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
    
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

        <div class="panel panel-success">

            <div class="panel-heading">

                <h3 class="panel-title">Tổng chi phí</h3>

            </div>

            <div class="panel-body">

                <?php echo number_format(str_replace('.', '', $total['total_spend'])) . ' VNĐ' ?>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

        <div class="panel panel-success">

            <div class="panel-heading">

                <h3 class="panel-title">Tổng L1</h3>

            </div>

            <div class="panel-body">

                <?php echo $total['total_l1'] ?>

            </div>

        </div>

    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

        <div class="panel panel-success">

            <div class="panel-heading">

                <h3 class="panel-title">Giá L1</h3>

            </div>

            <div class="panel-body">

                <?php echo number_format(str_replace('.', '', $total['total_price_L1'])) . ' VNĐ' ?>

            </div>

        </div>

    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

        <div class="panel panel-success">

            <div class="panel-heading">

                <h3 class="panel-title">Doanh thu dự kiến</h3>

            </div>

            <div class="panel-body">

                <?php echo number_format(str_replace('.', '', $total['duanh_thu_du_kien'])) . ' VNĐ' ?>

            </div>

        </div>

    </div>
    
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="panel panel-success">

            <div class="panel-heading">

                <h3 class="panel-title">Doanh thu Thực tế</h3>

            </div>

            <div class="panel-body">

                <?php echo number_format(str_replace('.', '', $total['revenue'])) . ' VNĐ' ?>

            </div>

        </div>
    </div>
    
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
</div>


<!-- Vẽ biểu đồ -->
<script>
    /* load các loại biểu đồ của google ở đây */
    $(document).ready(function () {
        google.charts.load('current', {packages: ['corechart', 'bar','line']});
        google.charts.setOnLoadCallback(drawL1);
        google.charts.setOnLoadCallback(drawpriceC3);
        google.charts.setOnLoadCallback(drawSpendeach);
        google.charts.setOnLoadCallback(drawMa_Re);
    });
</script>

<!-- Vẽ biểu đồ Số contact-->
<div id="chart_L1" style="width: 100%; height: 500px;"></div>
<script>
    function drawL1() {
        var chartL1 = document.getElementById('chart_L1');
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'day');
        data.addColumn('number', 'Số lượng contact');
        data.addColumn('number', 'Số lượng contact trung bình lũy kế');
        data.addRows([
<?php
foreach ($per_day as $key => $value) {
    $date = explode('/', $key);
    echo "[new Date(" . $date[2] . ", " . ($date[1] - 1) . "," . $date[0] . ")," . $value['l1'] . ",". $value['l1_luy_ke_trung_binh'] . "],";
}
?>
        ]);
        var materialOptions = {
            title: 'SỐ LƯỢNG CONTACT HÀNG NGÀY',
            series: {
                0: {axis: 'contact', type: 'bars'},
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

<!-- Vẽ biểu đồ Ma/Re-->
<div id="chart_Ma_Re" style="width: 100%; height: 500px;"></div>
<script>
    function drawMa_Re() {
        var chartMa_Re = document.getElementById('chart_Ma_Re');
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'day');
        data.addColumn('number', 'Ma/Re(%)');
        data.addColumn('number', 'Ma/Re trung bình lũy kế (%)');
        data.addRows([
<?php
foreach ($per_day as $key => $value) {
    $date = explode('/', $key);
    echo "[new Date(" . $date[2] . ", " . ($date[1] - 1) . "," . $date[0] . ")," . $value['Ma_Re'] ."," . $value['Ma_Re_luy_ke_trung_binh'] . "],";
}
?>
        ]);
        var materialOptions = {
            title: 'Ma_Re(%) HÀNG NGÀY',
            series: {
                0: {axis: 'contact', type: 'line'},
            },
            axes: {
                y: {
                    contact: {label: 'Ma_Re(%)'}
                }
            }
        };
        function drawMaterialChart() {
            var materialChart = new google.visualization.ComboChart(chartMa_Re);
            materialChart.draw(data, materialOptions);
        }
        drawMaterialChart();
    }

</script>

<!-- Vẽ biểu đồ giá C3-->
<div id="chart_price_C3" style="width: 100%; height: 500px;"></div>
<script>
    function drawpriceC3() {
        var priceC3 = document.getElementById('chart_price_C3');
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'day');
        data.addColumn('number', 'Giá L1');
        data.addColumn('number', 'Giá L1 trung bình lũy kế');
        data.addRows([
<?php
foreach ($per_day as $key => $value) {
    $date = explode('/', $key);
    echo "[new Date(" . $date[2] . ", " . ($date[1] - 1) . "," . $date[0] . ")," . $value['price_l1'] ."," . $value['price_l1_luy_ke_trung_binh'] . "],";
}
?>
        ]);
        var materialOptions = {
            title: 'GIÁ L1 HÀNG NGÀY',
            series: {
                0: {axis: 'contact', type: 'line'},
            },
            axes: {
                y: {
                    contact: {label: 'Số lượng contact'}
                }
            }
        };
        function drawMaterialChart() {
            var materialChart = new google.visualization.ComboChart(priceC3);
            materialChart.draw(data, materialOptions);
        }
        drawMaterialChart();
    }

</script>


<!-- Vẽ biểu đồ Chi marketing từng kênh-->
<div id="chart_spend_each" style="width: 100%; height: 500px;"></div>
<script>
    function drawSpendeach() {

            var chartspendeach = document.getElementById('chart_spend_each');

            var data = new google.visualization.DataTable();

            data.addColumn('date', 'day');
            data.addColumn('number', 'Tổng phí marketing');
            data.addColumn('number', 'Facebook ads');
            data.addColumn('number', 'Email Getresponse');
            data.addColumn('number', 'Google Adwords');
            
            data.addRows([
<?php
foreach ($per_day as $key => $value) {
    $date = explode('/', $key);
    echo "[new Date(" . $date[2] . ", " . ($date[1] - 1) . "," . $date[0] . ")," . $value['sum_perday_spend'] . "," . $value['fb'] . "," . $value['em'] . "," . $value['ga'] . "],";
}
?>
            ]);
            var options = {
                title: 'Chi phí giữa các kênh',
                series: {
                    0: {axis: 'vnd', type: 'bars'},
                    1: {axis: 'vnd', type: 'bars'},
                    2: {axis: 'vnd', type: 'bars'},
                    3: {axis: 'vnd', type: 'bars'}
                },
                axes: {
                    y: {
                        vnd: {label: 'VNĐ'}
                    }
                }
            };
            function drawMaterialChart() {
                var materialChart = new google.visualization.ComboChart(chartspendeach);
                materialChart.draw(data, options);
            }
            drawMaterialChart();
        }
</script>
