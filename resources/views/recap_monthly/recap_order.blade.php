@extends('layouts.main')
@section('main')
    <script type="text/javascript">
        window.onload = function() {
            var chart = new CanvasJS.Chart("chart_order", {
                title: {
                    text: "Grafik Order Login dan Tanpa Login"
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
                        showInLegend: true,
                        name: "Login",
                        color: "red",
                        toolTipContent: "Order dengan login : {y}",
                        dataPoints: <?= $chart_login ?>
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "Tanpa login",
                        color: "purple",
                        toolTipContent: "Order tanpa login : {y}",
                        dataPoints: <?= $chart_no_login ?>
                    }
                ],
            });
            var chart_order = new CanvasJS.Chart("daily_order", {
                title: {
                    text: "Grafik Daily Order"
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
                    toolTipContent: "Jumlah Order : {y} <br> Order Paid : {paid}",
                    dataPoints: <?= $daily_order ?>
                }],
            });
            chart.render();
            chart_order.render();
        }
    </script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <div id="chart_order" style="height: 300px; width: 100%;margin-bottom:20px"></div>
    <div id="daily_order" style="height: 300px; width: 100%;margin-bottom:20px"></div>
    <form method="GET">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-self-center">
                    <input class="form-control" type="month" name="month" value="{{ request()->month }}">
                    <button class="btn btn-primary ml-2 w-25" type="submit">Ganti Bulan</button>
                </div>
            </div>
        </div>
    </form>
@endsection
