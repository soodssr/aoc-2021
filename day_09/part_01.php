<?php

/**
 * --- Day 9: Smoke Basin ---

These caves seem to be lava tubes. Parts are even still volcanically active; small hydrothermal vents release smoke into the caves that slowly settles like rain.

If you can model how the smoke flows through the caves, you might be able to avoid it and be that much safer. The submarine generates a heightmap of the floor of the nearby caves for you (your puzzle input).

Smoke flows to the lowest point of the area it's in. For example, consider the following heightmap:

2199943210
3987894921
9856789892
8767896789
9899965678

Each number corresponds to the height of a particular location, where 9 is the highest and 0 is the lowest a location can be.

Your first goal is to find the low points - the locations that are lower than any of its adjacent locations. Most locations have four adjacent locations (up, down, left, and right); locations on the edge or corner of the map have three or two adjacent locations, respectively. (Diagonal locations do not count as adjacent.)

In the above example, there are four low points, all highlighted: two are in the first row (a 1 and a 0), one is in the third row (a 5), and one is in the bottom row (also a 5). All other locations on the heightmap have some lower adjacent location, and so are not low points.

The risk level of a low point is 1 plus its height. In the above example, the risk levels of the low points are 2, 1, 6, and 6. The sum of the risk levels of all low points in the heightmap is therefore 15.

Find all of the low points on your heightmap. What is the sum of the risk levels of all low points on your heightmap?

Input Link: https://adventofcode.com/2021/day/9/input
Input: input_01.txt
 */

$sum = 0;
$low_points_map = [];

foreach ($input_array as $idx => $i) {
    $low_points = [];
    $p_idx = $idx - 1;
    $n_idx = $idx + 1;
    $previous = $next = [];
    if ($p_idx >= 0) {
        $previous = str_split($input_array[$p_idx]);
    }
    if ($n_idx < $total_rows) {
        $next = str_split($input_array[$n_idx]);
    }
    $current = str_split($i);
    foreach ($current as $k => $height) {
        if ($height == $highest) {
            continue;
        }
        $lower = $adjacent_points = 0;
        if (count($previous)) {
            $adjacent_points++;
            if ($height < $previous[$k]) {
                $lower++;
            }
        }
        if (count($next)) {
            $adjacent_points++;
            if ($height < $next[$k]) {
                $lower++;
            }
        }
        $k_p_idx = $k - 1;
        $k_n_idx = $k + 1;
        if ($k_p_idx >= 0) {
            $adjacent_points++;
            if ($height < $current[$k_p_idx]) {
                $lower++;
            }
        }
        if ($k_n_idx < count($current)) {
            $adjacent_points++;
            if ($height < $current[$k_n_idx]) {
                $lower++;
            }
        }
        if ($adjacent_points === $lower) {
            if (!array_key_exists($idx, $low_points_map)) {
                $low_points_map[$idx] = [];
            }
            $low_points_map[$idx][] = $k;
            $low_points[] = $height;
        }
    }
    $risk_level_total = 0;
    if (count($low_points)) {
        $risk_level_total = array_sum($low_points) + count($low_points);
        $sum += $risk_level_total;
    }
    echo "\t Low Points are ["
    . implode(', ', $low_points)
        . "]. Have risk level total $risk_level_total\n";
}

echo "\t Sum of the risk levels of all low points on your heightmap $sum\n";
