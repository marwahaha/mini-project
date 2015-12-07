<!DOCTYPE html>

<html>

<head>
    <title>Mini-Project</title>
    <meta charset="utf-8" />
    <!--Bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--amcharts-->
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/serial.js"></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
    <script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/none.js"></script>

    <?php
        // Get contents of JSON file and decode contents

        $jsonFile = file_get_contents('overview.json');
        $jsonFileDecoded = json_decode($jsonFile, true);

        // Set geo location

        setlocale(LC_ALL, '');
        $locale = localeconv();

        // Function for field total from JSON data

        function fieldTotal($fieldName) {
            global $jsonFileDecoded, $locale;
            $total = 0;

            foreach($jsonFileDecoded as $field => $value) {
                $total += $value[$fieldName];
            }
            if ($fieldName == "Revenue") {
                return $locale['currency_symbol']. number_format($total, 0, $locale['decimal_point'], $locale['thousands_sep']);
            }
            else {
                return $total;
            }
        }
    ?>

    <script type="text/javascript">
        // Bring in JSON file

        var chartData = <?php echo $jsonFile; ?>;
        var pieChartData = [{"Title": "Active Users", "Total": <?php echo fieldTotal("Active_Users") ?>},
                            {"Title": "Total Users", "Total": <?php echo fieldTotal("Total_Users") ?>}];

        // LINE CHART

        AmCharts.ready(function () {
            var chart = new AmCharts.AmSerialChart();
            
            // Chart title

            chart.addTitle("Revenue to Total Users", 16);

            // Data being used

            chart.dataProvider = chartData;
            chart.categoryField = "Events";

            // Title for value axis

            var valueAxis = new AmCharts.ValueAxis();
            valueAxis.title = "Revenue";
            chart.addValueAxis(valueAxis);

            // Graph and graph settings

            var graph = new AmCharts.AmGraph();
            graph.valueField = "Revenue";
            graph.type = "line";
            graph.fillAlphas = 0.70;
            graph.bullet = "round";
            graph.lineColor = "#34adff";
            graph.balloonText = "Revenue: <strong>[[value]]</strong>";
            chart.addGraph(graph);

            // Grid count and label on category axis

            var categoryAxis = chart.categoryAxis;
            categoryAxis.autoGridCount  = false;
            categoryAxis.gridCount = chartData.length;
            categoryAxis.gridPosition = "start";
            categoryAxis.labelRotation = 50;
            categoryAxis.title = "Total Users";

            // SCROLLBAR

            var chartScrollbar = new AmCharts.ChartScrollbar();
            chartScrollbar.graph = graph;
            chartScrollbar.scrollbarHeight = 40;
            chartScrollbar.color = "#FFFFFF";
            chartScrollbar.autoGridCount = true;
            chart.addChartScrollbar(chartScrollbar);

            // Display chart

            chart.write('chartdivLine');
        });

        // PIE CHART

        AmCharts.ready(function () {
            chart = new AmCharts.AmPieChart();

            // Chart title

            chart.addTitle("Total and Active Users", 16);

            // Data being used

            chart.dataProvider = pieChartData;
            chart.titleField = "Title";
            chart.valueField = "Total";
            
            // Animation

            chart.sequencedAnimation = false;
            chart.startEffect = "elastic";
            chart.innerRadius = "34%";
            chart.startDuration = 2;
            chart.labelRadius = 15;
            chart.balloonText = "[[title]]</br><span style='font-size:14px'><strong>[[value]]</strong> ([[percents]]%)</span>";

            // 3D effect

            chart.depth3D = 10;
            chart.angle = 25;

            // Display chart

            chart.write("chartdivDonut");
        });
    </script>
</head>

<body>
    <!-- Navigation bar at top -->

    <nav class="navbar navbar-inverse" id="backToTheTop">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Kochava Mini-Project</a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="task1Tables.php">Task 1: Tables</a></li>
                    <li><a href="task2Charts.php">Task 2: Charts</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Task 2 Chart 1: A line graph that charts revenue & events -->

    <div id="chartdivLine" style="width: auto; height: 500px; margin: 25px;"></div>

    <hr/>

    <!-- Task 2 Chart 1: A donut chart that shows total to active users -->

    <div id="chartdivDonut" style="width:auto; height:500px;"></div>

    <!-- Link back to the top -->

    <div class="container">
        <a href="#backToTheTop" class="btn">Back to the Top</a>
        <br/>
        <br/>
    </div>
</body>

</html>
