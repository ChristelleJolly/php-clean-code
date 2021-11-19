<?php


namespace Trivia;


class QuestionDeck
{

    /**
     * @var QuestionList[]
     */
    private $categorizedQuestions = [];

    public function __construct(Question ...$questions)
    {
        foreach ($questions as $question) {
            if (!isset($this->categorizedQuestions[$question->category()])) {
                $this->categorizedQuestions[$question->category()] = new QuestionList($question->category());
            }
            $this->categorizedQuestions[$question->category()]->add($question);
        }
    }

    public function current(string $category): Question
    {
        return $this->categorizedQuestions[$category]->current();
    }

    public function next(string $category)
    {
        $this->categorizedQuestions[$category]->next();
    }
}