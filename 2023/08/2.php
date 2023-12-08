<?php

include_once('./input.php');

$test = 'LR

11A = (11B, XXX)
11B = (XXX, 11Z)
11Z = (11B, XXX)
22A = (22B, XXX)
22B = (22C, 22C)
22C = (22Z, 22Z)
22Z = (22B, 22B)
XXX = (XXX, XXX)';

// $input = $test;

$input = array_filter(explode("\n", $input));

$instructions = str_split($input[0]);
unset($input[0]);

$startingElements = [];
$elements = [];
foreach ($input as $value) {
    $data = explode(' = ', $value);
    $elementKey = $data[0];
    [$L, $R] = explode(', ', str_replace(')', '', str_replace('(', '', $data[1])));
    $elements[$elementKey] = compact('L', 'R');
    if (str_ends_with($elementKey, 'A')){
        $startingElements[] = $elementKey;
    }
}
$found = false;
$instructionIndex = 0;
$steps = 0;

$elementRange = range(0, count($startingElements) - 1);
$elementCount = count($startingElements);
$nextElements = [];

while (!$found) {
    if ($instructionIndex === count($instructions)) {
        $instructionIndex = 0;
    }
    $foundElements = [];
    $instruction = $instructions[$instructionIndex];
    $check = true;
    foreach ($elementRange as $er) {
        $el = empty($nextElements) ? $startingElements[$er] : $nextElements[$er];
        $foundElements[] = $elements[$el][$instruction];
    }
    echo $steps . PHP_EOL;
    $allEndWithZ = count(array_filter($foundElements, function ($fe) {
        return str_ends_with($fe, 'Z');
    })) === $elementCount;
    if ($allEndWithZ) {
        $found = true;
    }
    $nextElements = $foundElements;

    $instructionIndex++;
    $steps++;
}

echo 'It takes ' . $steps . ' steps to reach all nodes ending in Z' . PHP_EOL;