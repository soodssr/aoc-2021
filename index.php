<?php

/**
 * Advent of Code 2021 Puzzles
 * PHP version: 7.4
 */

$baseDir = __DIR__;

$days_completed = range(1, 4);

echo "Hello There! Welcome to Advent Of Code 2021.\n";
foreach ($days_completed as $_day) {
    echo "Day 0$_day Complete ($_day)\n";
}
echo "Please enter the day number, like 1 for day 01, to execute that day puzzle.\n";
echo "Run Day: ";
// $day = trim(fgets(STDIN)); // reads one line from STDIN
fscanf(STDIN, "%d\n", $day); // reads only number from STDIN

if (!is_int($day) || !in_array($day, $days_completed)) {
    echo "\nOOPS! You entered wrong choice.\n\n";
    die;
}

echo "\n\tYou have selected Day: $day...\n";

$input_file_base_path = $baseDir . '/day_0' . $day . '/';

require $input_file_base_path . '/index.php';

echo "\nExecution Completed!!!\n\n";
