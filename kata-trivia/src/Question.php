<?php


namespace Trivia;


class Question
{
    private $category;
    private $label;

    public function __construct(string $category, string $label)
    {
        $this->category = $category;
        $this->label = $label;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function category(): string
    {
        return $this->category;
    }
}