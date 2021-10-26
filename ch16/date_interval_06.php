<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>DatePeriod: ISO Recurring Dates</title>
</head>

<body>
<p>
    <?php
    $period = new DatePeriod('R4/2021-06-19T00:00:00Z/P10D');
    foreach ($period as $date) {
        echo $date->format('l, F j, Y') . '<br>';
    }
    ?>
</p>
</body>
</html>