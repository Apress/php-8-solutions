<?php
$numbers = [2, 4, 7];
$doubled = array_map(fn ($num) => $num * 2, $numbers);
echo '<pre>';
print_r($numbers);
print_r($doubled);
echo '</pre>';
