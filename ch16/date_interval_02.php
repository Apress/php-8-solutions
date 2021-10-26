<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>DateInterval: Add</title>
</head>

<body>
<?php
$xmas2021 = new DateTime('12/25/2021');
$xmas2021->add(DateInterval::createFromDateString('+12 days'));
?>
<p>Twelfth Night falls on <?= $xmas2021->format('l, F jS, Y'); ?>.</p>
</body>
</html>