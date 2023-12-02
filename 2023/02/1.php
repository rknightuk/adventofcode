<?php

include_once('./input.php');

$colors = [
    'red' => 12,
    'green' => 13,
    'blue' => 14,
];

$validGameTotal = 0;

foreach ($input as $line) {
    [$game, $games] = explode(':', $line);
    $gameId = explode(' ', $game)[1];
    $picks = explode(',', str_replace(';', ',', $games));
    $gameValid = true;

    foreach ($picks as $pick)
    {
        if (!$gameValid) continue;
        $pick = trim($pick);
        $color = explode(' ', $pick)[1];
        $amount = explode(' ', $pick)[0];
        if ($amount > $colors[$color]) {
            echo 'Game ' . $gameId . ' is invalid' . PHP_EOL;
            $gameValid = false;
            continue;
        }
    }

    if ($gameValid) {
        echo "$gameId is valid" . PHP_EOL;
        $validGameTotal += $gameId;
    }
}

echo $validGameTotal . PHP_EOL;