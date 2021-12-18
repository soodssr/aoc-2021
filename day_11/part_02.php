<?php

/**
 * --- Part Two ---

It seems like the individual flashes aren't bright enough to navigate. However, you might have a better option: the flashes seem to be synchronizing!

In the example above, the first time all octopuses flash simultaneously is step 195:

After step 193:
5877777777
8877777777
7777777777
7777777777
7777777777
7777777777
7777777777
7777777777
7777777777
7777777777

After step 194:
6988888888
9988888888
8888888888
8888888888
8888888888
8888888888
8888888888
8888888888
8888888888
8888888888

After step 195:
0000000000
0000000000
0000000000
0000000000
0000000000
0000000000
0000000000
0000000000
0000000000
0000000000

If you can calculate the exact moments when the octopuses will all flash simultaneously, you should be able to navigate through the cavern. What is the first step during which all octopuses flash?

Input: input_01.txt

 */

$flash_point = 0;
do {
    $flash_point++;
    foreach ($input_array as $k => $input) {
        $present_flashing_ocotpuses[$k] = [];
        if (!is_array($input)) {
            $input = str_split($input);
            foreach ($input as $j => $l) {
                $input[$j] = (int) $l;
            }
            $input_array[$k] = $input;
        }
    }
    $total_octopuses_in_a_step = 0;
    $total_octopuses_flashed_at_a_step = 0;
    for ($row = 0; $row < count($input_array); $row++) {
        for ($octopus = 0; $octopus < count($input_array[$row]); $octopus++) {
            $total_octopuses_in_a_step++;
            if (!in_array($octopus, $present_flashing_ocotpuses[$row])) {
                $input_array[$row][$octopus]++;
                if ($input_array[$row][$octopus] > 9) {
                    flash($row, $octopus);
                }
            }
        }
    }
} while ($total_octopuses_in_a_step !== $total_octopuses_flashed_at_a_step);

echo "\t Flash Point: $flash_point\n";
