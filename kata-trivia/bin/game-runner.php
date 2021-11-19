<?php

require_once __DIR__.'/../vendor/autoload.php';

use Trivia\Dice;
use Trivia\Game;
use Trivia\ConsoleWriter;
use Trivia\QuestionDeckFactory;

$notAWinner;

$questions = QuestionDeckFactory::build(50);

$aGame = new Game(new ConsoleWriter(), $questions);

$aGame->add("Chet");
$aGame->add("Pat");
$aGame->add("Sue");


do {

    $aGame->turn(Dice::roll());

    if (rand(0,9) == 7) {
        $notAWinner = $aGame->wrongAnswer();
    } else {
        $notAWinner = $aGame->wasCorrectlyAnswered();
    }



} while ($notAWinner);