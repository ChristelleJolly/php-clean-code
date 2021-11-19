<?php


namespace Tests;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Trivia\Player;
use Trivia\Players;

class PlayersTest extends TestCase
{
    public function test_contains_no_player_on_empty_initialization()
    {
        $players = new Players();

        Assert::assertSame(0, $players->howManyPlayers());
    }

    public function test_should_add_players()
    {
        $players = new Players();

        $players->add(new Player('player 1'));

        Assert::assertSame(1, $players->howManyPlayers());
    }

    public function test_should_retrieve_first_player_when_getting_current_player_the_first_time()
    {
        $players = new Players();

        $players->add(new Player('player 1'));
        $players->add(new Player('player 2'));
        $players->add(new Player('player 3'));

        Assert::assertEquals("player 1", $players->current());
    }
}