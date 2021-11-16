<?php

require_once __DIR__.'/../vendor/autoload.php';

use Trivia\Game;
use Trivia\ConsoleWriter;

$notAWinner;

$aGame = new Game(new ConsoleWriter());

$aGame->add("Chet");
$aGame->add("Pat");
$aGame->add("Sue");


do {

    $aGame->turn(rand(0,5) + 1);

    if (rand(0,9) == 7) {
        $notAWinner = $aGame->wrongAnswer();
    } else {
        $notAWinner = $aGame->wasCorrectlyAnswered();
    }



} while ($notAWinner);