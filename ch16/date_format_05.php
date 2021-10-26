<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>DateTime v date()</title>
</head>

<body>
<?php
// Wrapping the object instantiation in parentheses
// allows the format() method to be called immediately
echo "It's now " . (new DateTime())->format('g.ia') . '<br>';

// Using the date() function produces the same output for less effort
echo "It's now " . date('g.ia');
?>
</body>
</html>
