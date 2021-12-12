<?php

/**
 * --- Part Two ---

Through a little deduction, you should now be able to determine the remaining digits. Consider again the first example above:

acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab |
cdfeb fcadb cdfeb cdbaf

After some careful analysis, the mapping between signal wires and segments only make sense in the following configuration:

dddd
e    a
e    a
ffff
g    b
g    b
cccc

So, the unique signal patterns would correspond to the following digits:

- acedgfb: 8
- cdfbe: 5
- gcdfa: 2
- fbcad: 3
- dab: 7
- cefabd: 9
- cdfgeb: 6
- eafb: 4
- cagedb: 0
- ab: 1

Then, the four digits of the output value can be decoded:

- cdfeb: 5
- fcadb: 3
- cdfeb: 5
- cdbaf: 3

Therefore, the output value for this entry is 5353.

Following this same process for each entry in the second, larger example above, the output value of each entry can be determined:

- fdgacbe cefdb cefbgd gcbe: 8394
- fcgedb cgb dgebacf gc: 9781
- cg cg fdcagb cbg: 1197
- efabcd cedba gadfec cb: 9361
- gecf egdcabf bgf bfgea: 4873
- gebdcfa ecba ca fadegcb: 8418
- cefg dcbef fcge gbcadfe: 4548
- ed bcgafe cdgba cbgef: 1625
- gbdfcae bgc cg cgb: 8717
- fgae cfgab fg bagce: 4315

Adding all of the output values in this larger example produces 61229.

For each entry, determine all of the wire/segment connections and decode the four-digit output values. What do you get if you add up all of the output values?

Input: input_01.txt

 */

$sum_total = 0;

$slot_positions = [
    1 => ['original' => 'a', 'new' => ''],
    2 => ['original' => 'b', 'new' => ''],
    3 => ['original' => 'c', 'new' => ''],
    4 => ['original' => 'd', 'new' => ''],
    5 => ['original' => 'e', 'new' => ''],
    6 => ['original' => 'f', 'new' => ''],
    7 => ['original' => 'g', 'new' => ''],
];

$digit_config = [
    0 => ['original' => 'abcefg', 'positions_used' => [1, 2, 3, 5, 6, 7], 'new' => ''],
    1 => ['original' => 'cf', 'positions_used' => [3, 6], 'new' => ''],
    2 => ['original' => 'acdeg', 'positions_used' => [1, 3, 4, 5, 7], 'new' => ''],
    3 => ['original' => 'acdfg', 'positions_used' => [1, 3, 4, 6, 7], 'new' => ''],
    4 => ['original' => 'bcdf', 'positions_used' => [2, 3, 4, 6], 'new' => ''],
    5 => ['original' => 'abdfg', 'positions_used' => [1, 2, 4, 6, 7], 'new' => ''],
    6 => ['original' => 'abdefg', 'positions_used' => [1, 2, 4, 5, 6, 7], 'new' => ''],
    7 => ['original' => 'acf', 'positions_used' => [1, 3, 6], 'new' => ''],
    8 => ['original' => 'abcdefg', 'positions_used' => [1, 2, 3, 4, 5, 6, 7], 'new' => ''],
    9 => ['original' => 'abcdfg', 'positions_used' => [1, 2, 3, 4, 6, 7], 'new' => ''],
];

function sortSegmentCharacters($code)
{
    $_code_array = str_split($code);
    sort($_code_array);
    return implode('', $_code_array);
}

function determineDigit(&$signal_patterns, $number)
{
    $numbers = [
        1 => 2,
        4 => 4,
        7 => 3,
        8 => 7,
    ];
    $_code = '';
    foreach ($signal_patterns as $code) {
        if (strlen($code) == $numbers[$number]) {
            $_code = sortSegmentCharacters($code);
            break;
        }
    }
    return $_code;
}

