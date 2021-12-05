<?php

// $input = file_get_contents($input_file_base_path . 'sample_input.txt');
$input = file_get_contents($input_file_base_path . 'input_01.txt');
$input_array = explode("\n", $input);
unset($input);

function incrementCoordinate(&$coordinates, $x, $y)
{
    $key = $x . ',' . $y;
    if (!array_key_exists($key, $coordinates)) {
        $coordinates[$key] = 1;
    } else {
        $coordinates[$key]++;
    }
}

function getVerticalPoints(&$coordinates, $y1, $y2, $x)
{
    for ($i = $y1; $i <= $y2; $i++) {
        incrementCoordinate($coordinates, $x, $i);
        // $coordinate_pairs[] = [
        //     'key' => $x . ',' . $i,
        //     'x' => $x,
        //     'y' => $i,
        // ];
    }
}

function getHorizontalPoints(&$coordinates, $x1, $x2, $y)
{
    for ($i = $x1; $i <= $x2; $i++) {
        incrementCoordinate($coordinates, $i, $y);
        // $coordinate_pairs[] = [
        //     'key' => $i . ',' . $y,
        //     'x' => $i,
        //     'y' => $y,
        // ];
    }
}

function getDiagonalPoints(&$coordinates, $x1, $y1, $x2, $y2)
{
    $incremental = true;
    $y = $y1;
    if ($y1 > $y2) {
        $incremental = false;
    }
    for ($i = $x1; $i <= $x2; $i++) {
        incrementCoordinate($coordinates, $i, $y);
        // $coordinate_pairs[] = [
        //     'key' => $i . ',' . $y,
        //     'x' => $i,
        //     'y' => $y,
        // ];
        if ($incremental) {
            $y++;
        } else {
            $y--;
        }
    }
}

function checkPoints(&$coordinates, &$max, $input_array, $include_diagonal_lines = false)
{
    $aligned_vertical = 'vertical';
    $aligned_horizontal = 'horizontal';
    $aligned_diagonal = 'diagonal';
    foreach ($input_array as $i) {
        if (!(bool) $i) {
            continue;
        }
        // $coordinate_pairs = [];
        preg_match_all('!\d+!', $i, $matches);
        $line = $matches[0];
        $temp_max = max($line);
        if ($temp_max > $max) {
            $max = $temp_max;
        }
        $x1 = $line[0];
        $y1 = $line[1];
        $x2 = $line[2];
        $y2 = $line[3];
        unset($line);
        $aligned = null;
        $incremental = true;
        if ($x1 === $x2) {
            $aligned = $aligned_vertical;
            if ($y1 > $y2) {
                $incremental = false;
                getVerticalPoints($coordinates, $y2, $y1, $x1);
                // getVerticalPoints($coordinate_pairs, $y2, $y1, $x1);
            } else {
                getVerticalPoints($coordinates, $y1, $y2, $x1);
            }
        } elseif ($y1 === $y2) {
            $aligned = $aligned_horizontal;
            if ($x1 > $x2) {
                $incremental = false;
                getHorizontalPoints($coordinates, $x2, $x1, $y1);
            } else {
                getHorizontalPoints($coordinates, $x1, $x2, $y1);
            }
        } elseif ($include_diagonal_lines) {
            $aligned = $aligned_diagonal;
            if ($x1 > $x2) {
                $incremental = false;
                getDiagonalPoints($coordinates, $x2, $y2, $x1, $y1);
            } else {
                getDiagonalPoints($coordinates, $x1, $y1, $x2, $y2);
            }

        }
        // $lines[] = [
        //     'input' => $i,
        //     'aligned' => $aligned,
        //     'incremental' => $incremental,
        //     'coordinate_pairs' => $coordinate_pairs,
        // ];
    }
}

function calculateOverlappingPoints($origin, $max, $coordinates)
{
    $overlapping = 0;
    for ($i = $origin; $i <= $max; $i++) {
        for ($j = $origin; $j <= $max; $j++) {
            // echo " ($j,$i)";
            // Note: Use $j . ',' . $i to draw the point in same manner as given in example
            $key = $i . ',' . $j;
            if (array_key_exists($key, $coordinates)) {
                // echo ' ' . $coordinates[$key];
                if ($coordinates[$key] >= 2) {
                    $overlapping++;
                }
            } else {
                // echo ' .';
            }
        }
        // echo "\n";
    }
    return $overlapping;
}

echo "\n\t>>> Executing Part 01 of puzzle <<<\n";
require 'part_01.php';
echo "\n\t>>> Executing Part 02 of puzzle <<<\n";
require 'part_02.php';
