<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Trivia\Dice;

class DiceTest extends TestCase
{

    public function test_should_not_have_negative_value()
    {
        $this->expectException(\InvalidArgumentException::class);

        $dice = new Dice(-1);
    }

    public function test_should_not_be_above_six()
    {
        $this->expectException(\InvalidArgumentException::class);

        $dice = new Dice(7);
    }
}