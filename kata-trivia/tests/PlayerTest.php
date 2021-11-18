<?php


namespace Tests;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function test_init_a_player()
    {
        $player = new Player("name");

        Assert::assertEquals("name", $player->name());
        Assert::assertEquals(0, $player->purse());
        Assert::assertEquals(0, $player->place());
        Assert::assertFalse($player->isInPenaltyBox());
    }

    public function test_move_a_player()
    {
        $player = new Player("name");

        $player->moveTo(5);

        Assert::assertEquals(5, $player->place());
    }

    public function test_should_not_move_to_negative_position()
    {
        $player = new Player("name");

        $this->expectException(\InvalidArgumentException::class);

        $player->moveTo(-5);
    }

    public function test_a_player_should_score()
    {
        $player = new Player("name");

        $player->score();
        $player->score();

        Assert::assertEquals(2, $player->purse());
    }

    public function test_a_player_should_go_to_the_penalty_box()
    {
        $player = new Player("name");

        $player->goToPenaltyBox();

        Assert::assertTrue($player->isInPenaltyBox());
    }
}