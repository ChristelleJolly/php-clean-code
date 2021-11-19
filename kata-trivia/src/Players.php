<?php


namespace Trivia;


class Players
{
    /**
     * @var array | Player[]
     */
    private $playerList = [];
    private $current = 0;

    /**
     * Players constructor.
     */
    public function __construct()
    {
    }

    public function howManyPlayers()
    {
        return count($this->playerList);
    }

    public function add(Player $player)
    {
        $this->playerList[] = $player;
    }

    public function current(): Player
    {
        return $this->playerList[$this->current];
    }
}