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
    if (str_ends_with($elementKey, 'A')) {
        $startingElements[] = $elementKey;
    }
}

$elementRange = range(0, count($startingElements) - 1);
$elementCount = count($startingElements);
$nextElements = [];

function stepsToZ($instructions, $elements, $inputElement)
{
    $element = $inputElement;
    $found = false;
    $instructionIndex = 0;
    $steps = 0;

    while (!$found) {
        if ($instructionIndex === count($instructions)) {
            $instructionIndex = 0;
        }
        $instruction = $instructions[$instructionIndex];
        $element = $elements[$element][$instruction];
        if (str_ends_with($element, 'Z')) {
            $found = true;
        }

        $instructionIndex++;
        $steps++;
    }

    return $steps;
}

$allSteps = [];

foreach ($startingElements as $element)
{
    $steps = stepsToZ($instructions, $elements, $element);
    $allSteps[] = gmp_init($steps);
}

$result = $allSteps[0];

foreach ($allSteps as $index => $step)
{
    if ($index === 0) continue;
    $result = gmp_init((string) gmp_lcm($result, $step));
}

echo (string) $result . PHP_EOL;