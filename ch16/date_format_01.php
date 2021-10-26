<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Formatting DateTime Objects</title>
</head>

<body>
<?php
$now = new DateTime();
$xmas2021 = new DateTime('12/25/2021');
?>
<p>It's now <?= $now->format('g.ia') ?> on <?= $now->format('l, F jS, Y') ?></p>
<p>Christmas 2021 falls on a <?= $xmas2021->format('l') ?></p>
</body>
</html>