foreach ($input_array as $i) {
    $temp_digit_config = $digit_config;
    $temp_slot_position = $slot_positions;
    echo "\t $i ";
    $i = explode(' | ', $i);
    $signal_patterns = explode(' ', $i[0]);
    $output_value = explode(' ', $i[1]);
    $number = '';

    $temp_digit_config[1]['new'] = determineDigit($signal_patterns, 1);
    $one_digit_characters = str_split($temp_digit_config[1]['new']);

    $temp_digit_config[4]['new'] = determineDigit($signal_patterns, 4);
    $second_and_forth_position = array_diff(
        str_split($temp_digit_config[4]['new']),
        $one_digit_characters
    );
    $second_and_forth_position = array_values($second_and_forth_position);

    $temp_digit_config[7]['new'] = determineDigit($signal_patterns, 7);
    $seven_digit_characters = str_split($temp_digit_config[7]['new']);
    $diff = array_diff($seven_digit_characters, $one_digit_characters);
    $temp_slot_position[1]['new'] = array_pop($diff);

    $temp_three_digit_1 = sortSegmentCharacters(
        $temp_slot_position[1]['new']
        . $temp_digit_config[1]['new'] . $second_and_forth_position[0]
    );
    $temp_three_digit_2 = sortSegmentCharacters(
        $temp_slot_position[1]['new']
        . $temp_digit_config[1]['new'] . $second_and_forth_position[1]
    );
    foreach ($signal_patterns as $code) {
        if (strlen($code) === 5) {
            $code_characters = str_split($code);
            $three_digit_characters = str_split($temp_three_digit_1);
            $intersect = array_intersect($code_characters, $three_digit_characters);
            if (count($intersect) === count($three_digit_characters)) {
                $temp_slot_position[2]['new'] = $second_and_forth_position[1];
                $temp_slot_position[4]['new'] = $second_and_forth_position[0];
                $temp_digit_config[3]['new'] = sortSegmentCharacters($code);
                break;
            }
            $code_characters = str_split($code);
            $three_digit_characters = str_split($temp_three_digit_2);
            $intersect = array_intersect($code_characters, $three_digit_characters);
            if (count($intersect) === count($three_digit_characters)) {
                $temp_slot_position[2]['new'] = $second_and_forth_position[0];
                $temp_slot_position[4]['new'] = $second_and_forth_position[1];
                $temp_digit_config[3]['new'] = sortSegmentCharacters($code);
                break;
            }
        }
    }
    unset($temp_three_digit_1);
    unset($temp_three_digit_2);

    $forth_and_seventh_position = array_diff(str_split($temp_digit_config[3]['new']), str_split($temp_digit_config[7]['new']));
    $forth_position = array_intersect($forth_and_seventh_position, $second_and_forth_position);
    $seventh_position = array_diff($forth_and_seventh_position, $forth_position);
    $temp_slot_position[7]['new'] = array_pop($seventh_position);

    $temp = '';
    foreach ($temp_digit_config[5]['positions_used'] as $pos) {
        if ($pos == 6) {
            continue;
        }
        $temp .= $temp_slot_position[$pos]['new'];
    }
    $temp_fifth_digit_1 = sortSegmentCharacters($temp . $one_digit_characters[0]);
    $temp_fifth_digit_2 = sortSegmentCharacters($temp . $one_digit_characters[1]);
    foreach ($signal_patterns as $code) {
        if (strlen($code) === 5) {
            $code = sortSegmentCharacters($code);
            if ($code === $temp_fifth_digit_1) {
                $temp_slot_position[3]['new'] = $one_digit_characters[1];
                $temp_slot_position[6]['new'] = $one_digit_characters[0];
                $temp_digit_config[5]['new'] = $code;
            } elseif ($code === $temp_fifth_digit_2) {
                $temp_slot_position[3]['new'] = $one_digit_characters[0];
                $temp_slot_position[6]['new'] = $one_digit_characters[1];
                $temp_digit_config[5]['new'] = $code;
            }
        }
    }

    foreach ($temp_digit_config[9]['positions_used'] as $pos) {
        $temp_digit_config[9]['new'] .= $temp_slot_position[$pos]['new'];
    }
    $temp_digit_config[9]['new'] = sortSegmentCharacters($temp_digit_config[9]['new']);

    $temp_digit_config[8]['new'] = determineDigit($signal_patterns, 8);
    $diff = array_diff(str_split($temp_digit_config[8]['new']), str_split($temp_digit_config[9]['new']));
    $temp_slot_position[5]['new'] = array_pop($diff);

    foreach ($temp_digit_config[2]['positions_used'] as $pos) {
        $temp_digit_config[2]['new'] .= $temp_slot_position[$pos]['new'];
    }
    $temp_digit_config[2]['new'] = sortSegmentCharacters($temp_digit_config[2]['new']);

    foreach ($temp_digit_config[6]['positions_used'] as $pos) {
        $temp_digit_config[6]['new'] .= $temp_slot_position[$pos]['new'];
    }
    $temp_digit_config[6]['new'] = sortSegmentCharacters($temp_digit_config[6]['new']);

    foreach ($temp_digit_config[0]['positions_used'] as $pos) {
        $temp_digit_config[0]['new'] .= $temp_slot_position[$pos]['new'];
    }
    $temp_digit_config[0]['new'] = sortSegmentCharacters($temp_digit_config[0]['new']);

    foreach ($output_value as $code) {
        $code = sortSegmentCharacters($code);
        for ($i = 0; $i <= 9; $i++) {
            if ($temp_digit_config[$i]['new'] === $code) {
                $number .= $i;
                break;
            }
        }
    }
    echo ">> Number: $number \n";

    echo "\t 0: {$temp_digit_config[0]['new']}";
    echo " 1: {$temp_digit_config[1]['new']}";
    echo " 2: {$temp_digit_config[2]['new']}";
    echo " 3: {$temp_digit_config[3]['new']}";
    echo " 4: {$temp_digit_config[4]['new']}";
    echo " 5: {$temp_digit_config[5]['new']}";
    echo " 6: {$temp_digit_config[6]['new']}";
    echo " 7: {$temp_digit_config[7]['new']}";
    echo " 8: {$temp_digit_config[8]['new']}";
    echo " 9: {$temp_digit_config[9]['new']}\n";

    echo "\t\t  " . $temp_slot_position[1]['new'] . "\n";
    echo "\t\t" . $temp_slot_position[2]['new'] . '   ' . $temp_slot_position[2]['new'] . "\n";
    echo "\t\t  " . $temp_slot_position[4]['new'] . "\n";
    echo "\t\t" . $temp_slot_position[5]['new'] . '   ' . $temp_slot_position[6]['new'] . "\n";
    echo "\t\t  " . $temp_slot_position[7]['new'] . "\n";

    $sum_total += (int) $number;
}

echo "\t Sum total of output values $sum_total\n";
