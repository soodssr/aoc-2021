<?php

// $input = file_get_contents($input_file_base_path . 'sample_input.txt');
$input = file_get_contents($input_file_base_path . 'input_01.txt');
$input_array = explode("\n", $input);
unset($input);

$lantern_fish = explode(',', $input_array[0]);
unset($input_array);

function calculateLanternFish($lantern_fish, $days)
{
    $old_fish_timer = 6;
    $new_fish_timer = 8;
    $total_lanternfish = count($lantern_fish);

    $remaining_day_wise_fish_count = [
        0 => 0,
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0,
    ];

    foreach ($lantern_fish as $day_remaining) {
        $remaining_day_wise_fish_count[$day_remaining]++;
    }

    echo "\t Initial  State: [" . implode(
        ', ',
        array_map(
            function ($k, $v) {
                return "$k => $v";
            },
            array_keys($remaining_day_wise_fish_count),
            array_values($remaining_day_wise_fish_count)
        )
    ) . "] Fish Count $total_lanternfish\n";

    for ($i = 1; $i <= $days; $i++) {
        echo "\t After" . sprintf("% 4d", $i)
        . (($i > 1) ? ' days' : '  day')
        . ': ['
        . implode(
            ', ',
            array_map(
                function ($k, $v) {
                    return "$k => $v";
                },
                array_keys($remaining_day_wise_fish_count),
                array_values($remaining_day_wise_fish_count)
            )
        ) . ']';
        $add_to_old_fish_timer = 0;
        foreach ($remaining_day_wise_fish_count as $day_remaining => $count) {
            $remaining_day_wise_fish_count[$day_remaining] = 0;
            if ($day_remaining === 0) {
                $add_to_old_fish_timer += $count;
            } else {
                $remaining_day_wise_fish_count[--$day_remaining] += $count;
            }

        }
        $remaining_day_wise_fish_count[$old_fish_timer] += $add_to_old_fish_timer;
        $remaining_day_wise_fish_count[$new_fish_timer] += $add_to_old_fish_timer;
        $total_lanternfish = array_sum($remaining_day_wise_fish_count);
        echo " Fish Count $total_lanternfish\n";
    }
    return $total_lanternfish;
}

echo "\n\t>>> Executing Part 01 of puzzle <<<\n";
require 'part_01.php';
echo "\n\t>>> Executing Part 02 of puzzle <<<\n";
require 'part_02.php';
