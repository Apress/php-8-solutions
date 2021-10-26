<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Unpacking an array</title>
</head>

<body>
<?php
function add ($a, $b) {
    return $a + $b;
}
$nums = [1,2,4,7,9];
echo 'The result is ' . add(...$nums);
?>
</body>
</html>
