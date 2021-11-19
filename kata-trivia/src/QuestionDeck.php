<?php


namespace Trivia;


class QuestionDeck
{

    /**
     * @var Question[]
     */
    private $questions = [];

    /**
     * @var QuestionList[]
     */
    private $categorizedQuestions = [];

    private $currents = [];

    public function __construct(Question ...$questions)
    {
        foreach ($questions as $question) {
            if (!isset($this->questions[$question->category()])) {
                $this->categorizedQuestions[$question->category()] = new QuestionList($question->category());
                $this->questions[$question->category()] = [];
                $this->currents[$question->category()] = 0;
            }
            $this->questions[$question->category()][] = $question;
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
        $this->currents[$category]++;
    }
}