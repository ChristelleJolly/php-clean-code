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

    const BOARD_SIZE = 12;
    const WINNING_SCORE = 6;

    /** @var Writer */
    private $writer;

    /** @var QuestionDeck */
    private $questions;

    public function __construct(Writer $writer, QuestionDeck $questions)
    {
        $this->players = new Players();
        $this->board = new Board(12, Category::all());
        $this->writer = $writer;
        $this->questions = $questions;
    }

    private function echoln($string)
    {
        $this->messages[] = $string;
        $this->writer->writeLine($string);
    }

    public function nextPlayer()
    {
        $this->players->next();
    }

    private function isPlayable()
    {
        return ($this->players->howManyPlayers() >= self::MIN_PLAYER_COUNT);
    }

    public function add($playerName)
    {
        $this->players->add(new Player($playerName));

        $this->echoln($playerName . " was added");
        $this->echoln("They are player number " . $this->players->howManyPlayers());
    }

    public function turn(Dice $dice)
    {
        $this->echoln($this->players->current() . " is the current player");
        $this->echoln("They have rolled a " . $dice->value());

        if ($this->players->current()->isInPenaltyBox()) {
            if ($dice->isOdd()) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->echoln($this->players->current() . " is getting out of the penalty box");
                $this->movePlayer($dice);
                $this->askQuestion();
            } else {
                $this->echoln($this->players->current() . " is not getting out of the penalty box");
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
        $this->echoln("The category is " . $currentCategory);
        $question = $this->questions->current($currentCategory)->label();
        $this->questions->next($currentCategory);
        $this->echoln($question);
    }


    public function wasCorrectlyAnswered()
    {
        if (!$this->players->current()->isInPenaltyBox() || $this->isGettingOutOfPenaltyBox) {
            $this->echoln("Answer was correct!!!!");
            $this->players->current()->score();
            $this->echoln($this->players->current()
                . " now has "
                . $this->players->current()->purse()
                . " Gold Coins.");
        }
    }

    public function wrongAnswer()
    {
        $this->echoln("Question was incorrectly answered");
        $this->echoln($this->players->current() . " was sent to the penalty box");
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
        $this->echoln($this->players->current()
            . "'s new location is "
            . $this->players->current()->place());
    }

}
