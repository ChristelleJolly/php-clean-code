<?php


namespace Trivia;


class QuestionList
{
    private $category;
    private $questions = [];
    private $current = 0;

    /**
     * QuestionList constructor.
     *
     * @param string $category
     */
    public function __construct(string $category)
    {
        $this->category = $category;
    }

    public function add(Question $question)
    {
        if ($question->category() != $this->category)
            throw new \InvalidArgumentException(sprintf("Can't ask category %s to list of category %s",
                $question->category(), $this->category));
        $this->questions[] = $question;
    }

    public function current(): Question
    {
        if (!isset($this->questions[$this->current]))
            throw new \OutOfBoundsException("No more question for category " . $this->category);
        return $this->questions[$this->current];
    }

    public function next()
    {
        $this->current++;
    }
}