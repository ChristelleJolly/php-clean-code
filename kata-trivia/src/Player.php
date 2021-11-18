<?php


namespace Trivia;


class Player
{

    private $name;
    private $place = 0;
    private $purse = 0;
    private $isInPenaltyBox = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
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
        return $this->isInPenaltyBox;
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
        $this->isInPenaltyBox = true;
    }

    public function exitPenaltyBox()
    {
        $this->isInPenaltyBox = false;
    }
}