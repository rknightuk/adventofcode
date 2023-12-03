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

$explodedInput = explode("\n", $input);

$strippedInput = str_replace('.', ' ', $input);

$total = 0;

foreach (explode("\n", $strippedInput) as $index => $line)
{
    preg_match_all('/\d+/', $line, $numbers, PREG_OFFSET_CAPTURE);
    preg_match_all('/\D/', str_replace(' ', '', $line), $symbols);

    $current = $explodedInput[$index] ?? '';
    $previous = $explodedInput[$index - 1] ?? '';
    $next = $explodedInput[$index + 1] ?? '';

    foreach ($numbers[0] as $numberData)
    {
        [$number, $position] = $numberData;
        $range = [
            $position === 0 ? $position : $position - 1,
            $position + strlen($number) + 1 - ($position === 0 ? $position : $position - 1),
        ];

        $findInCurrent = substr($current, $range[0], $range[1]);
        $findInPrevious = substr($previous, $range[0], $range[1]);
        $findInNext = substr($next, $range[0], $range[1]);
        preg_match_all('/[^0-9\.]/', $findInCurrent, $sc);
        preg_match_all('/[^0-9\.]/', $findInPrevious, $sp);
        preg_match_all('/[^0-9\.]/', $findInNext, $sn);

        if (
            count($sc[0]) > 0 || count($sp[0]) > 0 || count($sn[0]) > 0
        ) {
            $total += $number;
        }
    }
}

echo 'Current total ' . $total . PHP_EOL;