<?php


namespace Tests;


class Player
{

    private $name;
    private $place = 0;
    private $purse = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

    public function purse()
    {
        return $this->purse;
    }

    public function place()
    {
        return $this->place;
    }

    public function isInPenaltyBox()
    {
        return false;
    }

    public function moveTo(int $place)
    {
        if ($place < 0)
            throw new \InvalidArgumentException("Place cannot be negative.");

        $this->place = $place;
    }

    public function score()
    {
        $this->purse++;
    }

    public function goToPenaltyBox()
    {
    }
}