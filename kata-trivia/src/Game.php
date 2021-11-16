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

    private $popQuestions;
    private $scienceQuestions;
    private $sportsQuestions;
    private $rockQuestions;

    private $isGettingOutOfPenaltyBox;

    const BOARD_SIZE = 12;

    const WINNING_SCORE = 6;

    public function __construct(Writer $writer)
    {
        $this->players = new Players();
        $this->writer = $writer;

        $this->popQuestions = array();
        $this->scienceQuestions = array();
        $this->sportsQuestions = array();
        $this->rockQuestions = array();

        for ($i = 0; $i < self::INIT_QUESTION_COUNT; $i++) {
            array_push($this->popQuestions, "Pop Question " . $i);
            array_push($this->scienceQuestions, ("Science Question " . $i));
            array_push($this->sportsQuestions, ("Sports Question " . $i));
            array_push($this->rockQuestions, $this->createRockQuestion($i));
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

    public function turn($roll)
    {
        $this->echoln($this->players->current() . " is the current player");
        $this->echoln("They have rolled a " . $roll);

        if ($this->players->current()->isInPenaltyBox()) {
            if ($this->rollIsOdd($roll)) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->echoln($this->players->current() . " is getting out of the penalty box");
                $this->movePlayer($roll);
                $this->askQuestion();
            } else {
                $this->echoln($this->players->current() . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }

        } else {
            $this->movePlayer($roll);
            $this->askQuestion();
        }

    }

    private function askQuestion()
    {
        $this->echoln("The category is " . $this->currentCategory());
        $question = $this->getQuestion($this->currentCategory());
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
     * @param $roll
     */
    private function movePlayer($roll): void
    {
        $position = $this->players->current()->place() + $roll;
        if ($position >= self::BOARD_SIZE)
            $position -= self::BOARD_SIZE;
        $this->players->current()->moveTo($position);

        $this->echoln($this->players->current()
            . "'s new location is "
            . $this->players->current()->place());
    }

    /**
     * @param $roll
     * @return bool
     */
    private function rollIsOdd($roll): bool
    {
        return $roll % 2 != 0;
    }

    private function getQuestion(string $currentCategory)
    {
        if ($currentCategory == Category::POP)
            return array_shift($this->popQuestions);
        if ($currentCategory == Category::SCIENCE)
            return array_shift($this->scienceQuestions);
        if ($currentCategory == Category::SPORTS)
            return array_shift($this->sportsQuestions);
        if ($currentCategory == Category::ROCK)
            return array_shift($this->rockQuestions);
    }
}
