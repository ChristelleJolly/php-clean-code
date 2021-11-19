<?php

require_once __DIR__.'/../vendor/autoload.php';

use Trivia\Dice;
use Trivia\Game;
use Trivia\ConsoleWriter;
use Trivia\QuestionDeckFactory;

$isWinner = false;

$questions = QuestionDeckFactory::build(50);

$writer = new ConsoleWriter();

$aGame = new Game($questions);

$aGame->add("Chet");
$aGame->add("Pat");
$aGame->add("Sue");

$writer->writeLines(...$aGame->messages());
$aGame->flushMessages();

do {

    $aGame->turn(Dice::roll());

    if (rand(0,9) == 7) {
        $aGame->wrongAnswer();
    } else {
        $aGame->wasCorrectlyAnswered();
    }

    $isWinner = $aGame->didPlayerWin();
    $aGame->nextPlayer();

    $writer->writeLines(...$aGame->messages());
    $aGame->flushMessages();

} while (!$isWinner);