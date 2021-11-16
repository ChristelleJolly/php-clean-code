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
}