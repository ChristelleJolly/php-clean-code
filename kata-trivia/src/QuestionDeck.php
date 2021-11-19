<?php


namespace Trivia;


class QuestionDeck
{

    /**
     * @var Question[]
     */
    private $questions;
    private $current = 0;

    public function __construct(Question ...$questions)
    {
        $this->questions = $questions;
    }

    public function current(string $category): Question
    {
        if (!isset($this->questions[$this->current]))
            throw new \OutOfBoundsException("No more question for category " . $category);
        return $this->questions[$this->current];
    }

    public function next(string $category)
    {
        $this->current++;
    }
}