<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Foreach loop - book</title>
</head>

<body>
<?php
$book = [
    'title'     => 'PHP 8 Solutions: Dynamic Web Design Made Easy',
    'author'    => 'David Powers',
    'publisher' => 'Apress'
];
foreach ($book as $key => $value) {
    echo "$key: $value<br>";
}
?>
</body>
</html>
