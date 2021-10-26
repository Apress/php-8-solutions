<?php
$tracks = [
    'The Beatles' => 'With a Little Help from my Friends',
    'Joe Cocker' => 'With A Little Help From My Friends',
    'Wet Wet Wet' => 'With a Little Help from my Friends',
    'Paul McCartney' => 'Yesterday'
];
$unique = array_unique($tracks);
echo '<pre>';
print_r($unique);
echo '</pre>';