<?php

/**
 * --- Part Two ---

On the other hand, it might be wise to try a different strategy: let the giant squid win.

You aren't sure how many bingo boards a giant squid could play at once, so rather than waste time counting its arms, the safe thing to do is to figure out which board will win last and choose that one. That way, no matter which boards it picks, it will win for sure.

In the above example, the second board is the last to win, which happens after 13 is eventually called and its middle column is completely marked. If you were to keep playing until this point, the second board would have a sum of unmarked numbers equal to 148 for a final score of 148 * 13 = 1924.

Figure out which board will win last. Once it wins, what would its final score be?

Input: input_01.txt

 */

$sum_of_unmarked_numbers = 0;
$last_drawn_number = 0;
$last_winning_board = [];
$boards_count = count($boards);
$boards_won = [];

foreach ($numbers as $i => $number) {
    foreach ($boards as $j => $board) {
        if (in_array($j, $boards_won)) {
            continue;
        }
        markNumber($board, $number);
        $boards[$j] = $board;

        if ($i > 3) {
            $row_filled = checkRowWise($board);
            $column_filled = false;
            if (!$row_filled) {
                $column_filled = checkColumnWise($board);
            }
            if ($column_filled || $row_filled) {
                $boards_won[] = $j;
                if ($boards_count === count($boards_won)) {
                    $last_winning_board = $board;
                    break;
                }
            }
        }
    }
    if ((bool) count($last_winning_board)) {
        $last_drawn_number = $number;
        break;
    }
}

foreach ($last_winning_board as $row) {
    foreach ($row as $cell) {
        if ($cell['marked'] === 0) {
            $sum_of_unmarked_numbers += $cell['val'];
        }
    }
}

echo "\t Last Drawn Number: $last_drawn_number <|> Sum of Unmarked Numbers: $sum_of_unmarked_numbers\n";
echo "\t Final Score: " . ($sum_of_unmarked_numbers * $last_drawn_number) . "\n";
