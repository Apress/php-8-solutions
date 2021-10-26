<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Automatic data type conversion</title>
</head>

<body>
<?php
$fruit = '2 apples ';
$veg = '2 carrots';
echo $fruit + $veg; // Both strings begin with a number, so are converted to numeric values
?>
</body>
</html>
