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
        return $this->questions[$this->current];
    }
}