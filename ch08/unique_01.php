<?php
$original = ['John', 'john', 'Elton John', 'John', 'Elton John', 42, "42"];
$unique = array_unique($original);
print_r($unique);