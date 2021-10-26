<?php
// https://data.sfgov.org/api/views/yitu-d5am/rows.json?accessType=DOWNLOAD
$json = file_get_contents('./data/film_locations.json');
$data = json_decode($json, true);
$col_names = array_column($data['meta']['view']['columns'], 'name');
$locations = [];
foreach ($data['data'] as $datum) {
    $locations[] = array_combine($col_names, $datum);
}

$search = 'Pier 7';
$getLocation = fn($location) => str_contains($location['Locations'], $search);
$filtered = array_filter($locations, $getLocation);
echo '<ul>';
$duplicates = [];
foreach ($filtered as $item) {
    if (in_array($item['Title'], $duplicates)) continue;
    echo "<li>{$item['Title']} ({$item['Release Year']}) filmed at {$item['Locations']}</li>";
    $duplicates[] = $item['Title'];
}
echo '</ul>';
