<?php
$num = 5;
$float = 98.6;
$num_string = '5';
$float_string = '98.6';
$languages = ['English', 'French', 'German', 'Spanish'];
$OK = true;
$not_OK = false;
$now = new DateTime();
$nonexistent; // This will generate a warning about an undefined
               // variable because no value has been assigned to it
var_dump($num);