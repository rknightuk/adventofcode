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
$lines = array_map(function($l) {
    [$_, $data] = explode(': ', $l);
    [$winners, $have] = explode('|', $data);
    $winners = explode(' ', trim($winners));
    $have = explode(' ', trim($have));
    return [
        'winners' => $winners,
        'have' => $have,
    ];
}, $lines);

$multipliers = array_fill(1, count($lines), 1);

foreach ($lines as $index => $line) {
    $cardId = $index + 1;
    $winCount = count(array_filter(array_intersect($line['have'], $line['winners'])));
    $lines[$index]['index'] = $index;
    if ($winCount === 0) {
        continue;
    }

    $windex = $cardId + 1;

    foreach (range(0, $winCount - 1) as $win) {
        $multipliers[$windex] += $multipliers[$cardId];
        $windex++;
    }
}

$winningCards = 0;
foreach ($multipliers as $card)
{
    $winningCards += $card;
}

echo 'Winning cards ' . $winningCards . PHP_EOL;
