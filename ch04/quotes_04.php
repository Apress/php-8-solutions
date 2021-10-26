<!DOCTYPE HTML>
<html>
<head>
<meta  charset="utf-8">
<title>Enclosing Array Elements in Double Quotes</title>
</head>

<body>
<?php
$book = [
    'title'     => 'PHP 8 Solutions: Dynamic Web Design Made Easy',
    'author'    => 'David Powers',
    'publisher' => 'Apress'
];
echo "{$book['title']} was written by {$book['author']}.";
?>
</body>
</html>