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

    public function test_should_retrieve_messages_when_a_player_is_added()
    {
        $questions = QuestionDeckFactory::build(50);
        $aGame = new Game($questions);
        $aGame->add("Player 1");

        $messages = $aGame->messages();

        Assert::assertCount(2, $messages);
        Assert::assertEquals("Player 1 was added", $messages[0]);
        Assert::assertEquals("They are player number 1", $messages[1]);
    }

    public function test_should_not_retrieve_previous_messages_after_flushing_messages()
    {
        $questions = QuestionDeckFactory::build(50);
        $aGame = new Game($questions);
        $aGame->add("Player 1");

        $aGame->flushMessages();

        $aGame->add("Player 2");
        $messages = $aGame->messages();

        Assert::assertCount(2, $messages);
        Assert::assertEquals("Player 2 was added", $messages[0]);
        Assert::assertEquals("They are player number 2", $messages[1]);
    }
}