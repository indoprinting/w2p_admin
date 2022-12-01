@extends('layouts.main')
@section('main')
    <form method="GET">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-self-center">
                    <input class="form-control ml-2" type="month" name="month" value="{{ request()->month }}">
                    <button class="btn btn-primary ml-2 w-25" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    @if (!in_array(Auth()->user()->id, [9, 12, 13, 27, 324]))
        <script type="text/javascript">
            window.onload = function() {
                var chart = new CanvasJS.Chart("chart_eric", {
                    title: {
                        text: "Grafik Rekapan ERIC"
                    },
                    axisX: {
                        title: "Hari",
                        interval: 1
                    },
                    axisY: {
                        title: "Jumlah order"
                    },
                    data: [{
                        type: "line",
                        toolTipContent: "Revenue : {y} <br> Order (Paid) : {jmlh_order}",
                        dataPoints: <?= $chart_eric ?>
                    }]
                });
                var chart_agung = new CanvasJS.Chart("chart_agung", {
                    title: {
                        text: "Grafik Rekapan AGUNG"
                    },
                    axisX: {
                        title: "Hari",
                        interval: 1
                    },
                    axisY: {
                        title: "Jumlah order"
                    },
                    data: [{
                        type: "line",
                        color: "purple",
                        toolTipContent: "Revenue : {y} <br> Order (Paid) : {jmlh_order}",
                        dataPoints: <?= $chart_agung ?>
                    }]
                });
                var chart_david = new CanvasJS.Chart("chart_david", {
                    title: {
                        text: "Grafik Rekapan DAVID"
                    },
                    axisX: {
                        title: "Hari",
                        interval: 1
                    },
                    axisY: {
                        title: "Jumlah order"
                    },
                    data: [{
                        type: "line",
                        color: "green",
                        toolTipContent: "Revenue : {y} <br> Order (Paid) : {jmlh_order}",
                        dataPoints: <?= $chart_david ?>
                    }]
                });
                var chart_dyah = new CanvasJS.Chart("chart_dyah", {
                    title: {
                        text: "Grafik Rekapan DYAH"
                    },
                    axisX: {
                        title: "Hari",
                        interval: 1
                    },
                    axisY: {
                        title: "Jumlah order"
                    },
                    data: [{
                        type: "line",
                        color: "green",
                        toolTipContent: "Revenue : {y} <br> Order (Paid) : {jmlh_order}",
                        dataPoints: <?= $chart_dyah ?>
                    }]
                });
                chart.render();
                chart_agung.render();
                chart_david.render();
                chart_dyah.render();
            }
        </script>
        <div id="chart_eric" style="height: 300px; width: 100%;margin-bottom:20px"></div>
        <div id="chart_agung" style="height: 300px; width: 100%;margin-bottom:20px"></div>
        <div id="chart_david" style="height: 300px; width: 100%;margin-bottom:20px"></div>
        <div id="chart_dyah" style="height: 300px; width: 100%;margin-bottom:20px"></div>
    @else
        <script type="text/javascript">
            window.onload = function() {
                var chart = new CanvasJS.Chart("chart_order", {
                    title: {
                        text: "Grafik Rekapan Tim Online"
                    },
                    axisX: {
                        title: "Hari",
                        interval: 1
                    },
                    axisY: {
                        title: "Jumlah order"
                    },
                    data: [{
                        type: "line",
                        toolTipContent: "Revenue : {y} <br> Order (Paid) : {jmlh_order}",
                        dataPoints: <?= $chart ?>
                    }],
                });
                chart.render();
            }
        </script>
        <div id="chart_order" style="height: 300px; width: 100%;margin-bottom:20px">/</div>
    @endif
@endsection
