<script type="text/javascript">
    const rupiah = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    });
    window.onload = function() {
        var chart = new CanvasJS.Chart("dailyVisit", {
            title: {
                text: "Grafik pemasukan harian"
            },
            axisX: {
                title: "Total : " + rupiah.format(<?= $total ?>),
            },
            axisY: {
                title: "Jumlah pemasukan"
            },
            data: [{
                type: "line",
                toolTipContent: "Revenue : Rp {y} <br> Order (Paid) : {id_order} <br> Rata-rata : Rp {avg}",
                dataPoints: <?= $chart ?>
            }]
        });
        var chart_outlet = new CanvasJS.Chart("outletChart", {
            title: {
                text: "Grafik pemasukan Outlet"
            },
            axisX: {
                title: "Outlet",
            },
            axisY: {
                title: "Jumlah pemasukan"
            },
            data: [{
                type: "line",
                toolTipContent: "Revenue : Rp {y} <br> Order (Paid) : {id_order}",
                dataPoints: <?= $chart_outlet ?>
            }]
        });
        chart.render();
        chart_outlet.render();
    }
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div id="dailyVisit" style="height: 300px; width: 100%;margin-bottom:20px"></div>
<div class="row ">
    <div class="col-md-3 col-sm-6">
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fal fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Rata-rata Revenue</span>
                <span class="info-box-number">{{ $avg_7['avg'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fal fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Rata-rata Order</span>
                <span class="info-box-number">{{ $avg_7['count_order'] }}</span>
            </div>
        </div>
    </div>
</div>
<div id="outletChart" style="height: 300px; width: 100%;margin-bottom:20px"></div>
