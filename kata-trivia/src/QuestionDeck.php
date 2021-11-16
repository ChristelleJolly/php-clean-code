<?php


namespace Trivia;


class QuestionDeck
{

    /**
     * @var Question[]
     */
    private $questions = [];

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
        }
    }

    public function current(string $category): Question
    {
        if (!isset($this->questions[$category][$this->currents[$category]]))
            throw new \OutOfBoundsException("No more question for category " . $category);
        return $this->questions[$category][$this->currents[$category]];
    }

    public function next(string $category)
    {
        $this->currents[$category]++;
    }
}