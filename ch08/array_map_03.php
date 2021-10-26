<?php
$book = [
    'author' => 'David Powers',
    'title' => 'PHP 8 Solutions'
];
$descriptions = ['British', 'the fifth edition'];
$modified = array_map('modify', $book, $descriptions);
function modify($val, $description) {
    return "$val is $description.";
}
echo '<pre>';
print_r($book);
print_r($modified);
echo '</pre>';