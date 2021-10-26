<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Automatic data type conversion</title>
</head>

<body>
<?php
$fruit = '2 apples '; // will be converted to 2
$veg = 'and 2 carrots'; // cannot be converted to a numeric value
echo $fruit + $veg; // In PHP 8, using + generates a fatal TypeError
?>
</body>
</html>
