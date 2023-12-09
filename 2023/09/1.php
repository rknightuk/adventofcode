<?php

include_once('./input.php');

$test = '0 3 6 9 12 15
1 3 6 10 15 21
10 13 16 21 30 45';

// $input = $test;

$lines = explode("\n", $input);

$total = 0;

foreach ($lines as $line) {
    $allNumbers = [];
    $allNumbers[] = explode(' ', $line);
    $currentIndex = 0;
    $finalNumbers = $allNumbers[array_key_last($allNumbers)];
    while (array_sum($finalNumbers) !== 0) {
        $currentRow = $allNumbers[$currentIndex];
        $new = [];
        foreach ($currentRow as $index => $number) {
            if (!isset($currentRow[$index+1])) {
                $allNumbers[] = $new;
                $finalNumbers = $allNumbers[array_key_last($allNumbers)];
                continue;
            }
            $new[] = $currentRow[$index+1] - $number;
        }
        $currentIndex++;
    }

    $finalValue = 0;

    foreach ($allNumbers as $numbers) {
        $finalValue += $numbers[array_key_last($numbers)];
    }

    $total += $finalValue;
}

echo "Total: $total" . PHP_EOL;

