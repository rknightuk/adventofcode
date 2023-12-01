<?php

include_once('./input.php');

$test = [
    'two1nine',
    'eightwothree',
    'abcone2threexyz',
    'xtwone3four',
    '4nineeightseven2',
    'zoneight234',
    '7pqrstsixteen',
];

$lettersToNumbers = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
];

// $input = $test;

$result = array_reduce($input, function ($total, $line) use ($lettersToNumbers) {
    preg_match_all('/(?=(\d|one|two|three|four|five|six|seven|eight|nine))/', $line, $matches);

    $first = $lettersToNumbers[$matches[1][0]] ?? $matches[1][0];
    $last = $lettersToNumbers[end($matches[1])] ?? end($matches[1]);

    $total += $first . $last;
    return $total;
}, 0);

echo 'The total is ' . $result . PHP_EOL;