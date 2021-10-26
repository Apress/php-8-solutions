<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>DateTime::createFromFormat</title>
</head>

<body>
<?php
$xmas2021 = DateTime::createFromFormat('d/m/Y', '25/12/2021');
echo $xmas2021->format('l, jS F Y');
?>
</body>
</html>