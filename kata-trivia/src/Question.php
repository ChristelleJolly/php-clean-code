<?php


namespace Trivia;


class Question
{
    private $label;

    /**
     * Question constructor.
     * @param string $POP
     * @param string $string
     */
    public function __construct(string $POP, string $string)
    {
        $this->label = $string;
    }

    public function label(): string
    {
        return $this->label;
    }
}