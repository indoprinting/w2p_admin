<script type="text/javascript">
    window.onload = function() {
        var chart = new CanvasJS.Chart("best_seller", {
            title: {
                text: "Produk terlaris"
            },
            axisX: {
                // title: "Urutan terlaris",
                labelAngle: -30,
                interval: 1
            },
            axisY: {
                title: "Qty terjual"
            },
            data: [{
                type: "column",
                showInLegend: true,
                legendText: "Semua outlet",
                toolTipContent: "{name} <br> Terjual : {y} pcs <br> Value : {total}",
                dataPoints: <?= $data_chart ?>
            }]
        });
        chart.render();
    }
</script>
<div id="best_seller" style="height: 300px; width: 100%;margin-bottom:20px"></div>
