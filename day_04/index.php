<?php

// $input = file_get_contents($input_file_base_path . 'sample_input.txt');
$input = file_get_contents($input_file_base_path . 'input_01.txt');
$input_array = explode("\n", $input);
unset($input);

$numbers = explode(',', $input_array[0]);
unset($input_array[0]);

$boards = [];
$board_count = 0;
$rows = [];
foreach ($input_array as $i) {
    if (!(bool) $i) {
        continue;
    }
    $row = [];
    foreach (explode(' ', preg_replace("/[\s]+/", " ", trim($i))) as $ele) {
        $row[] = ['marked' => 0, 'val' => $ele];
    }
    $rows[] = $row;
    if (count($rows) === 5) {
        $boards[$board_count] = $rows;
        $rows = [];
        $board_count++;
    }
}

unset($rows);
unset($input_array);

function markNumber(&$board, $number)
{
    foreach ($board as $i => $row) {
        $number_found = false;
        foreach ($row as $j => $cell) {
            if ($cell['val'] === $number) {
                $board[$i][$j]['marked'] = 1;
                $number_found = false;
                break;
            }
        }
        if ($number_found) {
            break;
        }
    }
}

function checkRowWise($board)
{
    $row_filled = false;
    foreach ($board as $i => $row) {
        $cell_marked = 0;
        foreach ($row as $j => $cell) {
            if ($cell['marked'] === 1) {
                $cell_marked++;
            }
        }
        if ($cell_marked === 5) {
            $row_filled = true;
            break;
        }
    }
    return $row_filled;
}

function checkColumnWise($board)
{
    $column_filled = false;
    for ($i = 0; $i < 5; $i++) {
        $cell_marked = 0;
        for ($j = 0; $j < 5; $j++) {
            if ($board[$j][$i]['marked'] === 1) {
                $cell_marked++;
            }
        }
        if ($cell_marked === 5) {
            $column_filled = true;
            break;
        }
    }
    return $column_filled;
}

echo "\n\t>>> Executing Part 01 of puzzle <<<\n";
require 'part_01.php';
echo "\n\t>>> Executing Part 02 of puzzle <<<\n";
require 'part_02.php';
