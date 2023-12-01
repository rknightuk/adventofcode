<?php

include_once('./input.php');

$test = [
    '1abc2',
    'pqr3stu8vwx',
    'a1b2c3d4e5f',
    'treb7uchet',
];

// $input = $test;

$result = array_reduce($input, function ($total, $line) {
    // get all digits
    preg_match_all('/\d/', $line, $matches);

    $first = $matches[0][0];

    // get the last element
    $last = end($matches[0]);

    $total += $first . $last;
    return $total;
}, 0);

echo 'The total is ' . $result . PHP_EOL;