<?php


namespace Trivia;


class Question
{
    private $label;

    public function __construct(string $category, string $label)
    {
        $this->label = $label;
    }

    public function label(): string
    {
        return $this->label;
    }
}