<?php

include_once('./input.php');

$test = 'Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11';

// $input = $test;
$total = 0;

$lines = explode("\n", $input);

foreach ($lines as $line)
{
    [$winners, $have] = explode('|', $line);
    $winners = explode(' ', trim($winners));
    $have = explode(' ', trim($have));

    $winningNumbers = array_filter(array_intersect($have, $winners));

    $currentTotal = 0;
    foreach ($winningNumbers as $win)
    {
        if ($currentTotal === 0) {
            $currentTotal = 1;
            continue;
        }

        $currentTotal = $currentTotal * 2;

    }

    $total += $currentTotal;
}



echo 'Current total ' . $total . PHP_EOL;