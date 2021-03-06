<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>DatePeriod: Recurring Dates</title>
    <style>
        body {
            background-color:#FFF;
            color:#000;
            font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
        }
        h1 {
            font-size:150%;
        }
        p {
            margin:0 20px;
            font-size:90%;
        }
    </style>
</head>

<body>
<h1>Second Tuesday of Each Month in 2022</h1>
<p>
    <?php
    $start = new DateTime('12/31/2021');
    $interval = DateInterval::createFromDateString('second Tuesday of next month');
    $period = new DatePeriod($start, $interval, 12, DatePeriod::EXCLUDE_START_DATE);
    foreach ($period as $date) {
        echo $date->format('l, F jS, Y') . '<br>';
    }
    ?>
</p>
</body>
</html>