<?php

include_once('./input.php');

$test = 'seeds: 79 14 55 13

seed-to-soil map:
50 98 2
52 50 48

soil-to-fertilizer map:
0 15 37
37 52 2
39 0 15

fertilizer-to-water map:
49 53 8
0 11 42
42 0 7
57 7 4

water-to-light map:
88 18 7
18 25 70

light-to-temperature map:
45 77 23
81 45 19
68 64 13

temperature-to-humidity map:
0 69 1
1 0 69

humidity-to-location map:
60 56 37
56 93 4';

$input = $test;

$rawData = explode("\n\n", $input);
$seeds = explode(' ', str_replace('seeds: ', '', $rawData[0]));
unset($rawData[0]);

$mapData = [];

foreach ($rawData as $value) {
    $lines = explode("\n", $value);
    $mapName = str_replace(' map:', '', $lines[0]);
    unset($lines[0]);
    $mapData[$mapName] = [];
    foreach ($lines as $line)
    {
        [$destinationStart, $sourceStart, $rangeLength] = explode(' ', $line);

        $mapData[$mapName] = array_replace($mapData[$mapName], array_combine(
            range($sourceStart, $sourceStart + $rangeLength - 1),
            range($destinationStart, $destinationStart + $rangeLength - 1),
        ));
    }
}

$locations = [];

foreach ($seeds as $seed)
{
    $current = $seed;
    foreach ($mapData as $mapName => $map)
    {
        $current = $map[$current] ?? $current;
    }
    $locations[] = $current;
}

echo 'Lowest location number is ' . min($locations) . PHP_EOL;