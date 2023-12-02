<?php

include_once('./input.php');

$total = 0;

foreach ($input as $line) {
    [$game, $games] = explode(':', $line);
    $gameId = explode(' ', $game)[1];
    $picks = explode(',', str_replace(';', ',', $games));

    $blue = 0;
    $red = 0;
    $green = 0;
    
    foreach ($picks as $pick) {
        $pick = trim($pick);
        $color = explode(' ', $pick)[1];
        $amount = explode(' ', $pick)[0];
        switch ($color) {
            case 'blue':
                $blue = max($blue, $amount);
                break;
            case 'red':
                $red = max($red, $amount);
                break;
            case 'green':
                $green = max($green, $amount);
                break;
        }
    }

    $total += ($blue * $red * $green);
}

echo 'Total is ' . $total . PHP_EOL;
