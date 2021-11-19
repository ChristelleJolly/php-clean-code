<?php

require_once __DIR__.'/../vendor/autoload.php';

use Trivia\Dice;
use Trivia\Game;
use Trivia\ConsoleWriter;

$notAWinner;

$aGame = new Game(new ConsoleWriter());

$aGame->add("Chet");
$aGame->add("Pat");
$aGame->add("Sue");


do {

    $roll = Dice::roll();
    $aGame->turn($roll->value());

    if (rand(0,9) == 7) {
        $notAWinner = $aGame->wrongAnswer();
    } else {
        $notAWinner = $aGame->wasCorrectlyAnswered();
    }



} while ($notAWinner);