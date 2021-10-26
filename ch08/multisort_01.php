<?php
$states = ['Arizona', 'California', 'Colorado', 'Florida', 'Maryland', 'New York', 'Vermont'];
$population = [7_151_502, 39_538_223, 5_773_714, 21_538_187, 6_177_224, 20_201_249, 643_077];
echo '<ul>';
for ($i = 0, $len = count($states); $i < $len; $i++) {
    echo "<li>$states[$i]: $population[$i]</li>";
}
echo '</ul>';