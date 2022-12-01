<script type="text/javascript">
    window.onload = function() {
        var chart = new CanvasJS.Chart("dailyVisit", {
            title: {
                text: "Grafik pemasukan harian"
            },
            axisX: {
                title: "Hari",
            },
            axisY: {
                title: "Jumlah pemasukan"
            },
            data: [{
                type: "line",
                toolTipContent: "Revenue : Rp {y} <br> Order (Paid) : {id_order}",
                dataPoints: <?= $chart ?>
            }]
        });
        chart.render();
    }
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div id="dailyVisit" style="height: 300px; width: 100%;margin-bottom:20px"></div>
