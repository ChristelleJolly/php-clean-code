<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Trivia\Board;
use Trivia\Category;

class BoardTest extends TestCase
{

    public function test_should_give_category_by_position()
    {
        $board = new Board(12, Category::all());
    }
}