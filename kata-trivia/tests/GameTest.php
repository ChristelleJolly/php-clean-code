<?php


namespace Tests;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Trivia\ConsoleWriter;
use Trivia\Dice;
use Trivia\Game;
use Trivia\QuestionDeckFactory;

class GameTest extends TestCase
{

    public function test()
    {
        $questions = QuestionDeckFactory::build(50);
        $aGame = new Game(new ConsoleWriter(), $questions);
        $aGame->add("Player 1");

        $messages = $aGame->messages();

        Assert::assertCount(2, $messages);
        Assert::assertEquals("Player 1 was added", $messages[0]);
        Assert::assertEquals("They are player number 1", $messages[1]);
    }
}