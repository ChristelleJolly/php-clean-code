<?php


namespace Tests;


class Player
{

    private $name;

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
        return 0;
    }

    public function place()
    {
        return 0;
    }

    public function isInPenaltyBox()
    {
        return false;
    }

    public function moveTo($int)
    {
    }
}