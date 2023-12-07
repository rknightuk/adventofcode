<?php

include_once('./input.php');

$test = '32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483';

// $input = $test;

$lines = explode("\n", $input);

$highValues = [
    'A' => 14,
    'K' => 13,
    'Q' => 12,
    'T' => 10,
    'J' => 1,
];

$scores = [
    'AAAAA', // five of a kind / rank 7
    'AA8AA', // four of a kind / rank 6
    '23332', // full house / rank 5
    'TTT98', // three of a kind / rank 4
    '23432', // two pair / rank 3
    'A23A4', // one pair / rank 2
    '23456' // high card / rank 1
];

function calculateHandRank($counts)
{
    $count = count($counts);
    switch ($count) {
        case 2:
            return array_product(array_values($counts)) === 4 ? 6 : 5;
        case 3:
            return array_product(array_values($counts)) === 3 ? 4 : 3;
        case 4:
            return 2;
        case 5:
            return 1;
        default:
            return 7;
    }
};

$formatted = array_map(function ($line) use ($highValues) {
    [$cards, $score] = explode(' ', $line);
    $score = (int) $score;
    $counts = count_chars($cards, 1);
    if (strpos($cards, 'J') !== false) {
        // get the highest grouping character
        $highest = 0;
        $character = null;
        $index = null;
        foreach ($counts as $char => $count) {
            if (chr($char) === 'J') {
                continue;
            }
            $fChar = (int) ($highValues[chr($char)] ?? chr($char));
            if ($count === $highest) {
                // compare the numbers/cards instead of the count
                if ($fChar < $character) {
                    continue;
                }
                $highest = $count;
                $character = $fChar;
                $index = $char;
            } else if ($count > $highest) {
                $highest = $count;
                $character = $fChar;
                $index = $char;
            }
        }
        $replace = $index ? chr($index) : 'A';
        $newCards = str_replace('J', $replace, $cards);
        $counts = count_chars($newCards, 1);
    }
    $cards = str_split($cards, 1);
    $handType = calculateHandRank($counts);
    return compact('cards', 'score', 'handType');
}, $lines);

usort($formatted, function ($a, $b) use ($highValues) {
    if ($a['handType'] === $b['handType']) {
        foreach ($a['cards'] as $index => $aCard) {
            $aCard = $highValues[$aCard] ?? $aCard;
            $bCard = $b['cards'][$index];
            $bCard = $highValues[$b['cards'][$index]] ?? $b['cards'][$index];

            if ($aCard === $bCard) {
                continue;
            }

            return $aCard > $bCard ? 1 : -1;
        }
    }
    return $a['handType'] > $b['handType'] ? 1 : -1;
});

$score = 0;

foreach ($formatted as $index => $line) {
    $score += $line['score'] * ($index + 1);
}

echo $score . PHP_EOL;
