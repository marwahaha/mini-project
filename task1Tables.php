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

    <?php
        // Getting the contents of the JSON file and decoding it

        $jsonFile = file_get_contents('overview.json');
        $jsonFileDecoded = json_decode($jsonFile, true);

        // Setting geo location

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
</head>

<body>
    <!--Navigation bar at top-->

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

            <!-- Links between pages -->

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="task1Tables.php">Task 1: Tables</a></li>
                    <li><a href="task2Charts.php">Task 2: Charts</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Task 1 Table 1: 1 day of revenue formatted as dollars -->

    <div class="container">
        <a href="#totalUsers" class="btn">Jump to Total Users</a>

        <h2>One Day of Revenue </h2>

        <!-- Table and table headers -->

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date and Hour</th>
                    <th>Revenue</th>
                </tr>
            </thead>

            <!-- Inserts rows with date cells and revenue cells formated as dollars -->
            <!-- money_format() doesn't work on Windows so had to find alternative -->

            <tbody>
                <?php
                    foreach($jsonFileDecoded as $field => $value) {
                        echo
                            "<tr>
                                <td>" . gmdate("m/d/Y, H" , strtotime($value["TimeSegment"]["start"])) . "</td>
                                <td>" . $locale['currency_symbol'], number_format($value["Revenue"], 0, $locale['decimal_point'], $locale['thousands_sep']) . "</td>
                            <tr>";
                    }
                ?>

                <!-- Displays total revenue at the bottom of the table -->

                <tr>
                    <th>Total Revenue: </th>
                    <td>
                        <?php
                            echo fieldTotal("Revenue");
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Task 1 Table 2: 1 day of total user data with start date/time formatted as 3 letter month abreviation, 2 digit date, 4 digit year, 2 digit hour -->

    <div class="container">
        <h2 id="totalUsers">One Day of Total User Data </h2>

        <!-- Table and table headers -->

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date and Hour </th>
                    <th>Total Users </th>
                </tr>
            </thead>

            <!-- Inserts rows with date cells and total users per hour cells -->

            <tbody>
                <?php
                    foreach($jsonFileDecoded as $field => $value) {
                        echo
                            "<tr>
                                <td>" . gmdate("M d, Y, H" , strtotime($value["TimeSegment"]["start"])) . "</td>
                                <td>" . number_format($value["Total_Users"]) . "</td>
                            <tr>";
                    }
                ?>

                <!-- Displays total users at the bottom of the table -->

                <tr>
                    <th>Total Users: </th>
                    <td>
                        <?php
                            echo number_format(fieldTotal("Total_Users"));
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Link back to the top -->

        <a href="#backToTheTop" class="btn">Back to the Top</a>
        <br/>
        <br/>
    </div>
</body>

</html>
