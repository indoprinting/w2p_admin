        <?php
                if (isset($daily_chart)) :
                    $daily = [];
                    foreach ($daily_chart as $chart) :
                        $data_temp = ['label' => $chart['day'], 'total' => $func->rupiah($chart['total']), 'y' => $chart['id_order']];
                        array_push($daily, $data_temp);
                    endforeach;
                ?>
        <script type="text/javascript">
            window.onload = function() {
                var chart = new CanvasJS.Chart("dailyVisit", {
                    title: {
                        text: "Transaksi harian"
                    },
                    axisX: {
                        title: "Tanggal",
                    },
                    axisY: {
                        title: "Jumlah transaksi"
                    },
                    data: [{
                        type: "line",
                        toolTipContent: "Pendapatan hari ini : {total} <br> Checkout (Paid) : {y} order",
                        dataPoints: < ? = json_encode($daily, JSON_NUMERIC_CHECK); ? >
                    }]
                });
                chart.render();
            }
        </script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <div id="dailyVisit" style="height: 300px; width: 100%;margin-bottom:20px"></div>
        <?php endif; ?>
