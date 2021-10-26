<?php
$noone = [];
$solo = ['Janis Joplin'];
$duo = ['Simon', 'Garfunkel'];
$threesome = ['Peter', 'Paul', 'Mary'];
$fab_four = ['John', 'Paul', 'George', 'Ringo'];
$too_many = ['Dave Dee', 'Dozy', 'Beaky', 'Mick', 'Tich'];

function with_commas(array $array, int $max = 4) {
    $length = count($array);
    $result = match (true) {
        $length === 0 => '',
        $length === 1 => array_pop($array),
        $length === 2 => implode(' and ', $array),
        $length === $max + 1 => implode(', ', array_slice($array, 0, $max)) . ' and one other',
        $length > $max + 1 => implode(', ', array_slice($array, 0, $max)) . ' and others',
        default => implode(', ', array_slice($array, 0, $length -1)) . ' and ' . array_pop($array)
    };
    return $result;
}
echo with_commas($too_many, 3);