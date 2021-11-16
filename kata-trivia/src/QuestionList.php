<?php


namespace Trivia;


class QuestionList
{
    private $category;

    /**
     * QuestionList constructor.
     *
     * @param string $category
     */
    public function __construct(string $category)
    {
        $this->category = $category;
    }
}