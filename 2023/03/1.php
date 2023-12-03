<?php

include_once('./input.php');

$test = '467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..';

$input = $test;
$explodedInput = explode("\n", $input);

$strippedInput = str_replace('.', ' ', $input);

$total = 0;

foreach (explode("\n", $strippedInput) as $index => $line)
{
    preg_match_all('/\d+/', $line, $numbers);
    preg_match_all('/\D/', str_replace(' ', '', $line), $symbols);
    $numbers = array_filter($numbers[0]);
    $symbols = array_filter($symbols[0]);

    $current = $explodedInput[$index] ?? '';
    $previous = $explodedInput[$index - 1] ?? '';
    $next = $explodedInput[$index + 1] ?? '';

    foreach ($numbers as $number)
    {
        $position = strpos($line, $number);
        $range = [
            $position === 0 ? $position : $position - 1,
            $position + strlen($number) + 1,
        ];

        $findInCurrent = substr($current, $range[0], $range[1] - $range[0]);
        $findInPrevious = substr($previous, $range[0], $range[1] - $range[0]);
        $findInNext = substr($next, $range[0], $range[1] - $range[0]);
        preg_match_all('/[^0-9\.]/', $findInCurrent, $sc);
        preg_match_all('/[^0-9\.]/', $findInPrevious, $sp);
        preg_match_all('/[^0-9\.]/', $findInNext, $sn);

        if (
            count($sc[0]) > 0 || count($sp[0]) > 0 || count($sn[0]) > 0
        ) {
            $total += $number;
        } else {
            echo 'THIS NUMBER IS NOT A NUMBER . ' . $number . PHP_EOL;
        }
    }
}

echo 'Current total ' . $total . PHP_EOL;

