<?php


namespace Trivia;


class Dice
{
    private $value;

    /**
     * Dice constructor.
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function roll()
    {
        return new Dice(rand(0,5) + 1);
    }

    public function value(): int
    {
        return $this->value;
    }
}