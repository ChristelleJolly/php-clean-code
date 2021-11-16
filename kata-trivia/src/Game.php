<?php


namespace Trivia;

class Game
{
    private const INIT_QUESTION_COUNT = 50;
    private const MIN_PLAYER_COUNT = 2;
    protected $messages;

    /**
     * @var Players
     */
    private $players ;

    private $isGettingOutOfPenaltyBox;

    const BOARD_SIZE = 12;

    const WINNING_SCORE = 6;

    public function __construct(Writer $writer, ?QuestionDeck $questions = null)
    {
        $this->players = new Players();
        $this->writer = $writer;

        if ($questions == null) {
            $questions = [];

            for ($i = 0; $i < self::INIT_QUESTION_COUNT; $i++) {
                $questions = array_merge($questions, [
                    new Question(Category::POP, "Pop Question " . $i),
                    new Question(Category::SCIENCE, "Science Question " . $i),
                    new Question(Category::SPORTS, "Sports Question " . $i),
                    new Question(Category::ROCK, "Rock Question " . $i),
                ]);
            }

            $this->questions = new QuestionDeck(...$questions);
        }
        else {
            $this->questions = $questions;
        }
    }

    private function echoln($string)
    {
        $this->messages[] = $string;
        $this->writer->writeLine($string);
    }

    private function createRockQuestion($index)
    {
        return "Rock Question " . $index;
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
        return true;
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
        $currentCategory = $this->currentCategory();
        $this->echoln("The category is " . $currentCategory);
        $question = $this->questions->current($currentCategory)->label();
        $this->questions->next($currentCategory);
        $this->echoln($question);
    }


    private function currentCategory()
    {
        if ($this->players->current()->place() % 4 == 0) return Category::POP;
        if ($this->players->current()->place() % 4 == 1) return Category::SCIENCE;
        if ($this->players->current()->place() % 4 == 2) return Category::SPORTS;
        return Category::ROCK;
    }

    public function wasCorrectlyAnswered()
    {
        $winner = true;

        if (!$this->players->current()->isInPenaltyBox() || $this->isGettingOutOfPenaltyBox) {
            $this->echoln("Answer was correct!!!!");
            $this->players->current()->score();
            $this->echoln($this->players->current()
                . " now has "
                . $this->players->current()->purse()
                . " Gold Coins.");

            $winner = $this->didPlayerWin();
        }
        $this->players->next();
        return $winner;
    }

    public function wrongAnswer()
    {
        $this->echoln("Question was incorrectly answered");
        $this->echoln($this->players->current() . " was sent to the penalty box");
        $this->players->current()->goToPenaltyBox();

        $this->players->next();
        return true;
    }


    private function didPlayerWin()
    {
        return !($this->players->current()->purse() == self::WINNING_SCORE);
    }

    /**
     * @param $dice
     */
    private function movePlayer(Dice $dice): void
    {
        $position = $this->players->current()->place() + $dice->value();
        if ($position >= self::BOARD_SIZE)
            $position -= self::BOARD_SIZE;
        $this->players->current()->moveTo($position);

        $this->echoln($this->players->current()
            . "'s new location is "
            . $this->players->current()->place());
    }

}
