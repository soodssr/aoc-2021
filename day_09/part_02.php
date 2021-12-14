<?php

/**
 * --- Part Two ---

Next, you need to find the largest basins so you know what areas are most important to avoid.

A basin is all locations that eventually flow downward to a single low point. Therefore, every low point has a basin, although some basins are very small. Locations of height 9 do not count as being in any basin, and all other locations will always be part of exactly one basin.

The size of a basin is the number of locations within the basin, including the low point. The example above has four basins.

The top-left basin, size 3:

2199943210
3987894921
9856789892
8767896789
9899965678

The top-right basin, size 9:

2199943210
3987894921
9856789892
8767896789
9899965678

The middle basin, size 14:

2199943210
3987894921
9856789892
8767896789
9899965678

The bottom-right basin, size 9:

2199943210
3987894921
9856789892
8767896789
9899965678

Find the three largest basins and multiply their sizes together. In the above example, this is 9 * 14 * 9 = 1134.

What do you get if you multiply together the sizes of the three largest basins?

Input: input_01.txt

 */

$basin_sizes = [];
$mutliplication = 1;

function calculateBasinSize(&$points, $row_idx, $idx)
{
    global $input_array, $highest;
    $row = str_split($input_array[$row_idx]);
    $point = $row_idx . '-' . $idx;
    if ((int) $row[$idx] === $highest || in_array($point, $points)) {
        return;
    }
    echo "[$row_idx,$idx] => {$row[$idx]} ";
    $points[] = $point;
    if (($idx - 1) >= 0 && $row[$idx - 1] < $highest) {
        calculateBasinSize($points, $row_idx, ($idx - 1));
    }
    if (($idx + 1) < count($row) && $row[$idx + 1] < $highest) {
        calculateBasinSize($points, $row_idx, ($idx + 1));
    }

    if (($row_idx - 1) >= 0) {
        calculateBasinSize($points, ($row_idx - 1), $idx);
    }

    if (($row_idx + 1) < count($input_array)) {
        calculateBasinSize($points, ($row_idx + 1), $idx);
    }
}

foreach ($low_points_map as $row_idx => $height_idx) {
    foreach ($height_idx as $idx) {
        $points = [];
        echo "\t ";
        calculateBasinSize($points, $row_idx, $idx);
        $basin_sizes[] = count(array_unique($points));
        echo "\n";
    }
}

echo "\t All basin sizes [" . implode(', ', $basin_sizes) . "]\n";

sort($basin_sizes);

$mutliplication *= array_pop($basin_sizes);
$mutliplication *= array_pop($basin_sizes);
$mutliplication *= array_pop($basin_sizes);

echo "\t Multiplication ot the sizes of the three largest basins $mutliplication\n";
