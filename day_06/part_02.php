<?php

/**
 * --- Part Two ---

Suppose the lanternfish live forever and have unlimited food and space. Would they take over the entire ocean?

After 256 days in the example above, there would be a total of 26984457539 lanternfish!

How many lanternfish would there be after 256 days?

Input: input_01.txt

 */

$days = 256;
$total_lanternfish = calculateLanternFish($lantern_fish, $days);

echo "\t Count of lanternfish after $days days: $total_lanternfish\n";
