<?php
$book = [
    'author' => 'David Powers',
    'title' => 'PHP 8 Solutions'
];
array_walk($book, fn (&$val) => $val = strtoupper($val));
echo '<pre>';
print_r($book);
echo '</pre>';