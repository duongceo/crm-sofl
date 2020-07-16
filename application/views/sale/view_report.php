<form action="#" method="POST" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/filter'); ?>
</form>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart2);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Số contact", {role: "style"}],
            ["L1", <?php echo $L1; ?>, "#2252ab"],
            ["L2", <?php echo $L2; ?>, "#2252ab"],
            ["L6", <?php echo $L6; ?>, "#2252ab"],
            ["L7L8", <?php echo $L7L8; ?>, "#2252ab"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"},
            2]);

        var options = {
            title: "Tổng số contact",
            width: 1000,
            height: 400,
            bar: {groupWidth: "50%"},
            legend: {position: "none"}
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "%", {role: "style"}],
            ["L2/L1", <?php echo $L2pL1 = ($L1 > 0) ? round(($L2 / $L1) * 100) : 0; ?>, "<?php echo ($L2pL1 > 89) ? "#2C944A" : "red"; ?>"],
            ["L6/L2", <?php echo $L6pL2 = ($L2 > 0) ? round(($L6 / $L2) * 100) : 0; ?>, "<?php echo ($L6pL2 > 79) ? "#2C944A" : "red"; ?>"],
            ["L8/L6", <?php echo $L7L8pL6 = ($L6 > 0) ? round(($L7L8 / $L6) * 100) : 0; ?>, "<?php echo ($L7L8pL6 > 79) ? "#2C944A" : "red"; ?>"],
            ["L7L8/L1", <?php echo $L7L8pL1 = ($L1 > 0) ? round(($L7L8 / $L1) * 100) : 0; ?>, "<?php echo ($L7L8pL1 > 59) ? "#2C944A" : "red"; ?>"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"},
            2]);

        var options = {
            title: "Tỉ lệ",
            width: 1000,
            height: 400,
            bar: {groupWidth: "50%"},
            legend: {position: "none"}
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
        chart.draw(view, options);
    }
</script>
<div class="row">
    <div id="columnchart_values" class="google_chart"></div>
    <div id="columnchart_values2" class="google_chart"></div>
</div>


