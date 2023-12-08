<?php

include_once('./input.php');

$test = 'RL

AAA = (BBB, CCC)
BBB = (DDD, EEE)
CCC = (ZZZ, GGG)
DDD = (DDD, DDD)
EEE = (EEE, EEE)
GGG = (GGG, GGG)
ZZZ = (ZZZ, ZZZ)';

$test2 = 'LLR

AAA = (BBB, BBB)
BBB = (AAA, ZZZ)
ZZZ = (ZZZ, ZZZ)';

// $input = $test2;

$input = array_filter(explode("\n", $input));

$instructions = str_split($input[0]);
unset($input[0]);

$elements = [];
foreach ($input as $value) {
    $data = explode(' = ', $value);
    $elementKey = $data[0];
    [$L, $R] = explode(', ', str_replace(')', '', str_replace('(', '', $data[1])));
    $elements[$elementKey] = compact('L', 'R');
}

$element = 'AAA';
$found = false;
$instructionIndex = 0;
$steps = 0;

while (!$found) {
    if ($instructionIndex === count($instructions)) {
        $instructionIndex = 0;
    }
    $instruction = $instructions[$instructionIndex];
    $element = $elements[$element][$instruction];
    if ($element === 'ZZZ')
    {
        $found = true;
    }

    $instructionIndex++;
    $steps++;
}

echo 'It takes ' . $steps . ' steps to reach ZZZ' . PHP_EOL;