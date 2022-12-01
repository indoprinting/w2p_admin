<script type="text/javascript">
    window.onload = function() {
        var chart = new CanvasJS.Chart("dailyVisit", {
            title: {
                text: "Daily visitor"
            },
            axisX: {
                title: "Hari",
                gridThickness: 1
            },
            axisY: {
                title: "Jumlah pengunjung"
            },
            data: [{
                type: "line",
                dataPoints: <?= $chart ?>
            }]
        });
        chart.render();
    }
</script>
<div id="dailyVisit" style="height: 300px; width: 100%;margin-bottom:20px"></div>
