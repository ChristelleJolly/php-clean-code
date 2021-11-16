<?php


namespace Trivia;

function echoln($string)
{
    echo $string . "\n";
}

class Game
{
    private const INIT_QUESTION_COUNT = 50;
    private const MIN_PLAYER_COUNT = 2;

    /**
     * @var array| Player[]
     */
    private $players = [];

    private $popQuestions;
    private $scienceQuestions;
    private $sportsQuestions;
    private $rockQuestions;

    private $currentPlayer = 0;
    private $isGettingOutOfPenaltyBox;

    const BOARD_SIZE = 12;

    const WINNING_SCORE = 6;

    public function __construct()
    {
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

    private function createRockQuestion($index)
    {
        return "Rock Question " . $index;
    }

    private function isPlayable()
    {
        return ($this->howManyPlayers() >= self::MIN_PLAYER_COUNT);
    }

    public function add($playerName)
    {
        array_push($this->players, new Player($playerName));

        echoln($playerName . " was added");
        echoln("They are player number " . count($this->players));
        return true;
    }

    private function howManyPlayers()
    {
        return count($this->players);
    }

    public function turn($roll)
    {
        echoln($this->players[$this->currentPlayer] . " is the current player");
        echoln("They have rolled a " . $roll);

        if ($this->players[$this->currentPlayer]->isInPenaltyBox()) {
            if ($this->rollIsOdd($roll)) {
                $this->isGettingOutOfPenaltyBox = true;

                echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
                $this->movePlayer($roll);
                $this->askQuestion();
            } else {
                echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }

        } else {
            $this->movePlayer($roll);
            $this->askQuestion();
        }

    }

    private function askQuestion()
    {
        echoln("The category is " . $this->currentCategory());
        $question = $this->getQuestion($this->currentCategory());
        echoln($question);
    }


    private function currentCategory()
    {
        if ($this->players[$this->currentPlayer]->place() % 4 == 0) return Category::POP;
        if ($this->players[$this->currentPlayer]->place() % 4 == 1) return Category::SCIENCE;
        if ($this->players[$this->currentPlayer]->place() % 4 == 2) return Category::SPORTS;
        return Category::ROCK;
    }

    public function wasCorrectlyAnswered()
    {
        $winner = true;

        if (!$this->players[$this->currentPlayer]->isInPenaltyBox() || $this->isGettingOutOfPenaltyBox) {
            echoln("Answer was correct!!!!");
            $this->players[$this->currentPlayer]->score();
            echoln($this->players[$this->currentPlayer]
                . " now has "
                . $this->players[$this->currentPlayer]->purse()
                . " Gold Coins.");

            $winner = $this->didPlayerWin();
        }
        $this->nextPlayer();
        return $winner;
    }

    public function wrongAnswer()
    {
        echoln("Question was incorrectly answered");
        echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
        $this->players[$this->currentPlayer]->goToPenaltyBox();

        $this->nextPlayer();
        return true;
    }


    private function didPlayerWin()
    {
        return !($this->players[$this->currentPlayer]->purse() == self::WINNING_SCORE);
    }

    /**
     * @param $roll
     */
    private function movePlayer($roll): void
    {
        $position = $this->players[$this->currentPlayer]->place() + $roll;
        if ($position >= self::BOARD_SIZE)
            $position -= self::BOARD_SIZE;
        $this->players[$this->currentPlayer]->moveTo($position);

        echoln($this->players[$this->currentPlayer]
            . "'s new location is "
            . $this->players[$this->currentPlayer]->place());
    }

    private function nextPlayer(): void
    {
        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
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
