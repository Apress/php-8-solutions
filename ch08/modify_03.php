<?php
$book = [
    'author' => 'David Powers',
    'title' => 'PHP 8 Solutions'
];
foreach ($book as $key => &$value) {
    $book[$key] = strtoupper($value);
}
unset($value);
echo '<pre>';
print_r($book);
echo '</pre>';