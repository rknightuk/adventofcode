<?php

include_once('./input.php');

$test = 'Time:      7  15   30
Distance:  9  40  200';

// $input = $test;

$extract = function($input) {
    return array_values(array_filter(explode(' ', explode(':', $input)[1])));
};

[$times, $distances] = explode("\n", $input);
$times = $extract($times);
$distances = $extract($distances);

$wins = [];
foreach ($times as $race => $time) {
    $distance = $distances[$race];
    $winCount = 0;
    $current = 1;
    while ($current < $time) {
        $newDistance = $current * ($time - $current);
        $canWin = $newDistance > $distance;
        if ($canWin) {
            $winCount++;
        }
        $current++;
    }
    $wins[] = $winCount;
}

echo 'Total is ' . array_product($wins) . PHP_EOL;