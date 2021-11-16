<?php


namespace Trivia;


class Dice
{
    private const MIN_VALUE = 1;
    private const MAX_VALUE = 6;
    private $value;


    /**
     * Dice constructor.
     */
    public function __construct(int $value)
    {
        if ($value < self::MIN_VALUE || $value > self::MAX_VALUE)
            throw new \InvalidArgumentException(sprintf("Dice value must be between %d and %d",
                self::MIN_VALUE, self::MAX_VALUE));
        $this->value = $value;
    }

    public static function roll()
    {
        return new Dice(rand(self::MIN_VALUE, self::MAX_VALUE));
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isOdd(): bool
    {
        return $this->value % 2 != 0;
    }
}