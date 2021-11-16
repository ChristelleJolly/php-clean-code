<?php


namespace Tests;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Trivia\Board;
use Trivia\Category;

class BoardTest extends TestCase
{

    public function test_should_give_category_by_position()
    {
        $categories = Category::all();
        $board = new Board(12, $categories);

        Assert::assertEquals($categories[0], $board->getCategory(0));
    }

    public function test_should_give_next_position_for_a_roll()
    {
        $categories = Category::all();
        $board = new Board(12, $categories);

        $start = 0;
        $roll = 4;
        $end = $board->nextPosition($start, $roll);
        Assert::assertEquals(4, $end);
    }

    public function test_should_loop_when_next_position_is_outside_the_board_for_a_roll()
    {
        $categories = Category::all();
        $board = new Board(12, $categories);

        $start = 8;
        $roll = 4;
        $end = $board->nextPosition($start, $roll);
        Assert::assertEquals(0, $end);
    }
}