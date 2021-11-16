<?php


namespace Tests;


use PHPUnit\Framework\Assert;
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

    public function test_should_signal_odd_values_when_value_is_odd()
    {
        $dice = new Dice(5);

        Assert::assertTrue($dice->isOdd());
    }

    public function test_should_signal_not_odd_values_when_value_is_even()
    {
        $dice = new Dice(4);

        Assert::assertFalse($dice->isOdd());
    }
}