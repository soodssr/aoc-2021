<?php

// $input = file_get_contents($input_file_base_path . 'sample_input.txt');
$input = file_get_contents($input_file_base_path . 'input_01.txt');
$input_array = explode("\n", $input);
unset($input);

$total_octopuses_flashed_at_a_step = 0;

echo "\n\t>>> Executing Part 01 of puzzle <<<\n";
require 'part_01.php';
echo "\n\t>>> Executing Part 02 of puzzle <<<\n";
require 'part_02.php';
