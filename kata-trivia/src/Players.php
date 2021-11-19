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
        if (!isset($this->playerList[$this->current]))
            throw new \OutOfBoundsException("No player available");
        return $this->playerList[$this->current];
    }

    public function next()
    {
        $next = $this->current + 1;
        $this->current = $next >= $this->howManyPlayers() ? 0 : $next;
    }
}