<?php


namespace Trivia;


class Category
{
    const POP = "Pop";

    const SCIENCE = "Science";

    const SPORTS = "Sports";

    const ROCK = "Rock";

    public static function all(): array
    {
        return [self::POP, self::SCIENCE, self::ROCK, self::SPORTS];
    }
}