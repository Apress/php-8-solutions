<!DOCTYPE HTML>
<html>
<head>
<meta  charset="utf-8">
<title>Multidimensional array: print_r()</title>
</head>

<body>
<?php
$books = [
    [
        'title'     => 'PHP 8 Solutions: Dynamic Web Design Made Easy',
        'author'    => 'David Powers'
    ],
    [
        'title'     => 'PHP 8 Revealed',
        'author'    => 'Gunnard Engebreth'
    ]
];
print_r($books);
?>
</body>
</html>
