<?php


namespace Trivia;

class Game
{
    private const MIN_PLAYER_COUNT = 2;
    protected $messages;

    /**
     * @var Players
     */
    private $players ;

    private $isGettingOutOfPenaltyBox;

    const WINNING_SCORE = 6;

    /** @var QuestionDeck */
    private $questions;
    /**
     * @var Board
     */
    private $board;

    public function __construct( QuestionDeck $questions)
    {
        $this->players = new Players();
        $this->board = new Board(12, Category::all());
        $this->questions = $questions;
    }

    private function addMessage($string)
    {
        $this->messages[] = $string;
    }

    public function nextPlayer()
    {
        $this->players->next();
    }

    public function messages(): array
    {
        return $this->messages;
    }

    public function flushMessages()
    {
        $this->messages = [];
    }

    private function isPlayable()
    {
        return ($this->players->howManyPlayers() >= self::MIN_PLAYER_COUNT);
    }

    public function add($playerName)
    {
        $this->players->add(new Player($playerName));

        $this->addMessage($playerName . " was added");
        $this->addMessage("They are player number " . $this->players->howManyPlayers());
    }

    public function turn(Dice $dice)
    {
        $this->addMessage($this->players->current() . " is the current player");
        $this->addMessage("They have rolled a " . $dice->value());

        if ($this->players->current()->isInPenaltyBox()) {
            if ($dice->isOdd()) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->addMessage($this->players->current() . " is getting out of the penalty box");
                $this->movePlayer($dice);
                $this->askQuestion();
            } else {
                $this->addMessage($this->players->current() . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }

        } else {
            $this->movePlayer($dice);
            $this->askQuestion();
        }

    }

    private function askQuestion()
    {
        $currentCategory = $this->board->getCategory($this->players->current()->place());
        $this->addMessage("The category is " . $currentCategory);
        $question = $this->questions->current($currentCategory)->label();
        $this->questions->next($currentCategory);
        $this->addMessage($question);
    }


    public function wasCorrectlyAnswered()
    {
        if (!$this->players->current()->isInPenaltyBox() || $this->isGettingOutOfPenaltyBox) {
            $this->addMessage("Answer was correct!!!!");
            $this->players->current()->score();
            $this->addMessage($this->players->current()
                . " now has "
                . $this->players->current()->purse()
                . " Gold Coins.");
        }
    }

    public function wrongAnswer()
    {
        $this->addMessage("Question was incorrectly answered");
        $this->addMessage($this->players->current() . " was sent to the penalty box");
        $this->players->current()->goToPenaltyBox();
    }


    public function didPlayerWin()
    {
        return $this->players->current()->purse() == self::WINNING_SCORE;
    }

    /**
     * @param $dice
     */
    private function movePlayer(Dice $dice): void
    {
        $this->players->current()->moveTo($this->board->nextPosition($this->players->current()->place(), $dice->value()));
        $this->addMessage($this->players->current()
            . "'s new location is "
            . $this->players->current()->place());
    }

}
