<?php
function safe($text) {
    return htmlspecialchars($text, double_encode: false);
}

function convertToParas($text) {
    $text = trim($text);
    $text = htmlspecialchars($text, double_encode: false);
    return '<p>' . preg_replace('/[\r\n]+/', "</p>\n<p>", $text) . "</p>\n";
}

function getFirst($text, $number=2) {
    // use regex to split into sentences
    $sentences = preg_split('/([.?!]["\']?\s)/', $text, $number+1, PREG_SPLIT_DELIM_CAPTURE);
    if (count($sentences) > $number * 2) {
        $remainder = array_pop($sentences);
    } else {
        $remainder = '';
    }
    $result = [];
    $result[0] = implode('', $sentences);
    $result[1] = $remainder;
    return $result;
}

function convertDateToISO(int $month, int $day, int $year) {
    $month = trim($month);
    $day = trim($day);
    $year = trim($year);
    if (empty($month) || empty($day) || empty($year)) {
        throw new Exception('Please fill in all fields');
    } elseif (($month < 1 || $month > 12) || ($day < 1 || $day > 31) || ($year < 1000 || $year > 9999)) {
        throw new Exception('Please use numbers within the correct range');
    } elseif (!checkdate($month,$day,$year)) {
        throw new Exception('You have used an invalid date');
    }
    return sprintf('%d-%02d-%02d', $year, $month, $day);
}